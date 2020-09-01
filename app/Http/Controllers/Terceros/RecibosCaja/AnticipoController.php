<?php

namespace App\Http\Controllers\Terceros\RecibosCaja;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Luecano\NumeroALetras\NumeroALetras;

class AnticipoController extends Controller
{
    public function index(){
        return view('aplicaciones.gestion_terceros.recibos_caja.anticipo');
    }

    public function store(Request $request){
        if ($request->ajax()){
            $q = $request->all();

            DB::beginTransaction();
            try {
                $id = DB::table('recibos_caja_anticipos')
                    ->insertGetId([
                        'client'        =>  $q['cliente'],
                        'nit'           =>  $q['nit'],
                        'total_paid'    =>  $q['valor'],
                        'date_paid'     =>  $q['fecha'],
                        'account_paid'  =>  $q['banco'],
                        'details'       =>  $q['detalles'],
                        'state'         =>  1,
                        'created_by'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                    ]);

                DB::commit();
                return response()
                    ->json('Anticipo '.$id.' guardado correctamente', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }


    public function change_state(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('recibos_caja_anticipos')
                    ->where('id','=', $request->id)
                    ->update([
                        'state' => $request->estado
                    ]);

                DB::commit();
                return response()->json('Datos guardados correctamente', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function consultar_anticipo(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('recibos_caja_anticipos')
                    ->where('id', '=', $request->id)
                    ->first();

                return response()
                    ->json($data, 200);

            }catch (\Exception $e){
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Ingresa el recibo de caja en DMS.
     * Tablas Insert: documentos, documentos_cruce, movimiento, documentos_che
     * Tablas Update: documentos, recibos_caja
     * las transacciones funcionan correctamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function finalizar_anticipo(Request $request){
        if ($request->ajax()){
            $enc = DB::table('recibos_caja_anticipos')
                ->where('id','=', $request->id)
                ->first();

            $numero_rc =  DB::connection('DMS')
                ->table('documentos')
                ->where('tipo','=', 'RCCO')
                ->max('numero');

            $vendedor_asociado = DB::connection('DMS')
                ->table('terceros')
                ->where('nit','=', $enc->nit)
                ->pluck('vendedor');


            $concepto_cliente = DB::connection('DMS')
                ->table('terceros')
                ->where('nit','=',$enc->nit)
                ->pluck('concepto_4')->first();



            DB::connection('DMS')->beginTransaction();
            try {
                DB::connection('DMS')
                    ->table('documentos')
                    ->insert([
                        'sw'                    =>  '5',
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'nit'                   =>  $enc->nit,
                        'fecha'                 =>  $enc->date_paid, /* crear input para fecha */
                        'vencimiento'           =>  $enc->date_paid, /*mismo valor de fecha*/
                        'valor_total'           =>  $enc->total_paid, /* valor pagado en RC*/
                        'retencion'             =>  0, /* retencion RC*/
                        'retencion_iva'         =>  0,
                        'retencion_ica'         =>  0,
                        'descuento_pie'         =>  0,
                        'iva_fletes'            =>  0,
                        'vendedor'              =>  intval($vendedor_asociado[0]), /* vendedor asociado a la factura*/
                        'valor_aplicado'        =>  0, /* valor pagado en RC*/
                        'anulado'               =>  0,
                        'modelo'                =>  1,
                        'notas'                 =>  $enc->details, /* comentarios del RC*/
                        'usuario'               =>  Auth::user()->username,
                        'pc'                    =>  gethostname(),
                        'fecha_hora'            =>  Carbon::now(),
                        'retencion2'            =>  '0',
                        'retencion3'            =>  '0',
                        'bodega'                =>  '1',
                        'duracion'              =>  '5',
                        'concepto'              =>  '1',
                        'centro_doc'            =>  '0',
                    ]);

                $concepto_cli = null;


                if ($concepto_cliente == '1'){
                    $concepto_cli = 13050505;
                }elseif ($concepto_cliente == '2' || $concepto_cliente == '4'){
                    $concepto_cli = 13052005;
                }


                DB::connection('DMS')
                    ->table('movimiento')
                    ->insert([
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'seq'                   =>  1,
                        'cuenta'                =>  $concepto_cli,
                        'centro'                =>  '0',
                        'nit'                   =>  $enc->nit,
                        'fec'                   =>  $enc->date_paid,
                        'valor'                 =>  -abs($enc->total_paid),
                        'documento'             =>  '1',
                    ]);


                DB::connection('DMS')
                    ->table('movimiento')
                    ->insert([
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'seq'                   =>  2,
                        'cuenta'                =>  $enc->account_paid,
                        'centro'                =>  0,
                        'nit'                   =>  0,
                        'fec'                   =>  $enc->date_paid,
                        'valor'                 =>  $enc->total_paid,
                        'documento'             =>  '1',
                        'explicacion'           =>  $enc->details,
                        'concilio'              =>  'S',
                    ]);



                $banco = DB::connection('DMS')
                    ->table('bancos')
                    ->where('cuenta','=',$enc->account_paid)
                    ->pluck('banco')->first();


                DB::connection('DMS')
                    ->table('documentos_che')
                    ->insert([
                        'sw'                    =>  '5',
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'banco'                 =>  $banco, //id banco
                        'documento'             =>  '1',
                        'forma_pago'            =>  '1', // vacio
                        'fecha'                 =>  $enc->date_paid,
                        'valor'                 =>  $enc->total_paid,
                        'consignar_en'          =>  $banco,
                    ]);

                DB::table('recibos_caja_anticipos')
                    ->where('id','=', $request->id)
                    ->update([
                        'state'     =>  3,
                        'rc_dms'    =>  $numero_rc+1
                    ]);

                $rc = $numero_rc+1;
                $formatter = new NumeroALetras;
                $valor_letras = $formatter->toMoney($enc->total_paid, 0, 'PESOS', 'CENTAVOS');

                DB::connection('DMS')
                    ->table('documentos_monto')
                    ->insert([
                        'tipo'      =>  'RCCO',
                        'numero'    =>  $numero_rc+1,
                        'monto'     =>  $valor_letras
                    ]);


                DB::connection('DMS')->commit();
                return response()
                    ->json('Anticipo ha sido finalizado y subido a DMS con el numero '.$rc, 200);
            }catch (\Exception $e){
                DB::connection('DMS')->rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }

    public function edit($id){

    }
}
