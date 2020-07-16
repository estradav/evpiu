<?php

namespace App\Http\Controllers\Productos\Clonador;

use App\CodLinea;
use App\CodTipoProducto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClonadorController extends Controller
{
    public function index(){
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
    }


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









                        /* Campos de Planificador */
                        'Pl_Dias_Pe'    => trim($q->PERDAY_01), // no se muestra pero se captura para la insersion de datos

                        /*checkbox*/

                        'Pl_ConComp'    => trim($q->PURCNV_01), // no se muestra pero se captura para la insersion de datos

                        /* Campos ControlEntregas*/
                        'Inv_UltTrans'  => trim($q->TNXDTE_01), // No se muestra  pero es necesario para el post
                        'Inv_ReqInsp'   => trim($q->INSRQD_01),
                        'Inv_ExcEnt'    => trim($q->EXCREC_01),
                        'Inv_Pes_Prom'  => number_format($q->WGT_01,2,'.',''),
                        'Inv_Udm_Pes'   => trim($q->WGTDEM_01),
                        'Inv_DiasVen'   => number_format($q->SHLIFE_01,0,'.',''),
                        'Inv_CtrLot'    => trim($q->LOTTRK_01),
                        'Inv_CtrNs'     => trim($q->SERTRK_01),
                        'Inv_MultEnt'   => trim($q->MULREC_01),
                        'Inv_LotCpd'    => trim($q->LOTSFC_01),
                        'Inv_NsCdp'     => trim($q->SNSFC_01),
                        'Inv_ReCod'     => trim($q->CYCCDE_01),
                        'Inv_TolMoney'  => number_format($q->CYCDOL_01,2,'.',''),
                        'Inv_TolPorc'   => number_format($q->CYCPER_01,0,'.',''),
                        'Inv_UltFecha'  => trim($q->CYCDTE_01),

                        /* Campos Contabilidad*/

                        'Cont_TipCost'  => trim($q->CSTTYP_01), /*No va pero se necesita para post*/

                        /*Otros campos*/
                        'CSTTYP_01' => trim($q->CSTTYP_01),
                        'LABOR_01'  => number_format($q->LABOR_01,2,'.',''),
                        'VOH_01'    => number_format($q->VOH_01,2,'.',''),
                        'FOH_01'    => number_format($q->FOH_01,2,'.',''),
                        'QUMMAT_01' => number_format($q->QUMMAT_01,2,'.',''),
                        'QUMLAB_01' => number_format($q->QUMLAB_01,2,'.',''),
                        'QUMVOH_01' => number_format($q->QUMVOH_01,2,'.',''),
                        'HRS_01'    => number_format($q->HRS_01,2,'.',''),
                        'QUMHRS_01' => number_format($q->QUMHRS_01,2,'.',''),
                        'PURUOM_01' => trim($q->PURUOM_01)
                    ];
                }
                return response()->json($results,200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }
}
