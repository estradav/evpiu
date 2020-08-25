<?php

namespace App\Http\Controllers\Productos\Clonador;

use App\CodLinea;
use App\CodTipoProducto;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClonadorController extends Controller
{
    /**
     * muestra una lista de codigos de max y
     * devuelve la informacion necesaria para
     * realizar la clonacion y creacion de productos
     *
     * @return RedirectResponse
     */
    public function index(){
        try {
            $data = DB::connection('MAX')
                ->table('Part_Master')
                ->select('Part_Master.PRTNUM_01 as id',
                    'Part_Master.PMDES1_01 as desc',
                    'Part_Master.CreationDate as CreationDate',
                    'Part_Master.ModificationDate as update',
                    'Part_Master.CreatedBy as Creado')
                ->orderBy('CreationDate','desc')
                ->take(1200)
                ->get();

            $tipo_productos = CodTipoProducto::orderBy('name', 'asc')
                ->get();

            $lineas = CodLinea::orderBy('name', 'asc')
                ->get();

            $compradores = DB::connection('MAX')
                ->table('Buyers')
                ->select('Buyers.BUYID_95 as id','Buyers.BUYNME_95 as name')
                ->get();

            $planificadores = DB::connection('MAX')
                ->table('Planners')
                ->select('Planners.PLNID_63 as id','Planners.NAME_63 as name')
                ->get();

            $almacen_preferido = DB::connection('MAX')
                ->table('Stock_Master')
                ->select('Stock_Master.STK_05 as id','Stock_Master.DESC_05 as name')
                ->get();

            $codigo_clase = DB::connection('MAX')
                ->table('Class_Codes')
                ->select('Class_Codes.CLSCDE_47 as id','Class_Codes.DESC_47 as name')
                ->get();

            $codigo_comodidad = DB::connection('MAX')
                ->table('Commodity_Codes')
                ->select('Commodity_Codes.COMCDE_48 as id','Commodity_Codes.DESC_48 as name')
                ->get();


            $tipo_cuenta = DB::connection('MAX')
                ->table('Account_Types')
                ->select('Account_Types.ACTTYP_104 as id','Account_Types.DESCRPTN_104 as name')
                ->get();

            return view('aplicaciones.productos.clonador.index',
                compact('data','tipo_productos', 'lineas', 'compradores', 'planificadores',
                    'almacen_preferido', 'codigo_clase', 'codigo_comodidad', 'tipo_cuenta'));

        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }

    }


    /**
     * obtiene la informacion del producto que va a ser clonado
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function obtener_info_producto_clonar(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::connection('MAX')
                    ->table('Part_Master')
                    ->where('Part_Master.PRTNUM_01', 'LIKE', '%'.$query.'%')
                    ->orWhere('Part_Master.PMDES1_01', 'LIKE', '%'.$query.'%')
                    ->take(30)
                    ->get();


                foreach ($queries as $q) {
                    $results[] = [
                        'id'                            => trim($q->PRTNUM_01),
                        'value'                         => trim($q->PRTNUM_01).' - '.trim($q->PMDES1_01),
                        'descripcion'                   => trim($q->PMDES1_01),


                        /*Campos pestaña maestro*/
                        'maestro_tipo_pieza'            => trim($q->TYPE_01),
                        'maestro_comprador'             => trim($q->BUYER_01),
                        'maestro_planificador'          => trim($q->PLANID_01),
                        'maestro_almacen_prefe'         => trim($q->DELSTK_01),
                        'maestro_umd_ldm'               => trim($q->BOMUOM_01),
                        'maestro_umd_costo'             => trim($q->WGTDEM_01),
                        'maestro_cod_clase'             => trim($q->CLSCDE_01),
                        'maestro_cod_comodidad'         => trim($q->COMCDE_01),
                        'maestro_inventario'            => number_format('0',0,'.',''),  // el inventario siempre comienza en 0,00
                        'maestro_costo_unit'            => number_format('0',2,'.',''), // el precio x unid siempre comienza en 0,00
                        'maestro_zona'                  => trim($q->DELLOC_01),
                        'maestro_nivel_revision'        => trim($q->REVLEV_01),
                        'maestro_tc_compras'            => trim($q->PURLT_01),
                        'maestro_tc_manufactura'        => trim($q->MFGLT_01),


                        /*Campos pestaña ingenieria*/
                        'ingenieria_numero_plano'       => trim($q->DRANUM_01),
                        'ingenieria_rendimiento'        => trim($q->YIELD_01),
                        'ingenieria_desecho'            => trim($q->SCRAP_01),
                        'ingenieria_estado_ingenieria'  => trim($q->STAENG_01),
                        'ingenieria_cbn'                => trim($q->LLC_01),


                        /*campos contabilidad*/
                        'contabilidad_tipo_cuenta'      => trim($q->ACTTYP_01),


                        /*campos planificador*/
                        'planificador_politica_orden'   => trim($q->ORDPOL_01),
                        'planificador_programa'         => trim($q->SCHFLG_01), //
                        'planificador_tc_critico'       => number_format($q->CRPHLT_01,0,'.',''),
                        'planificador_pdr'              => number_format($q->ROP_01,0,'.',''),
                        'planificador_cdr'              => number_format($q->ROQ_01,0,'.',''),
                        'planificador_inv_seguridad'    => number_format($q->SAFSTK_01,0,'.',''),
                        'planificador_plan_firme'       => trim($q->FRMPLN_01),
                        'planificador_ncnd'             => trim($q->NCNR_01),
                        'planificador_rump'             => trim($q->ROHS_01),
                        'planificador_pieza_critica'    => trim($q->SUPCDE_01),


                        /*campos fabricaciones*/
                        'fabricacion_tiempo_ciclo'      => trim($q->MFGLT_01),
                        'fabricacion_planear'           => trim($q->MFGPIC_01),
                        'fabricacion_fabricar'          => trim($q->MFGOPR_01),
                        'fabricacion_almacenar'         => trim($q->MFGSTK_01),


                        /*campos compras*/
                        'compras_tiempo_ciclo'          => trim($q->PURLT_01),
                        'compras_planear'               => trim($q->PURPIC_01),
                        'compras_comprar'               => trim($q->PUROPR_01),
                        'compras_almacenar'             => trim($q->PURSTK_01),


                        /*campos cantidad de orden*/
                        'cantidad_orden_promedio'       => number_format($q->AVEQTY_01,0,'.',''),
                        'cantidad_orden_minima'         => number_format($q->MINQTY_01,0,'.',''),
                        'cantidad_orden_maxima'         => number_format($q->MAXQTY_01,0,'.',''),
                        'cantidad_orden_multiple'       => number_format($q->MULQTY_01,0,'.',''),


                        /*campos inventario*/
                        'inventario_requiere_inspeccion'=> trim($q->INSRQD_01),
                        'inventario_exceso_entrada'     => trim($q->EXCREC_01),
                        'inventario_peso_promedio'      => number_format($q->WGT_01,2,'.',''),
                        'inventario_udm_peso'           => trim($q->WGTDEM_01),


                        /*campos seguimiento lotes/serial*/
                        'seguimiento_lote_dias_vence'   => number_format($q->SHLIFE_01,0,'.',''),
                        'seguimiento_lote_control_lote' => trim($q->LOTTRK_01),
                        'seguimiento_lote_control_ns'   => trim($q->SERTRK_01),
                        'seguimiento_lote_multi_entradas'   => trim($q->MULREC_01), //
                        'seguimiento_lote_lote_cdp'     => trim($q->LOTSFC_01),
                        'seguimiento_lote_ns_cdp'       => trim($q->SNSFC_01),


                        /*campos recuento ciclico*/
                        'recuento_ciclico_codigo'       => trim($q->CYCCDE_01),
                        'recuento_ciclico_tolerancia'   => number_format($q->CYCDOL_01,2,'.',''),
                        'recuento_ciclico_tolerancia_porcentaje'   => number_format($q->CYCPER_01,0,'.',''),



                        /*campos adicionales, estos campos no se
                        muestran pero se almacenan para el metodo store */
                        'CSTTYP_01' => trim($q->CSTTYP_01),
                        'LABOR_01'  => number_format($q->LABOR_01,2,'.',''),
                        'VOH_01'    => number_format($q->VOH_01,2,'.',''),
                        'FOH_01'    => number_format($q->FOH_01,2,'.',''),
                        'QUMMAT_01' => number_format($q->QUMMAT_01,2,'.',''),
                        'QUMLAB_01' => number_format($q->QUMLAB_01,2,'.',''),
                        'QUMVOH_01' => number_format($q->QUMVOH_01,2,'.',''),
                        'HRS_01'    => number_format($q->HRS_01,2,'.',''),
                        'QUMHRS_01' => number_format($q->QUMHRS_01,2,'.',''),
                        'PERDAY_01' => trim($q->PERDAY_01),
                        'PURCNV_01' => trim($q->PURCNV_01),
                        'TNXDTE_01' => trim($q->TNXDTE_01),
                        'CYCDTE_01' => trim($q->CYCDTE_01),
                        'PURUOM_01' => trim($q->PURUOM_01)
                    ];
                }
                return response()->json($results,200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * obtiene la informacion del producto creado por el codificador
     *
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function obtener_producto_codificador(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::table('cod_codigos')
                    ->where('cod_codigos.codigo','LIKE','%'.$query.'%')
                    ->orWhere('cod_codigos.descripcion','LIKE','%'.$query.'%')
                    ->take(20)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value'         =>  $q->codigo.' - '.$q->descripcion,
                        'codigo'        =>  $q->codigo,
                        'descripcion'   =>  $q->descripcion
                    ];
                }
                return response()->json($results, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * Guarda el registro en la base de datos de max (produccion)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request){
        if ($request->ajax()){
            try {
                DB::connection('MAX')->beginTransaction();

                $date = Carbon::now()->format('Ymd H:i:s');

                DB::connection('MAX')
                    ->table('Part_Master')
                    ->insert([
                        'PRTNUM_01' => $request->maestro_id_pieza,
                        'TYPE_01'   => $request->maestro_tipo_pieza,
                        'CLSCDE_01' => $request->maestro_codigo_clase,
                        'PLANID_01' => $request->maestro_planificador,
                        'COMCDE_01' => $request->maestro_codigo_comodidad,
                        'LLC_01'    => $request->ingenieria_cbn,
                        'PMDES1_01' => $request->maestro_descripcion,
                        'PMDES2_01' => '',
                        'BOMUOM_01' => $request->maestro_umd_ldm,
                        'STAENG_01' => $request->ingenieria_estado_ingenieria,
                        'STAACT_01' => '2',
                        'FRMPLN_01' => $request->planificador_plan_firme ? 'Y' : 'N',
                        'PRDDTE_01' => $date,
                        'WGTDEM_01' => $request->maestro_umd_costo,
                        'WGT_01'    => $request->inventario_peso_promedio,
                        'EXCDTE_01' => $date,
                        'EXCFLG_01' => 'N',
                        'DELSTK_01' => $request->maestro_almacen_preferido,
                        'CYCCDE_01' => $request->recuento_ciclico_codigo,
                        'CYCNUM_01' => '0',
                        'CYCPER_01' => $request->recuento_ciclico_tolerancia_porcentaje,
                        'OBSOLT_01' => '0',
                        'CYCOOT_01' => '0',
                        'ORDPOL_01' => $request->planificador_politica_orden,
                        'YIELD_01'  => $request->ingenieria_rendimiento,
                        'ROP_01'    => $request->planificador_pdr,
                        'ROQ_01'    => $request->planificador_cdr,
                        'SAFSTK_01' => $request->planificador_inventario_seguridad,
                        'MINQTY_01' => $request->cantidad_orden_minima,
                        'MAXQTY_01' => $request->cantidad_orden_maxima,
                        'MULQTY_01' => $request->cantidad_orden_multiple,
                        'AVEQTY_01' => $request->cantidad_orden_promedio,
                        'ISSMTD_01' => '0',
                        'ISSYTD_01' => '0',
                        'SALMTD_01' => '0',
                        'SALYTD_01' => '0',
                        'MFGLT_01'  => $request->maestro_tc_manufactura,
                        'MFGPIC_01' => $request->fabricacion_planear,
                        'MFGOPR_01' => $request->fabricacion_fabricar,
                        'MFGSTK_01' => $request->fabricacion_almacenar,
                        'PURLT_01'  => $request->compras_tiempo_ciclo,
                        'PURPIC_01' => $request->compras_planear,
                        'PUROPR_01' => $request->compras_comprar,
                        'PURSTK_01' => $request->compras_almacenar,
                        'PRICE_01'  => '0',
                        'COST_01'   => '0',
                        'CSTTYP_01' => $request->CSTTYP_01,
                        'CSTDTE_01' => $date,
                        'CSTUOM_01' => 'KG', /*validar*/
                        'CSTCNV_01' => '1',
                        'MATL_01'   => '0',
                        'LABOR_01'  => $request->LABOR_01,
                        'VOH_01'    => $request->VOH_01,
                        'FOH_01'    => $request->FOH_01,
                        'QUMMAT_01' => $request->QUMMAT_01,
                        'QUMLAB_01' => $request->QUMLAB_01,
                        'QUMVOH_01' => $request->QUMVOH_01,
                        'QUMFOH_01' => '0',
                        'HRS_01'    => $request->HRS_01,
                        'QUMHRS_01' => $request->QUMHRS_01,
                        'ALPHA_01'  => '0',
                        'QUMSUB_01' => '0',
                        'PURUOM_01' => $request->PURUOM_01,
                        'PURCNV_01' => $request->PURCNV_01,
                        'SCRAP_01'  => $request->ingenieria_desecho,
                        'BUYER_01'  => $request->maestro_comprador,
                        'INSRQD_01' => $request->inventario_requiere_inspeccion ? 'Y' : 'N',
                        'ONHAND_01' => '0',
                        'NONNET_01' => '0',
                        'SCHCDE_01' => 'B',
                        'REVLEV_01' => $request->maestro_nivel_rev,
                        'ACTTYP_01' => $request->contabilidad_tipo_cuenta_contable,
                        'ACTCDE_01' => '1',
                        'SCHFLG_01' => $request->planificador_programa,
                        'MPNFLG_01' => 'N',
                        'MATLXY_01' => '0',
                        'CRPHLT_01' => $request->planificador_tc_critico,
                        'LOTTRK_01' => $request->seguimiento_lote_control_lote ? 'Y' : 'N',
                        'MULREC_01' => $request->seguimiento_lote_multi_entradas ? 'Y' : 'N',
                        'SERTRK_01' => $request->seguimiento_lote_control_ns ? 'Y' : 'N',
                        'LOTSFC_01' => $request->seguimiento_lote_lote_cdp ? 'Y' : 'N',
                        'SHLIFE_01' => $request->seguimiento_lote_dias_vence,
                        'DRANUM_01' => $request->ingenieria_numero_plano,
                        'DELLOC_01' => $request->maestro_zona,
                        'PERDAY_01' => $request->PERDAY_01,
                        'ALLOC_01'  => '0',
                        'JOBEXP_01' => 'Y',
                        'RNDRQS_01' => 'N',
                        'EXCREC_01' => $request->inventario_exceso_entrada,
                        'INDDEM_01' => 'N',
                        'SUPCDE_01' => $request->planificador_pieza_critica ? 'Y' : 'N',
                        'CYCDOL_01' => $request->recuento_ciclico_tolerancia,
                        'STDVOH_01' => '0',
                        'XDFINT_01' => '0',
                        'XDFFLT_01' => '0',
                        'XDFDTE_01' => $date,
                        'CreatedBy' => 'evpiu-'.Auth::user()->username,
                        'CreationDate' => $date,
                        'SUBCST_01'    => '',
                        'CURREV_01' => '',
                        'RECVEN_01' => '',
                        'RTEREV_01' => '',
                        'VIEWER_01' => '',
                        'MCOMP_01'  => '',
                        'MSITE_01'  => '',
                        'UDFKEY_01' => '',
                        'UDFREF_01' => '',
                        'LSTECN_01' => '',
                        'ROHS_01'   => $request->planificador_rump ? 'Y' : 'N',
                        'NCNR_01'   => $request->planificador_ncnd ? 'Y' : 'N'
                    ]);

                DB::connection('MAX')
                    ->table('Activity_index')
                    ->insert([
                        'LLC_03'        => $request->ingenieria_cbn,
                        'PRTNUM_03'     => $request->maestro_id_pieza,
                        'BOMFLG_03'     => 'N',
                        'MPSFLG_03'     => 'N',
                        'MRPFLG_03'     => 'N',
                        'CSTFLG_03'     => 'N',
                        'PL1FLG_03'     => 'N',
                        'MCOMP_03'      => '',
                        'MSITE_03'      => '',
                        'UDFKEY_03'     => '',
                        'UDFREF_03'     => '',
                        'FILLER_03'     => '',
                        'CreatedBy'     => 'evpiu-'.Auth::user()->username,
                        'CreationDate'  => $date
                    ]);


                $product_structure = [];
                $estructuras_producto = DB::connection('MAX')
                    ->table('Product_Structure')
                    ->where('PARPRT_02','=', $request->cod_product_original)
                    ->get();


                foreach ($estructuras_producto as $ep){
                    $product_structure[] = [
                        'PARPRT_02'    => $request->maestro_id_pieza,
                        'COMPRT_02'    => $ep->COMPRT_02,
                        'EFFDTE_02'    => date('Ymd 00:00:00'),
                        'FILL01_02'    => $ep->FILL01_02,
                        'QTYPER_02'    => $ep->QTYPER_02,
                        'QTYCDE_02'    => $ep->QTYCDE_02,
                        'LTOSET_02'    => $ep->LTOSET_02,
                        'TYPCDE_02'    => $ep->TYPCDE_02,
                        'SCRAP_02'     => $ep->SCRAP_02,
                        'ECN_02'       => $ep->ECN_02,
                        'ACTDTE_02'    => $date,
                        'FILL02_02'    => $ep->FILL02_02,
                        'ALTPRT_02'    => $ep->ALTPRT_02,
                        'REFDES_02'    => $ep->REFDES_02,
                        'MPNSTR_02'    => $ep->MPNSTR_02,
                        'MCOMP_02'     => $ep->MCOMP_02,
                        'MSITE_02'     => $ep->MSITE_02,
                        'UDFKEY_02'    => $ep->UDFKEY_02,
                        'UDFREF_02'    => $ep->UDFREF_02,
                        'XDFINT_02'    => $ep->XDFINT_02,
                        'XDFFLT_02'    => $ep->XDFFLT_02,
                        'XDFBOL_02'    => $ep->XDFBOL_02,
                        'XDFDTE_02'    => '',
                        'XDFTXT_02'    => $ep->XDFTXT_02,
                        'FILLER_02'    => $ep->FILLER_02,
                        'CreatedBy'    => 'evpiu-'.Auth::user()->username,
                        'CreationDate' => $date,
                        'ModifiedBy'   => '',
                        'ModificationDate' => '',
                        'ALTCDE_02'    => ''
                    ];
                }


                DB::connection('MAX')
                    ->table('Product_Structure')
                    ->insert($product_structure);


                $part_routing_array = [];

                $part_routing = DB::connection('MAX')
                    ->table('Part_Routing')
                    ->where('PRTNUM_12','=', $request->cod_product_original)
                    ->get();

                foreach ($part_routing as $pr ){
                    $prting_array[] = [
                        'PRTNUM_12'     =>  $request->maestro_id_pieza,
                        'OPRSEQ_12'     =>  $pr->OPRSEQ_12,
                        'OPRID_12'      =>  $pr->OPRID_12,
                        'WRKCTR_12'     =>  $pr->WRKCTR_12,
                        'OPRDES_12'     =>  $pr->OPRDES_12,
                        'RUNTIM_12'     =>  $pr->RUNTIM_12,
                        'SETTIM_12'     =>  $pr->SETTIM_12,
                        'REVDTE_12'     =>  $date,
                        'FILL01_12'     =>  $pr->FILL01_12,
                        'OPRTYP_12'     =>  $pr->OPRTYP_12,
                        'STDTYP_12'     =>  $pr->STDTYP_12,
                        'QTYPER_12'     =>  $pr->QTYPER_12,
                        'TOOL_12'       =>  $pr->TOOL_12,
                        'SUBCST_12'     =>  $pr->SUBCST_12,
                        'PSCRAP_12'     =>  $pr->PSCRAP_12,
                        'ASCRAP_12'     =>  $pr->ASCRAP_12,
                        'SETEXT_12'     =>  $pr->SETEXT_12,
                        'SETINC_12'     =>  $pr->SETINC_12,
                        'MOVDAY_12'     =>  $pr->MOVDAY_12,
                        'APRDBY_12'     =>  $pr->APRDBY_12,
                        'EFFDTE_12'     =>  $date,
                        'MCOMP_12'      =>  $pr->MCOMP_12,
                        'MSITE_12'      =>  $pr->MSITE_12,
                        'UDFKEY_12'     =>  $pr->UDFKEY_12,
                        'UDFREF_12'     =>  $pr->UDFREF_12,
                        'SERVICEID_12'  =>  $pr->SERVICEID_12,
                        'PRIVENID_12'   =>  $pr->PRIVENID_12,
                        'RTGGRP_12'     =>  $pr->RTGGRP_12,
                        'XDFINT_12'     =>  $pr->XDFINT_12,
                        'XDFFLT_12'     =>  $pr->XDFFLT_12,
                        'XDFBOL_12'     =>  $pr->XDFBOL_12,
                        'XDFDTE_12'     =>  null,
                        'XDFTXT_12'     =>  $pr->XDFTXT_12,
                        'FILLER_12'     =>  $pr->FILLER_12,
                        'CreatedBy'     =>  'evpiu-'.Auth::user()->username,
                        'CreationDate'  =>  $date,
                        'ModifiedBy'    => '',
                        'ModificationDate' => '',
                        'ALTCDE_12'  => '',
                    ];
                }

                DB::connection('MAX')
                    ->table('Part_Routing')
                    ->insert($part_routing_array);


                $part_sales_array = [];
                $part_sales = DB::connection('MAX')
                    ->table('Part_Sales')
                    ->where('PRTNUM_29','=', $request->cod_product_original)
                    ->get();

                foreach ($part_sales as $ps) {
                    $part_sales_array[] = [
                        'PRTNUM_29'         => $request->maestro_id_pieza,
                        'SLSCAT_29'         => '',
                        'PMDES1_29'         => $request->maestro_descripcion,
                        'PMDES2_29'         => '',
                        'STK_29'            => $request->maestro_almacen_preferido,
                        'TAXABL_29'         => $ps->TAXABL_29,
                        'BOMUOM_29'         => $request->maestro_umd_ldm,
                        'SLSUOM_29'         => $ps->SLSUOM_29,    /*Hay que crear un input para este campo y poderlo editar desde el frontend*/
                        'SLSCNV_29'         => $ps->SLSCNV_29,   /*Hay que crear un input para este campo y poderlo editar desde el frontend*/
                        'PRICE_29'          => '0',
                        'BREAK1_29'         => '0',
                        'DISC1_29'          => '0',
                        'PRICE1_29'         => '0',
                        'BREAK2_29'         => '0',
                        'DISC2_29'          => '0',
                        'PRICE2_29'         => '0',
                        'BREAK3_29'         => '0',
                        'DISC3_29'          => '0',
                        'PRICE3_29'         => '0',
                        'BREAK4_29'         => '0',
                        'DISC4_29'          => '0',
                        'PRICE4_29'         => '0',
                        'BREAK5_29'         => '0',
                        'DISC5_29'          => '0',
                        'PRICE5_29'         => '0',
                        'BREAK6_29'         => '0',
                        'DISC6_29'          => '0',
                        'PRICE6_29'         => '0',
                        'BREAK7_29'         => '0',
                        'DISC7_29'          => '0',
                        'PRICE7_29'         => '0',
                        'BREAK8_29'         => '0',
                        'DISC8_29'          => '0',
                        'PRICE8_29'         => '0',
                        'BREAK9_29'         => '0',
                        'DISC9_29'          => '0',
                        'PRICE9_29'         => '0',
                        'QTYMTD_29'         => '0',
                        'SLSMTD_29'         => '0',
                        'CSTMTD_29'         => '0',
                        'QTYYTD_29'         => '0',
                        'SLSYTD_29'         => '0',
                        'CSTYTD_29'         => '0',
                        'QTYLYR_29'         => '0',
                        'SLSLYR_29'         => '0',
                        'CSTLYR_29'         => '0',
                        'QTYCOM_29'         => '0',
                        'CRTLTO_29'         => $request->planificador_tc_critico,
                        'AUTOMS_29'         => $ps->AUTOMS_29,
                        'APLDSC_29'         => $ps->APLDSC_29,
                        'PRDLIN_29'         => $ps->PRDLIN_29,
                        'HISFLG_29'         => $ps->HISFLG_29,
                        'WARFLG_29'         => $ps->WARFLG_29,
                        'LABWAR_29'         => '0',
                        'MATWAR_29'         => '0',
                        'RETMTD_29'         => '0',
                        'RETYTD_29'         => '0',
                        'UNWRPL_29'         => '0',
                        'UNWREP_29'         => '0',
                        'OUWRPL_29'         => '0',
                        'OUWREP_29'         => '0',
                        'COMMIS_29'         => '0',
                        'TAXCDE_29'         => $ps->TAXCDE_29,
                        'TAXCDE2_29'        => '',
                        'TAXCDE3_29'        => '',
                        'MCOMP_29'          => '',
                        'MSITE_29'          => '',
                        'UDFKEY_29'         => '',
                        'UDFREF_29'         => '',
                        'ALWBCK_29'         => $ps->ALWBCK_29,
                        'AUTOMF_29'         => $ps->AUTOMF_29,
                        'XDFINT_29'         => '0',
                        'XDFFLT_29'         => '0',
                        'XDFBOL_29'         => '0',
                        'XDFDTE_29'         => $date,
                        'XDFTXT_29'         => '',
                        'FILLER_29'         => '',
                        'CreatedBy'         => 'evpiu-'.Auth::user()->username,
                        'CreationDate'      => $date,
                        'ModifiedBy'        => '',
                        'ModificationDate'  => '',
                        'MANPRC_29'         => $ps->MANPRC_29,
                        'WARRES_29'         => $ps->WARRES_29
                    ];
                }

                DB::connection('MAX')
                    ->table('Part_Sales')
                    ->insert($part_sales_array);


                DB::connection('MAX')->commit();

                return response()->json('Producto creado con exito', 200);
            }catch (\Exception $e){
                DB::connection('MAX')->rollBack();

                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
