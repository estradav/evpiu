<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\New_;
use Psr\Log\NullLogger;
use Yajra\DataTables\DataTables;

class CreateProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::connection('MAX')
                ->table('Part_Master')
                ->select('Part_Master.PRTNUM_01 as id',
                    'Part_Master.PMDES1_01 as desc',
                    'Part_Master.CreationDate as CreationDate',
                    'Part_Master.ModificationDate as update',
                    'Part_Master.CreatedBy as Creado')->orderBy('CreationDate','desc')->take(1200)
                ->get();

            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editsublinea" id="edit-btn">Editar</a>';
                    return $btn;
                })
                ->editColumn('CreationDate', function ($data) {
                    return  \Carbon\Carbon::parse($data->CreationDate)->diffForHumans();
                })
                ->editColumn('update', function ($data) {
                    return Carbon::parse($data->update)->diffForHumans();
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Creador_Productos.Index');
    }

    public  function SearchProducts(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('MAX')->table('Part_Master')
            ->where('Part_Master.PRTNUM_01', 'LIKE', '%'.$query.'%')
            ->orWhere('Part_Master.PMDES1_01', 'LIKE', '%'.$query.'%')->take(20)
            ->get();

        foreach ($queries as $q)
        {
            $results[] = [
                'id'            => trim($q->PRTNUM_01),
                'value'         => trim($q->PRTNUM_01).' - '.trim($q->PMDES1_01),
                'prueba'        => trim($q->PRTNUM_01),
                'descrip'       => trim($q->PMDES1_01),
                't_pieza'       => trim($q->TYPE_01),
                'Umd_Ldm'       => trim($q->BOMUOM_01),
                'Umd_Cos'       => trim($q->WGTDEM_01),
                'Cod_Clase'     => trim($q->CLSCDE_01),
                'Alm_Pref'      => trim($q->DELSTK_01),
                'Cos_Und'       => number_format('0',2,'.',''), // el precio x unid siempre comienza en 0,00
                'M_Inv'         => number_format('0',0,'.',''),  // el inventario siempre comienza en 0,00
                'M_Zona'        => trim($q->DELLOC_01),
                'M_Planif'      => trim($q->PLANID_01),
                'Niv_Rev'       => trim($q->REVLEV_01),
                'Cod_Comd'      => trim($q->COMCDE_01),
                'M_Compr'       => trim($q->BUYER_01),
                'M_Rend'        => trim($q->YIELD_01),
                'Tc_Manu'       => trim($q->MFGLT_01),
                'TC_Comp'       => trim($q->PURLT_01),

                    /* Campos de Ingenieria */
                'Ig_PorcDes'    => trim($q->SCRAP_01),
                'Ig_EstIng'     => trim($q->STAENG_01),
                'Ig_FecObs'     => trim($q->OBSDTE_01), /* este no va, ya que va a ser un producto nuevo, aun no tiene fecha de obsolesencia  */
                'Ig_Cbn'        => trim($q->LLC_01),
                'Ig_NumPln'     => trim($q->DRANUM_01),

                    /* Campos de Planificador */
                'Pl_PolOrd'     => trim($q->ORDPOL_01),
                'Pl_Prgm'       => trim($q->SCHFLG_01),
                'Pl_TcCrit'     => number_format($q->CRPHLT_01,0,'.',''),
                'Pl_Dias_Pe'    => trim($q->PERDAY_01), // no se muestra pero se captura para la insersion de datos
                'Pl_Pdr'        => number_format($q->ROP_01,0,'.',''),
                'Pl_Cdr'        => number_format($q->ROQ_01,0,'.',''),
                'Pl_InvSeg'     => number_format($q->SAFSTK_01,0,'.',''),
                /*checkbox*/
                'Pl_PlFirm'     => trim($q->FRMPLN_01),
                'Pl_Ncnd'       => trim($q->NCNR_01),
                'Pl_Rump'       => trim($q->ROHS_01),
                'Pl_PieCrit'    => trim($q->SUPCDE_01),

                'Pl_ConComp'    => trim($q->PURCNV_01), // no se muestra pero se captura para la insersion de datos
                'Pl_Fb_TiCi'    => trim($q->MFGLT_01),
                'Pl_Fb_Pl'      => trim($q->MFGPIC_01),
                'Pl_Fb_Fab'     => trim($q->MFGOPR_01),
                'Pl_Fb_Alm'     => trim($q->MFGSTK_01),
                'Pl_Com_TiCi'   => trim($q->PURLT_01),
                'Pl_Com_Pl'     => trim($q->PURPIC_01),
                'Pl_Com_Comp'   => trim($q->PUROPR_01),
                'Pl_Com_Alm'    => trim($q->PURSTK_01),
                'Pl_CaOrd_Prom' => number_format($q->AVEQTY_01,0,'.',''),
                'Pl_CaOrd_Min'  => number_format($q->MINQTY_01,0,'.',''),
                'Pl_CaOrd_Max'  => number_format($q->MAXQTY_01,0,'.',''),
                'Pl_CaOrd_Mult' => number_format($q->MULQTY_01,0,'.',''),

                /* Campos Inventarios*/
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
                'Cont_TipCuent' => trim($q->ACTTYP_01),
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
                'PURUOM_01' => trim($q->PURUOM_01),

            ];
        }
        return response()->json($results);
    }

    public function SearchCodes(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('evpiu')->table('cod_codigos')
            ->where('cod_codigos.codigo','LIKE','%'.$query.'%')
            ->orWhere('cod_codigos.descripcion','LIKE','%'.$query.'%')->take(20)
            ->get();

        foreach ($queries as $q)
        {
            $results[] = [
                'value'         =>  $q->codigo.' - '.$q->descripcion,
                'codigo'        =>  $q->codigo,
                'descripcion'   =>  $q->descripcion
            ];
        }
        return response()->json($results);
    }

    public function SavePedido(Request $request)
    {
        DB::beginTransaction();
        try {
            $date = date('Ymd H:i:s');
            DB::connection('MAX')->table('Part_Master')->insert([
                'Part_Master.PRTNUM_01' => $request->Maestro_Cod,
                'Part_Master.TYPE_01'   => $request->Maestro_TP,
                'Part_Master.CLSCDE_01' => $request->Maestro_Cod_Clase,
                'Part_Master.PLANID_01' => $request->Maestro_Plan,
                'Part_Master.COMCDE_01' => $request->Maestro_Cod_Com,
                'Part_Master.LLC_01'    => $request->Ingenieria_Cbn,
                'Part_Master.PMDES1_01' => $request->Maestro_desc,
                'Part_Master.PMDES2_01' => '', /**/
                'Part_Master.BOMUOM_01' => $request->Maestro_Umd_Ldm,
                'Part_Master.STAENG_01' => $request->Ingenieria_Est_Ing,
                'Part_Master.STAACT_01' => '2',
                'Part_Master.FRMPLN_01' => $request->Planificador_PlnFirmVal, /*es un checkbox hay que validar el parametro que va a traer el request*/
                'Part_Master.PRDDTE_01' => $date,
                'Part_Master.WGTDEM_01' => $request->Maestro_Umd_Cos,
                'Part_Master.WGT_01'    => $request->Inventario_PesProm,
                'Part_Master.EXCDTE_01' => $date,
                'Part_Master.EXCFLG_01' => 'N',
                'Part_Master.DELSTK_01' => $request->Maestro_Al_Pref,
                'Part_Master.CYCCDE_01' => $request->Inventario_Re_Cod,
                'Part_Master.CYCNUM_01' => '0',
                'Part_Master.CYCPER_01' => $request->Inventario_TolePorc,
                'Part_Master.OBSOLT_01' => '0',
                'Part_Master.CYCOOT_01' => '0',
                'Part_Master.ORDPOL_01' => $request->Planificador_PolOrd,
                'Part_Master.YIELD_01'  => $request->Maestro_Rend,
                'Part_Master.ROP_01'    => $request->Planificador_Pdr,
                'Part_Master.ROQ_01'    => $request->Planificador_Cdr,
                'Part_Master.SAFSTK_01' => $request->Planificador_InvSeg,
                'Part_Master.MINQTY_01' => $request->Planificador_CaOr_Min,
                'Part_Master.MAXQTY_01' => $request->Planificador_CaOr_Max,
                'Part_Master.MULQTY_01' => $request->Planificador_CaOr_Mult,
                'Part_Master.AVEQTY_01' => $request->Planificador_CaOr_Prom,
                'Part_Master.ISSMTD_01' => '0',
                'Part_Master.ISSYTD_01' => '0',
                'Part_Master.SALMTD_01' => '0',
                'Part_Master.SALYTD_01' => '0',
                'Part_Master.MFGLT_01'  => $request->Maestro_Tc_Manu,
                'Part_Master.MFGPIC_01' => $request->Planificador_Fa_Pl,
                'Part_Master.MFGOPR_01' => $request->Planificador_Fa_Fab,
                'Part_Master.MFGSTK_01' => $request->Planificador_Fa_Alm,
                'Part_Master.PURLT_01'  => $request->Maestro_Tc_Compras,
                'Part_Master.PURPIC_01' => $request->Planificador_Com_Pl,
                'Part_Master.PUROPR_01' => $request->Planificador_Com_Comp,
                'Part_Master.PURSTK_01' => $request->Planificador_Com_Alm,
                'Part_Master.PRICE_01'  => '0',
                'Part_Master.COST_01'   => '0',
                'Part_Master.CSTTYP_01' => $request->CSTTYP_01, /* null mientras creo el hidden input para almacenar el valor */
                'Part_Master.CSTDTE_01' => $date,
                'Part_Master.CSTUOM_01' => 'KG',
                'Part_Master.CSTCNV_01' => '1',
                'Part_Master.MATL_01'   => '0',
                'Part_Master.LABOR_01'  => $request->LABOR_01,
                'Part_Master.VOH_01'    => $request->VOH_01,
                'Part_Master.FOH_01'    => $request->FOH_01,
                'Part_Master.QUMMAT_01' => $request->QUMMAT_01,
                'Part_Master.QUMLAB_01' => $request->QUMLAB_01,
                'Part_Master.QUMVOH_01' => $request->QUMVOH_01,
                'Part_Master.QUMFOH_01' => '0',
                'Part_Master.HRS_01' => $request->HRS_01,
                'Part_Master.QUMHRS_01' => $request->QUMHRS_01,
                'Part_Master.ALPHA_01' => '0',
                'Part_Master.QUMSUB_01' => '0',
                'Part_Master.PURUOM_01' => $request->PURUOM_01,
                'Part_Master.PURCNV_01' => '1', /* null mientras creo el hidden input para almacenar el valor */
                'Part_Master.SCRAP_01' => $request->Ingenieria_desec,
                'Part_Master.BUYER_01' => $request->Maestro_Comprador,
                'Part_Master.INSRQD_01' => $request->Inventario_ReqInspVal, /* checkbox*/
                'Part_Master.ONHAND_01' => '0',
                'Part_Master.NONNET_01' => '0',
                'Part_Master.SCHCDE_01' => 'B',
                'Part_Master.REVLEV_01' => $request->Maestro_Niv_Rev,
                'Part_Master.ACTTYP_01' => $request->Contabilidad_TipCuent,
                'Part_Master.ACTCDE_01' => '1',
                'Part_Master.SCHFLG_01' => $request->Planificador_Prg,
                'Part_Master.MPNFLG_01' => 'N',
                'Part_Master.MATLXY_01' => '0',
                'Part_Master.CRPHLT_01' => $request->Planificador_Tc_Crit,
                'Part_Master.LOTTRK_01' => $request->Inventario_CtrLotVal, /* checkbox*/
                'Part_Master.MULREC_01' => $request->Inventario_MultEntVal, /* checkbox*/
                'Part_Master.SERTRK_01' => $request->Inventario_CtrNsVal, /* checkbox*/
                'Part_Master.LOTSFC_01' => $request->Inventario_LotCdpVal, /* checkbox*/
                'Part_Master.SHLIFE_01' => $request->Inventario_DiasVen,
                'Part_Master.DRANUM_01' => $request->Ingenieria_NumPln,
                'Part_Master.DELLOC_01' => $request->Maestro_Zona,
                'Part_Master.PERDAY_01' => $request->PERDAY_01, /* null mientras creo el hidden input para almacenar el valor */
                'Part_Master.ALLOC_01'  => '0',
                'Part_Master.JOBEXP_01' => 'Y',
                'Part_Master.RNDRQS_01' => 'N',
                'Part_Master.EXCREC_01' => $request->Inventario_ExcEnt,
                'Part_Master.INDDEM_01' => 'N',
                'Part_Master.SUPCDE_01' => $request->Planificador_PieCritVal, /*checkbox*/
                'Part_Master.CYCDOL_01' => $request->Inventario_ToleMoney,
                'Part_Master.STDVOH_01' => '0',
                'Part_Master.XDFINT_01' => '0',
                'Part_Master.XDFFLT_01' => '0',
                'Part_Master.XDFDTE_01' => $date,
                'Part_Master.CreatedBy' => 'Evpiu-'.Auth::user()->name,
                'Part_Master.CreationDate' => $date,
                'Part_Master.SUBCST_01'    => '',
                'Part_Master.CURREV_01' => '',
                'Part_Master.RECVEN_01' => '',
                'Part_Master.RTEREV_01' => '',
                'Part_Master.VIEWER_01'   => '',
                'Part_Master.MCOMP_01'  => '',
                'Part_Master.MSITE_01'  => '',
                'Part_Master.UDFKEY_01' => '',
                'Part_Master.UDFREF_01' => '',
                'Part_Master.LSTECN_01' => '',
                'Part_Master.ROHS_01' => $request->Planificador_RumpVal, /*checkbox*/
                'Part_Master.NCNR_01' => $request->Planificador_NcndVal, /*checkbox*/
            ]);

            DB::connection('MAX')->table('Activity_index')->insert([
                'Activity_index.LLC_03'     => $request->Ingenieria_Cbn,
                'Activity_index.PRTNUM_03'  => $request->Maestro_Cod,
                'Activity_index.BOMFLG_03'  => 'N',
                'Activity_index.MPSFLG_03'  => 'N',
                'Activity_index.MRPFLG_03'  => 'N',
                'Activity_index.CSTFLG_03'  => 'N',
                'Activity_index.PL1FLG_03'  => 'N',
                'Activity_index.MCOMP_03'   => '',
                'Activity_index.MSITE_03'   => '',
                'Activity_index.UDFKEY_03'  => '',
                'Activity_index.UDFREF_03'  => '',
                'Activity_index.FILLER_03'  => '',
                'Activity_index.CreatedBy'  => 'Evpiu-'.Auth::user()->name,
                'Activity_index.CreationDate'=> $date
            ]);

            $Producto = $request->ProductOrig;
            $Prod_dest = $request->Maestro_Cod;

            $InsProd_Struc = [];
            $Product_Structur = DB::connection('MAX')->table('Product_Structure')
                ->where('Product_Structure.PARPRT_02','=', $Producto)->get();

            foreach ($Product_Structur as $Prod_Struc){
                $InsProd_Struc[] = [
                    'PARPRT_02'    => $Prod_dest,
                    'COMPRT_02'    => $Prod_Struc->COMPRT_02,
                    'EFFDTE_02'    => date('Ymd 00:00:00'),
                    'FILL01_02'    => $Prod_Struc->FILL01_02,
                    'QTYPER_02'    => $Prod_Struc->QTYPER_02,
                    'QTYCDE_02'    => $Prod_Struc->QTYCDE_02,
                    'LTOSET_02'    => $Prod_Struc->LTOSET_02,
                    'TYPCDE_02'    => $Prod_Struc->TYPCDE_02,
                    'SCRAP_02'     => $Prod_Struc->SCRAP_02,
                    'ECN_02'       => $Prod_Struc->ECN_02,
                    'ACTDTE_02'    => $date,
                    'FILL02_02'    => $Prod_Struc->FILL02_02,
                    'ALTPRT_02'    => $Prod_Struc->ALTPRT_02,
                    'REFDES_02'    => $Prod_Struc->REFDES_02,
                    'MPNSTR_02'    => $Prod_Struc->MPNSTR_02,
                    'MCOMP_02'     => $Prod_Struc->MCOMP_02,
                    'MSITE_02'     => $Prod_Struc->MSITE_02,
                    'UDFKEY_02'    => $Prod_Struc->UDFKEY_02,
                    'UDFREF_02'    => $Prod_Struc->UDFREF_02,
                    'XDFINT_02'    => $Prod_Struc->XDFINT_02,
                    'XDFFLT_02'    => $Prod_Struc->XDFFLT_02,
                    'XDFBOL_02'    => $Prod_Struc->XDFBOL_02,
                    'XDFDTE_02'    => '',
                    'XDFTXT_02'    => $Prod_Struc->XDFTXT_02,
                    'FILLER_02'    => $Prod_Struc->FILLER_02,
                    'CreatedBy'    => 'Evpiu-'.Auth::user()->name,
                    'CreationDate' => $date,
                    'ModifiedBy'   => '',
                    'ModificationDate' => '',
                    'ALTCDE_02'    => ''
                ];
            }
            DB::connection('MAX')->table('Product_Structure')->insert($InsProd_Struc);

            $InsPart_Rou = [];
            $Part_Routing = DB::connection('MAX')->table('Part_Routing')
                ->where('Part_Routing.PRTNUM_12','=', $Producto)->get();

            foreach ($Part_Routing as $Part_Rou ){
                $InsPart_Rou[] = [
                    'PRTNUM_12'     =>  $Prod_dest,
                    'OPRSEQ_12'     =>  $Part_Rou->OPRSEQ_12,
                    'OPRID_12'      =>  $Part_Rou->OPRID_12,
                    'WRKCTR_12'     =>  $Part_Rou->WRKCTR_12,
                    'OPRDES_12'     =>  $Part_Rou->OPRDES_12,
                    'RUNTIM_12'     =>  $Part_Rou->RUNTIM_12,
                    'SETTIM_12'     =>  $Part_Rou->SETTIM_12,
                    'REVDTE_12'     =>  $date,
                    'FILL01_12'     =>  $Part_Rou->FILL01_12,
                    'OPRTYP_12'     =>  $Part_Rou->OPRTYP_12,
                    'STDTYP_12'     =>  $Part_Rou->STDTYP_12,
                    'QTYPER_12'     =>  $Part_Rou->QTYPER_12,
                    'TOOL_12'       =>  $Part_Rou->TOOL_12,
                    'SUBCST_12'     =>  $Part_Rou->SUBCST_12,
                    'PSCRAP_12'     =>  $Part_Rou->PSCRAP_12,
                    'ASCRAP_12'     =>  $Part_Rou->ASCRAP_12,
                    'SETEXT_12'     =>  $Part_Rou->SETEXT_12,
                    'SETINC_12'     =>  $Part_Rou->SETINC_12,
                    'MOVDAY_12'     =>  $Part_Rou->MOVDAY_12,
                    'APRDBY_12'     =>  $Part_Rou->APRDBY_12,
                    'EFFDTE_12'     =>  $date,
                    'MCOMP_12'      =>  $Part_Rou->MCOMP_12,
                    'MSITE_12'      =>  $Part_Rou->MSITE_12,
                    'UDFKEY_12'     =>  $Part_Rou->UDFKEY_12,
                    'UDFREF_12'     =>  $Part_Rou->UDFREF_12,
                    'SERVICEID_12'  =>  $Part_Rou->SERVICEID_12,
                    'PRIVENID_12'   =>  $Part_Rou->PRIVENID_12,
                    'RTGGRP_12'     =>  $Part_Rou->RTGGRP_12,
                    'XDFINT_12'     =>  $Part_Rou->XDFINT_12,
                    'XDFFLT_12'     =>  $Part_Rou->XDFFLT_12,
                    'XDFBOL_12'     =>  $Part_Rou->XDFBOL_12,
                    'XDFDTE_12'     =>  null,
                    'XDFTXT_12'     =>  $Part_Rou->XDFTXT_12,
                    'FILLER_12'     =>  $Part_Rou->FILLER_12,
                    'CreatedBy'     =>  'Evpiu-'.Auth::user()->name,
                    'CreationDate'  =>  $date,
                    'ModifiedBy'    => '',
                    'ModificationDate' => '',
                    'ALTCDE_12'  => '',
                ];
            }
            DB::connection('MAX')->table('Part_Routing')->insert($InsPart_Rou);

            $InsPart_Sal = [];
            $Part_Sales = DB::connection('MAX')->table('Part_Sales')
                ->where('Part_Sales.PRTNUM_29','=', $Producto)->get();

            foreach ($Part_Sales as $Part_Sale ) {
                $InsPart_Sal[] = [
                    'PRTNUM_29' => $Prod_dest,
                    'SLSCAT_29' => '',
                    'PMDES1_29' => $request->Maestro_desc,
                    'PMDES2_29' => '',
                    'STK_29'    => $request->Maestro_Al_Pref,
                    'TAXABL_29' => $Part_Sale->TAXABL_29,
                    'BOMUOM_29' => $request->Maestro_Umd_Ldm,
                    'SLSUOM_29' => $Part_Sale->SLSUOM_29,    /*Hay que crear un input para este campo y poderlo editar desde el frontend*/
                    'SLSCNV_29' => $Part_Sale->SLSCNV_29,   /*Hay que crear un input para este campo y poderlo editar desde el frontend*/
                    'PRICE_29' => '0',
                    'BREAK1_29' => '0',
                    'DISC1_29' => '0',
                    'PRICE1_29' => '0',
                    'BREAK2_29' => '0',
                    'DISC2_29' => '0',
                    'PRICE2_29' => '0',
                    'BREAK3_29' => '0',
                    'DISC3_29' => '0',
                    'PRICE3_29' => '0',
                    'BREAK4_29' => '0',
                    'DISC4_29' => '0',
                    'PRICE4_29' => '0',
                    'BREAK5_29' => '0',
                    'DISC5_29' => '0',
                    'PRICE5_29' => '0',
                    'BREAK6_29' => '0',
                    'DISC6_29' => '0',
                    'PRICE6_29' => '0',
                    'BREAK7_29' => '0',
                    'DISC7_29' => '0',
                    'PRICE7_29' => '0',
                    'BREAK8_29' => '0',
                    'DISC8_29' => '0',
                    'PRICE8_29' => '0',
                    'BREAK9_29' => '0',
                    'DISC9_29' => '0',
                    'PRICE9_29' => '0',
                    'QTYMTD_29' => '0',
                    'SLSMTD_29' => '0',
                    'CSTMTD_29' => '0',
                    'QTYYTD_29' => '0',
                    'SLSYTD_29' => '0',
                    'CSTYTD_29' => '0',
                    'QTYLYR_29' => '0',
                    'SLSLYR_29' => '0',
                    'CSTLYR_29' => '0',
                    'QTYCOM_29' => '0',
                    'CRTLTO_29' => $request->Planificador_Tc_Crit,
                    'AUTOMS_29' => $Part_Sale->AUTOMS_29,
                    'APLDSC_29' => $Part_Sale->APLDSC_29,
                    'PRDLIN_29' => $Part_Sale->PRDLIN_29,
                    'HISFLG_29' => $Part_Sale->HISFLG_29,
                    'WARFLG_29' => $Part_Sale->WARFLG_29,
                    'LABWAR_29' => '0',
                    'MATWAR_29' => '0',
                    'RETMTD_29' => '0',
                    'RETYTD_29' => '0',
                    'UNWRPL_29' => '0',
                    'UNWREP_29' => '0',
                    'OUWRPL_29' => '0',
                    'OUWREP_29' => '0',
                    'COMMIS_29' => '0',
                    'TAXCDE_29' => $Part_Sale->TAXCDE_29,
                    'TAXCDE2_29' => '',
                    'TAXCDE3_29' => '',
                    'MCOMP_29' => '',
                    'MSITE_29' => '',
                    'UDFKEY_29' => '',
                    'UDFREF_29' => '',
                    'ALWBCK_29' => $Part_Sale->ALWBCK_29,
                    'AUTOMF_29' => $Part_Sale->AUTOMF_29,
                    'XDFINT_29' => '0',
                    'XDFFLT_29' => '0',
                    'XDFBOL_29' => '0',
                    'XDFDTE_29' => $date,
                    'XDFTXT_29' => '',
                    'FILLER_29' => '',
                    'CreatedBy' => 'Evpiu-' . Auth::user()->name,
                    'CreationDate' => $date,
                    'ModifiedBy' => '',
                    'ModificationDate' => '',
                    'MANPRC_29'    => $Part_Sale->MANPRC_29,
                    'WARRES_29'    => $Part_Sale->WARRES_29
                ];
            }
            DB::connection('MAX')->table('Part_Sales')->insert($InsPart_Sal);

            DB::commit();

            return response()->json(['Success' => 'Todo Ok']);
        }

        catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                ),
            ));
        }
       /* return response()->json($resultado);*/
    }

}
