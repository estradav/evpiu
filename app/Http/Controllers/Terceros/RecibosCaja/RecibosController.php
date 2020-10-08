<?php

namespace App\Http\Controllers\Terceros\RecibosCaja;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Luecano\NumeroALetras\NumeroALetras;


class RecibosController extends Controller
{
    /**
     * Muestra una lista de recibos de
     * caja pertenecientes al usuario conectado.
     *
     * @return Factory|View
     */
    public function index(){
        if (Auth::user()->hasRole('super-admin')){
            $data = DB::table('recibos_caja')
                ->orderBy('id','desc')
                ->get();

            $data_ant = DB::table('recibos_caja_anticipos')
                ->orderBy('id','desc')
                ->get();

            $sum_rc = DB::table('recibos_caja')
                ->where('state', '=', '3')
                ->orderBy('id','desc')
                ->sum('total');
        }else{
            $data = DB::table('recibos_caja')
                ->where('created_by', '=', Auth::user()->username)
                ->orderBy('id','desc')
                ->get();

            $data_ant = DB::table('recibos_caja_anticipos')
                ->where('created_by', '=', Auth::user()->id)
                ->orderBy('id','desc')
                ->get();

            $sum_rc = DB::table('recibos_caja')
                ->where('created_by', '=', Auth::user()->username)
                ->where('state', '=', '3')
                ->orderBy('id','desc')
                ->sum('total');
        }
        return view('aplicaciones.gestion_terceros.recibos_caja.index',
            compact('data','sum_rc', 'data_ant'));
    }



    /**
     * Vista para la creacion de un recibo de caja
     *
     * @return Factory|View
     */
    public function create(){
        return view('aplicaciones.gestion_terceros.recibos_caja.create');
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
     * @param Request $request
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
                    ->orderBy('numero', 'asc')
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
            ->where('state','=', 2)
            ->get();

        $data_ant = DB::table('recibos_caja_anticipos')
            ->where('state','=', 2)
            ->get();

        return view('aplicaciones.gestion_terceros.recibos_caja.cartera', compact('data', 'data_ant'));
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
            return view('aplicaciones.gestion_terceros.recibos_caja.edit', compact('encabezado','final_array'));
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
     * Ingresa el recibo de caja en DMS.
     * Tablas Insert: documentos, documentos_cruce, movimiento, documentos_che
     * Tablas Update: documentos, recibos_caja
     * las transacciones funcionan correctamente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function finalizar_rc(Request $request){
        if ($request->ajax()){
            $enc = DB::table('recibos_caja')
                ->where('id','=', $request->id)
                ->first();

            $det = DB::table('recibos_caja_detalle')
                ->where('id_recibo','=', $request->id)
                ->orderBy('invoice', 'asc')
                ->get();

            $sum_bruto = DB::table('recibos_caja_detalle')
                ->where('id_recibo','=', $request->id)
                ->sum('bruto');

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

            $sum_otras_deduc = DB::table('recibos_caja_detalle')
                ->where('id_recibo','=', $request->id)
                ->sum('otras_deduc');

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
                        'fecha'                 =>  $enc->fecha_pago, /* crear input para fecha */
                        'condicion'             =>  null,
                        'vencimiento'           =>  $enc->fecha_pago, /*mismo valor de fecha*/
                        'valor_total'           =>  $enc->total, /* valor pagado en RC*/
                        'iva'                   =>  null,
                        'retencion'             =>  $sum_rete, /* retencion RC*/
                        'retencion_causada'     =>  null,
                        'retencion_iva'         =>  $sum_reteiva,
                        'retencion_ica'         =>  $sum_reteica,
                        'descuento_pie'         =>  $sum_descuento,
                        'fletes'                =>  null, /* otros ingresos */
                        'iva_fletes'            =>  gmp_neg(intval($sum_otros_ingr)),
                        'costo'                 =>  null,
                        'vendedor'              =>  intval($vendedor_asociado[0]), /* vendedor asociado a la factura*/
                        'valor_aplicado'        =>  $enc->total, /* valor pagado en RC*/
                        'anulado'               =>  '0',
                        'modelo'                =>  '1',
                        'documento'             =>  null, /* dejar en blanco*/
                        'notas'                 =>  $enc->comments, /* comentarios del RC*/
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
                        'fec'                   =>  $enc->fecha_pago,
                        'valor'                 =>  gmp_neg(intval($sum_bruto)),
                        'documento'             =>  '1',
                    ]);


                DB::connection('DMS')
                    ->table('movimiento')
                    ->insert([
                        'tipo'                  =>  'RCCO',
                        'numero'                =>  $numero_rc+1,
                        'seq'                   =>  2,
                        'cuenta'                =>  $enc->cuenta_pago,
                        'centro'                =>  0,
                        'nit'                   =>  0,
                        'fec'                   =>  $enc->fecha_pago,
                        'valor'                 =>  $sum_bruto + $sum_otros_ingr - $sum_descuento - $sum_otras_deduc - $sum_reteica - $sum_reteiva - $sum_rete,
                        'documento'             =>  '1',
                        'explicacion'           =>  $enc->comments,
                        'concilio'              =>  'S',
                    ]);


                $contador = 2;

                if ($sum_descuento > 0){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  53053505,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $sum_descuento,
                            'documento'             =>  '1',
                        ]);
                }
                if ($sum_otros_ingr > 0){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  42950505,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  gmp_neg(intval($sum_otros_ingr)),
                            'documento'             =>  '1',

                        ]);
                }
                if ($sum_reteica > 0){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  13551005,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $sum_reteica,
                            'documento'             =>  '1',
                        ]);

                }
                if ($sum_otras_deduc > 0 ){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  53059505,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $sum_otras_deduc,
                            'documento'             =>  '1',

                        ]);
                }
                if ($sum_reteiva > 0 ){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  24080590,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $sum_reteiva,
                            'documento'             =>  '1',
                        ]);
                }

                $rete_servicios = 0;
                $rete_venta = 0;
                foreach ($det as $f){
                    if ($sum_rete > 0){
                        $resultado = DB::connection('MAX')
                            ->table('invoice_master')
                            ->where('INVCE_31','=', '00'.$f->invoice)
                            ->pluck('REASON_31')->first();

                        if ($resultado == "24"){
                            $rete_servicios =  $rete_servicios + $f->retencion;
                        }else{
                            $rete_venta = $rete_venta + $f->retencion;
                        }
                    }


                    $tipo_documento = DB::connection('DMS')
                        ->table('documentos')
                        ->where('numero','=', $f->invoice)
                        ->whereIn('tipo', ['FP1','FP2','FP3','FP4','FP5','FP6','FAC'])
                        ->where('nit','=',$enc->nit)
                        ->pluck('tipo')->first();

                    $documento =  DB::connection('DMS')
                        ->table('documentos')
                        ->where('tipo','=', $tipo_documento)
                        ->where('numero','=', $f->invoice)
                        ->get(['fecha','valor_aplicado'])->first();

                    DB::connection('DMS')
                        ->table('documentos_cruce')
                        ->insert([
                            'tipo'          =>  'RCCO',
                            'numero'        =>  $numero_rc+1,
                            'sw'            =>  '1',
                            'tipo_aplica'   =>  $tipo_documento,
                            'numero_aplica' =>  $f->invoice,
                            'numero_cuota'  =>  '0',
                            'valor'         =>  $f->bruto - ($f->descuento + $f->retencion +  $f->reteiva + $f->reteica),
                            'descuento'     =>  $f->descuento,
                            'retencion'     =>  $f->retencion,
                            'retencion_iva' =>  $f->reteiva,
                            'retencion_ica' =>  $f->reteica,
                            'fecha'         =>  $documento->fecha,
                            'fecha_cruce'   =>  Carbon::now(),
                    ]);

                    DB::connection('DMS')
                        ->table('documentos')
                        ->where('tipo','=', $tipo_documento)
                        ->where('numero','=', $f->invoice)
                        ->update([
                            'valor_aplicado'    =>  $documento->valor_aplicado + $f->bruto
                        ]);
                }

                if ($rete_servicios > 0){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  13551520,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $rete_servicios,
                            'documento'             =>  '1',
                        ]);
                }

                if ($rete_venta > 0){
                    $contador+=1;
                    DB::connection('DMS')
                        ->table('movimiento')
                        ->insert([
                            'tipo'                  =>  'RCCO',
                            'numero'                =>  $numero_rc+1,
                            'seq'                   =>  $contador,
                            'cuenta'                =>  13551505,
                            'centro'                =>  0,
                            'nit'                   =>  $enc->nit,
                            'fec'                   =>  $enc->fecha_pago,
                            'valor'                 =>  $rete_venta,
                            'documento'             =>  '1',
                        ]);
                }


                $banco = DB::connection('DMS')
                    ->table('bancos')
                    ->where('cuenta','=',$enc->cuenta_pago)
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
                        'fecha'                 =>  $enc->fecha_pago,
                        'valor'                 =>  $enc->total,
                        'consignar_en'          =>  $banco,
                        'devuelto'              =>  null,
                        'tipo_consignacion'     =>  null,
                        'numero_consignacion'   =>  null,
                        'fecha_devolucion'      =>  null,
                        'cuenta_banco'          =>  null,
                        'iva_tarjeta'           =>  null,
                        'notas'                 =>  null,
                        'fecha_forma'           =>  null,
                        'tipo_devuelto'         =>  null,
                        'numero_devuelto'       =>  null
                    ]);

                DB::table('recibos_caja')
                    ->where('id','=', $request->id)
                    ->update([
                        'state'     =>  '3',
                        'rc_dms'    =>  $numero_rc+1
                    ]);

                $rc = $numero_rc+1;
                $formatter = new NumeroALetras;
                $valor_letras = $formatter->toMoney($enc->total, 0, 'PESOS', 'CENTAVOS');

                DB::connection('DMS')
                    ->table('documentos_monto')
                    ->insert([
                        'tipo'      =>  'RCCO',
                        'numero'    =>  $numero_rc+1,
                        'monto'     =>  $valor_letras
                    ]);


                DB::connection('DMS')->commit();
                return response()->json('RC ha sido finalizado y subido a DMS con el numero '.$rc, 200);
            }catch (\Exception $e){
                DB::connection('DMS')->rollBack();
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
                    ->where('nit', '=', $request->nit)
                    ->where('numero','=', $request->id)
                    ->first();

                return response()->json($consulta, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    public function datos_rc_informe(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('recibos_caja')
                    ->where('created_by','=', Auth::user()->username)
                    ->where('state', '=', '3')
                    ->whereBetween('created_at', [$request->star_date, $request->end_date])
                    ->get();

                $sum_rc = DB::table('recibos_caja')
                    ->where('created_by', '=', Auth::user()->username)
                    ->where('state', '=', '3')
                    ->whereBetween('created_at', [$request->star_date, $request->end_date])
                    ->sum('total');

                return response()->json(['rc' => $data, 'total' => $sum_rc], 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);

            }
        }
    }
}
