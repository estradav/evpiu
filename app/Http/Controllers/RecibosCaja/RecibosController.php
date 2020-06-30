<?php

namespace App\Http\Controllers\RecibosCaja;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Array_;

class RecibosController extends Controller
{
    /**
     * Muestra una lista de recibos de
     * caja pertenecientes al usuario conectado.
     *
     * @return Factory|View
     */
    public function index(){
        $user = Auth::user()->username;

        $data = DB::table('recibos_caja')
            ->where('created_by', '=', $user)
            ->get();
        return view('aplicaciones.recibos_caja.index', compact('data'));
    }



    /**
     * Vista para la creacion de un recibo de caja
     *
     * @return Factory|View
     */
    public function create(){
        return view('aplicaciones.recibos_caja.create');
    }



    /**
     * Busqueda de clientes
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function buscar_cliente(Request $request){
        if ($request->ajax()) {
            $query = $request->get('query');
            $results = array();

            $queries = DB::connection('DMS')
                ->table('V_CIEV_Clientes')
                ->where('nombres', 'LIKE', '%' . $query . '%')
                ->orWhere('nit', 'LIKE', '%' . $query . '%')
                ->take(20)
                ->get();

            foreach ($queries as $q) {
                $results[] = [
                    'value' => trim($q->nombres),
                    'nit' => trim($q->nit),
                ];
            }
            return response()->json($results);
        }
    }


    /**
     * Consulta de facturas pendientes por cliente
     * Cuyo saldo pendiente sea mayor a 0
     *
     * @return JsonResponse
     */
    public function consultar_recibos_cliente(Request $request){
        if ($request->ajax()) {
            $nit = $request->get('nit');

            try {
                $consulta = DB::connection('DMS')
                    ->table('V_CIEV_Saldofacturas')
                    ->where('nit', '=', $nit)
                    ->where('saldo', '>', 0)
                    ->get();
                return response()->json($consulta, 200);

            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Guarda un recibo de caja segun el estado escogido por
     * el usuario 1 para dejar en borrador y 2 para enviar
     * directamente a cartera
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_recibo_caja(Request $request){
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                $id_enc = DB::table('recibos_caja')
                    ->insertGetId([
                        'customer'      => $request['encabezado']['cliente'],
                        'nit'           => $request['encabezado']['nit_cliente'],
                        'total'         => $request['encabezado']['total'],
                        'comments'      => $request['encabezado']['comentarios'],
                        'created_by'    => Auth::user()->username,
                        'state'         => $request['encabezado']['estado'],
                        'fecha_pago'    => $request['encabezado']['fecha_pago'],
                        'cuenta_pago'   => $request['encabezado']['cuenta_pago'],
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                    ]);

                foreach ($request['items'] as $item) {
                    DB::table('recibos_caja_detalle')
                        ->insert([
                            'id_recibo' => $id_enc,
                            'invoice' => $item['factura'],
                            'bruto' => $item['bruto'],
                            'descuento' => $item['descuento'],
                            'retencion' => $item['retencion'],
                            'reteiva' => $item['reteiva'],
                            'reteica' => $item['reteica'],
                            'otras_deduc' => $item['otras_dedu'],
                            'otros_ingre' => $item['otros_ingre'],
                            'total' => $item['total'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);

                }

                DB::commit();

                return response()->json('Datos guardados correctamente', 200);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Vista para el area de cartera
     *
     * @return Factory|View
     */
    public function cartera(){
        $data = DB::table('recibos_caja')
            ->where('state','=', [2,3])
            ->get();

        return view('aplicaciones.recibos_caja.cartera', compact('data'));
    }



    /**
     * Cambia estado de los recibos de caja
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cambiar_estado(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('recibos_caja')
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



    /**
     * edicion de recibos de caja
     *
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id){
        $encabezado = DB::table('recibos_caja')
            ->where('id','=',$id)
            ->first();

        $detalles =  DB::table('recibos_caja_detalle')
            ->where('id_recibo','=',$id)
            ->orderBy('invoice','asc')
            ->get()->toArray();

        $facturas_pendientes = DB::connection('DMS')
            ->table('V_CIEV_Saldofacturas')
            ->where('nit','=', $encabezado->nit)
            ->where('saldo', '>', 0)
            ->orderBy('numero','asc')
            ->get()->toArray();

        if ($encabezado->state == 2){
            return redirect()
                ->route('recibos_caja.index')
                ->with([
                    'message'    => 'No puedes editar un RC si esta en cartera.',
                    'alert-type' => 'error'
                ]);
        }else if ($encabezado->state == 3){
            return redirect()
                ->route('recibos_caja.index')
                ->with([
                    'message'    => 'No puedes editar un RC si esta finalizado.',
                    'alert-type' => 'error'
                ]);
        }else if($encabezado->state == 0){
            return redirect()
                ->route('recibos_caja.index')
                ->with([
                    'message'    => 'No puedes editar un RC si esta anulado.',
                    'alert-type' => 'error'
                ]);
        }else{
            function left_join_array($left, $right, $left_join_on, $right_join_on = NULL){
                $final= array();

                if(empty($right_join_on))
                    $right_join_on = $left_join_on;

                foreach($left AS $k => $v){
                    $final[$k] = $v;
                    foreach($right AS $kk => $vv){
                        if(trim($v->$left_join_on) == trim($vv->$right_join_on)){
                            foreach($vv AS $key => $val)
                                $final[$k]->$key = $val;
                        }
                    }
                }
                return $final;
            }

            $final_array = left_join_array($facturas_pendientes, $detalles, 'numero', 'invoice');
            return view('aplicaciones.recibos_caja.edit', compact('encabezado','final_array'));
        }
    }



    /**
     * guardar edicion de recibo de caja
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_recibo_caja_edit(Request $request){
        if ($request->ajax()) {
            DB::beginTransaction();
            try {
                DB::table('recibos_caja')
                    ->where('id', '=', $request['encabezado']['id_rc'])
                    ->update([
                        'total'         => $request['encabezado']['total'],
                        'comments'      => $request['encabezado']['comentarios'],
                        'fecha_pago'    => $request['encabezado']['fecha_pago'],
                        'cuenta_pago'   => $request['encabezado']['cuenta_pago'],
                        'state'         => '1',
                        'updated_at'    => Carbon::now()
                    ]);

                foreach ($request['items'] as $item) {
                    if ($item['id_itm'] == null) {
                        DB::table('recibos_caja_detalle')
                            ->insert([
                                'id_recibo'     => $request['encabezado']['id_rc'],
                                'invoice'       => $item['factura'],
                                'bruto'         => $item['bruto'],
                                'descuento'     => $item['descuento'],
                                'retencion'     => $item['retencion'],
                                'reteiva'       => $item['reteiva'],
                                'reteica'       => $item['reteica'],
                                'otras_deduc'   => $item['otras_dedu'],
                                'otros_ingre'   => $item['otros_ingre'],
                                'total'         => $item['total'],
                                'created_at'    => Carbon::now(),
                                'updated_at'    => Carbon::now()
                            ]);

                    } else {
                        DB::table('recibos_caja_detalle')
                            ->where('id', '=', $item['id_itm'])
                            ->update([
                                'bruto'         => $item['bruto'],
                                'descuento'     => $item['descuento'],
                                'retencion'     => $item['retencion'],
                                'reteiva'       => $item['reteiva'],
                                'reteica'       => $item['reteica'],
                                'otras_deduc'   => $item['otras_dedu'],
                                'otros_ingre'   => $item['otros_ingre'],
                                'total'         => $item['total'],
                                'updated_at'    => Carbon::now()
                            ]);
                    }
                }
                DB::commit();

                return response()->json('Datos guardados correctamente', 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * consulta un recibo de caja y sus detalles
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function consultar_recibo(Request $request){
        if ($request->ajax()){
            try {
                $encabezado = DB::table('recibos_caja')
                    ->where('id','=', $request->id)
                    ->first();

                $detalle = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->orderBy('invoice', 'asc')
                    ->get();

                return response()->json(['enc' =>$encabezado, 'det' => $detalle],200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * consulta el tipo de venta por factura, para realizar el calculo de la retefuente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function consultar_tipo_venta(Request $request){
        if ($request->ajax()){
            $factura = '00'.$request->id;

            try {
                $resultado = DB::connection('MAX')
                    ->table('invoice_master')
                    ->where('INVCE_31','=',$factura)
                    ->pluck('REASON_31');

                return response()->json($resultado, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Ingresa el recibo de caja en DMS
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function finalizar_rc(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $enc = DB::table('recibos_caja')
                    ->where('id','=', $request->id)
                    ->first();

                $det = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->orderBy('invoice', 'asc')
                    ->get();

                $sum_rete = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->sum('retencion');

                $sum_reteiva = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->sum('reteiva');

                $sum_reteica = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->sum('reteica');

                $sum_descuento = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->sum('descuento');

                $sum_otros_ingr = DB::table('recibos_caja_detalle')
                    ->where('id_recibo','=', $request->id)
                    ->sum('otros_ingre');

                $numero_rc =  DB::connection('FE')
                    ->table('documentos')
                    ->where('tipo','=', 'RCCO')
                    ->max('numero');

                $vendedor_asociado = DB::connection('FE')
                    ->table('terceros')
                    ->where('nit','=', $enc->nit)
                    ->pluck('vendedor');


                $concepto_cliente = DB::connection('FE')
                    ->table('terceros')
                    ->where('nit','=',$enc->nit)
                    ->pluck('concepto_4');


                DB::connection('FE')
                    ->table('documentos')
                    ->insert([
                        'sw'                    =>  '5',
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'nit'                   =>  $enc->nit,
                        'fecha'                 =>  $enc->fecha_pago, /* crear input para fecha */
                        'condicion'             =>  null,
                        'vencimiento'           =>  Carbon::now(), /*mismo valor de fecha*/
                        'valor_total'           =>  $enc->total, /* valor pagado en RC*/
                        'iva'                   =>  null,
                        'retencion'             =>  $sum_rete, /* retencion RC*/
                        'retencion_causada'     =>  null,
                        'retencion_iva'         =>  $sum_reteiva,
                        'retencion_ica'         =>  $sum_reteica,
                        'descuento_pie'         =>  '',
                        'fletes'                =>  $sum_otros_ingr, /* otros ingresos */
                        'iva_fletes'            =>  null,
                        'costo'                 =>  null,
                        'vendedor'              =>  intval($vendedor_asociado[0]), /* vendedor asociado a la factura*/
                        'valor_aplicado'        =>  $enc->total, /* valor pagado en RC*/
                        'anulado'               =>  '0',
                        'modelo'                =>  '1',
                        'documento'             =>  '', /* dejar en blanco*/
                        'notas'                 =>  $enc->comments, /* comentarios del RC*/
                        'usuario'               =>  Auth::user()->username,
                        'pc'                    =>  gethostname(),
                        'fecha_hora'            =>  Carbon::now(),
                        'retencion2'            =>  '0',
                        'retencion3'            =>  '0',
                        'bodega'                =>  '1',
                        'impoconsumo'           =>  null,
                        'descuento2'            =>  null,
                        'duracion'              =>  '5',
                        'concepto'              =>  '1',
                        'vencimiento_presup'    =>  null,
                        'exportado'             =>  null,
                        'impuesto_deporte'      =>  null,
                        'prefijo'               =>  null,
                        'moneda'                =>  null,
                        'tasa'                  =>  null,
                        'centro_doc'            =>  '0',
                        'valor_mercancia'       =>  null,
                        'numero_cuotas'         =>  null,
                        'codigo_direccion'      =>  null,
                        'descuento_1'           =>  null,
                        'descuento_2'           =>  null,
                        'descuento_3'           =>  null,
                        'abono'                 =>  null,
                        'fecha_consignacion'    =>  null,
                        'ajuste'                =>  null,
                        'concepto_Retencion'    =>  null,
                        'porc_RteFuente'        =>  null,
                        'porc_RteIva'           =>  null,
                        'porc_RteIvaSimpl'      =>  null,
                        'porc_RteIca'           =>  null,
                        'porc_RteA'             =>  null,
                        'porc_RteB'             =>  null,
                        'bodega_ot'             =>  null,
                        'numero_ot'             =>  null,
                        'porc_RteCree'          =>  null,
                        'retencion_cree'        =>  null,
                        'codigo_retencion_cree' =>  null,
                        'cree_causado'          =>  null,
                        'provision'             =>  null,
                        'numincapacidad'        =>  null,
                        'idincapacidad'         =>  null
                    ]);


                $contador = 2;

                if($sum_rete > 0){
                    $contador++;
                }if($sum_reteiva > 0){
                    $contador++;
                }if($sum_reteica > 0){
                    $contador++;
                }if($sum_otros_ingr > 0){
                    $contador++;
                }


                for($i = 1; $i <= $contador; $i++){
                    if ($i == 1){
                        $concepto_cli = null;

                        if ($concepto_cliente == 1){
                            $concepto_cli = 13050505;
                        }elseif ($concepto_cliente == 2 || $concepto_cliente == 4){
                            $concepto_cli = 13052005;
                        }

                        DB::connection('FE')
                            ->table('movimiento')
                            ->insert([
                                'tipo'                  =>  'RCCO',
                                'numero'                =>  $numero_rc+1,
                                'seq'                   =>  1,
                                'cuenta'                =>  $concepto_cli,
                                'centro'                =>  '0',
                                'nit'                   =>  $enc->nit,
                                'fec'                   =>  $enc->fecha_pago,
                                'valor'                 =>  $enc->total,
                                'base'                  =>  null,
                                'documento'             =>  '1',
                                'explicacion'           =>  null,
                                'concilio'              =>  null,
                                'concepto_mov'          =>  null,
                                'concilio_ano'          =>  null,
                                'forma_pago'            =>  null,
                                'secuencia_extracto'    =>  null,
                                'ano_concilia'          =>  null,
                                'mes_concilia'          =>  null,
                                'ID_CRUCE'              =>  null,
                                'TIPO_CRUCE'            =>  null
                            ]);

                        /*consultar tabla terceros concepto_4 cuando el cliente es 1 = 13050505 si es 2 = 13052005 si es 4 = 13052005 */

                    }elseif ($i == 2){
                        DB::connection('FE')
                            ->table('movimiento')
                            ->insert([
                                'tipo'                  =>  'RCCO',
                                'numero'                =>  $numero_rc+1,
                                'seq'                   =>  2,
                                'cuenta'                =>  $enc->cuenta_pago,
                                'centro'                =>  '0',
                                'nit'                   =>  '0',
                                'fec'                   =>  $enc->fecha_pago,
                                'valor'                 =>  $enc->total,
                                'base'                  =>  null,
                                'documento'             =>  '1',
                                'explicacion'           =>  $enc->comments,
                                'concilio'              =>  'S',
                                'concepto_mov'          =>  null,
                                'concilio_ano'          =>  null,
                                'forma_pago'            =>  null,
                                'secuencia_extracto'    =>  null,
                                'ano_concilia'          =>  null,
                                'mes_concilia'          =>  null,
                                'ID_CRUCE'              =>  null,
                                'TIPO_CRUCE'            =>  null
                            ]);
                    }

                    if ($sum_descuento > 0 && $i == 3){

                    }
                }





                /*DB::connection('FE')
                    ->table('documentos_cruce')
                    ->insert([
                        'tipo'          =>  '',
                        'numero'        =>  '',
                        'sw'            =>  '',
                        'tipo_aplica'   =>  '',
                        'numero_aplica' =>  '',
                        'numero_cuota'  =>  '',
                        'valor'         =>  '',
                        'descuento'     =>  '',
                        'retencion'     =>  '',
                        'ajuste'        =>  '',
                        'retencion_iva' =>  '',
                        'retencion_ica' =>  '',
                        'fecha'         =>  '',
                        'retencion2'    =>  '',
                        'retencion3'    =>  '',
                        'trasporte'     =>  '',
                        'fecha_cruce'   =>  '',
                        'id'            =>  '',
                        'cree'          =>  ''
                    ]);*/


                DB::commit();
                return response()->json('RC subido a DMS');
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * consulta los recibos de caja por documento de identidad o nit
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function consultar_documento (Request $request){
        if ($request->ajax()){
            try {
                $consulta = DB::connection('DMS')
                    ->table('V_CIEV_Saldofacturas')
                    ->where('numero','=', $request->id)
                    ->first();

                return response()->json($consulta, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
