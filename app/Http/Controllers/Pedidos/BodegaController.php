<?php

namespace App\Http\Controllers\Pedidos;

use App\EncabezadoPedido;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BodegaController extends Controller
{
    /**
     * lista de pedidos pendientes por gestion
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if ($request->ajax()){
            $data = EncabezadoPedido::with('cliente' ,'info_area', 'vendedor')
                ->where('Estado', '=','8')
                ->orWhere('Estado', '=','9')
                ->get();


            return Datatables::of($data)
                ->editColumn('created_at', function ($row){
                    Carbon::setLocale('es');
                    return  $row->created_at->format('d M Y h:i a');
                })
                ->addColumn('opciones', function($row){
                    return '
                        <div class="btn-group btn-sm" role="group">
                            <button class="btn btn-light opciones" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Opciones"><i class="fas fa-cogs"></i></button>
                            <button class="btn btn-light ver_pdf" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-file-pdf"></i></button>
                        </div>';
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('aplicaciones.pedidos.bodega.index');
    }



    /**
     * Cambia el estado del pedido dependiendo de la opcion
     * seleccionada en el modal 'opciones'
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function actualizar_pedido(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            DB::connection('MAX')->beginTransaction();
            try {
                if ($request->estado == 10) {
                    $pedido =  EncabezadoPedido::find($request->id);

                    $pedido->Estado = $request->estado;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Bodega'            =>  $request->estado,
                        'DetalleBodega'     =>  $request->descripcion,
                        'bodega_fecha_resp' =>  Carbon::now(),
                        'aprobo_bodega'     =>  auth()->user()->id
                    ]);


                    $max_ordnum_27 =  DB::connection('MAX')
                        ->table('SO_Master')
                        ->whereIn('STYPE_27', ['CU', 'CR'])
                        ->max('ORDNUM_27');


                    $max_ordnum_27 = $max_ordnum_27 + 1;

                    $encabezado_ped =  DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)->first();


                    DB::connection('MAX')
                        ->table('SO_Master')
                        ->insert([
                            'ORDNUM_27'     =>  $max_ordnum_27,
                            'CUSTID_27'     =>  $pedido->CodCliente,
                            'GLXREF_27'     =>  41209505                                                                                                                                                       ,
                            'STYPE_27'      =>  'CU',
                            'STATUS_27'     =>  3,
                            'CUSTPO_27'     =>  $encabezado_ped->OrdenCompra ?? '',
                            'ORDID_27'      =>  $pedido->id,
                            'ORDDTE_27'     =>  Carbon::now()->format('Y-m-d 00:00:00'),
                            'FILL01A_27'    =>  '', /*empty*/
                            'FILL01_27'     =>  '', /*empty*/
                            'SHPCDE_27'     =>  '', /*empty*/
                            'REP1_27'       =>  $pedido->cliente_info->SLSREP_23,
                            'SPLIT1_27'     =>  100,
                            'REP2_27'       =>  '', /*empty*/
                            'SPLIT2_27'     =>  0,
                            'REP3_27'       =>  '', /*empty*/
                            'SPLIT3_27'     =>  0,
                            'COMMIS_27'     =>  $pedido->cliente_info->COMMIS_23,
                            'TERMS_27'      =>  $pedido->cliente_info->TERMS_23,
                            'SHPVIA_27'     =>  $pedido->cliente_info->SHPVIA_23,
                            'XURR_27'       =>  '', /*empty*/
                            'FOB_27'        =>  $pedido->cliente_info->CITY_23,
                            'TAXCD1_27'     =>  $pedido->cliente_info->TXCDE1_23,
                            'TAXCD2_27'     =>  '', /*empty*/
                            'TAXCD3_27'     =>  '', /*empty*/
                            'COMNT1_27'     =>  $pedido->Notas ?? '', /*empty*/
                            'COMNT2_27'     =>  '', /*empty*/
                            'COMNT3_27'     =>  '', /*empty*/
                            'SHPLBL_27'     =>  0,
                            'INVCE_27'      =>  'N',
                            'APPINV_27'     =>  '', /*empty*/
                            'REASON_27'     =>  23, // 23 si es bodega
                            'NAME_27'       =>  $pedido->cliente_info->NAME_23,
                            'ADDR1_27'      =>  $pedido->cliente_info->ADDR1_23,
                            'ADDR2_27'      =>  $pedido->cliente_info->ADDR2_23,
                            'CITY_27'       =>  $pedido->cliente_info->CITY_23,
                            'STATE_27'      =>  $pedido->cliente_info->STATE_23,
                            'ZIPCD_27'      =>  $pedido->cliente_info->ZIPCD_23,
                            'CNTRY_27'      =>  $pedido->cliente_info->CNTRY_23,
                            'PHONE_27'      =>  $pedido->cliente_info->PHONE_23,
                            'CNTCT_27'      =>  $pedido->cliente_info->CNTCT_23,
                            'TAXPRV_27'     =>  $pedido->cliente_info->TAXPRV_23,
                            'FEDTAX_27'     =>  'N',
                            'TAXABL_27'     =>  $pedido->cliente_info->TAXABL_23,
                            'EXCRTE_27'     =>  1,
                            'FIXVAR_27'     =>  'V',
                            'CURR_27'       =>  $pedido->cliente_info->CURR_23,
                            'RCLDTE_27'     =>  null,
                            'FILL02_27'     =>  '', /*empty*/
                            'TTAX_27'       =>  '', /*empty*/
                            'LNETAX_27'     =>  'N',
                            'ADDR3_27'      =>  $pedido->cliente_info->ADDR3_23,
                            'ADDR4_27'      =>  $pedido->cliente_info->ADDR4_23,
                            'ADDR5_27'      =>  $pedido->cliente_info->ADDR5_23,
                            'ADDR6_27'      =>  $pedido->cliente_info->ADDR6_23,
                            'MCOMP_27'      =>  $pedido->cliente_info->MCOMP_23,
                            'MSITE_27'      =>  $pedido->cliente_info->MSITE_23,
                            'UDFKEY_27'     =>  '', /*empty*/
                            'UDFREF_27'     =>  '', /*empty*/
                            'SHPTHRU_27'    =>  '', /*empty*/
                            'XDFINT_27'     =>  0,
                            'XDFFLT_27'     =>  0,
                            'XDFBOL_27'     =>  '', /*empty*/
                            'XDFDTE_27'     =>  null, /*empty*/
                            'XDFTXT_27'     =>  '', /*empty*/
                            'FILLER_27'     =>  '', /*empty*/
                            'CreatedBy'     =>  'EVPIU-'.auth()->user()->username,
                            'CreationDate'  =>  Carbon::now(),
                            'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username,
                            'ModificationDate'  =>  Carbon::now(),
                            'BILLCDE_27'    =>  '' /*empty*/
                        ]);


                    $idx = 0;

                    foreach ($pedido->detalle as $dp){
                        $n2 = str_pad($idx + 1, 2, 0, STR_PAD_LEFT);


                        $part = DB::connection('MAX')
                            ->table('Part_Master')
                            ->where('PRTNUM_01', '=', $dp->CodigoProducto)
                            ->first();


                        $fcha_entrega = $this->calcular_fecha_entrega($part->MFGLT_01);


                        $almacen = DB::connection('MAX')
                            ->table('Part_Sales')
                            ->where('PRTNUM_29', '=', $dp->CodigoProducto)
                            ->pluck('STK_29')->first();


                        DB::connection('MAX')
                            ->table('SO_Detail')
                            ->insert([
                                'ORDNUM_28'     =>  $max_ordnum_27,
                                'LINNUM_28'     =>  $n2,
                                'DELNUM_28'     =>  '01',
                                'STATUS_28'     =>  3,
                                'CUSTID_28'     =>  $pedido->CodCliente,
                                'PRTNUM_28'     =>  $dp->CodigoProducto,
                                'EDILIN_28'     =>  '', /*empty*/
                                'TAXABL_28'     =>  $pedido->Iva,
                                'GLXREF_28'     =>  61209505,
                                'CURDUE_28'     =>  $fcha_entrega->DateValue, /*empty*/
                                'QTLINE_28'     =>  '', /*empty*/
                                'ORGDUE_28'     =>  $fcha_entrega->DateValue,
                                'QTDEL_28'      =>  '', /*empty*/
                                'CUSDUE_28'     =>  $fcha_entrega->DateValue,
                                'PROBAB_28'     =>  0,
                                'SHPDTE_28'     =>  null,  /*empty*/
                                'FILL04_28'     =>  '', /*empty*/
                                'SLSUOM_28'     =>  'UN',
                                'REFRNC_28'     =>  $max_ordnum_27.$n2."01",
                                'PRICE_28'      =>  $dp->Precio,
                                'ORGQTY_28'     =>  $dp->Cantidad,
                                'CURQTY_28'     =>  $dp->Cantidad,
                                'BCKQTY_28'     =>  0,
                                'SHPQTY_28'     =>  0,
                                'DUEQTY_28'     =>  $dp->Cantidad,
                                'INVQTY_28'     =>  0,
                                'DISC_28'       =>  0,
                                'STYPE_28'      =>  'CU',
                                'PRNT_28'       =>  'N',
                                'AKPRNT_28'     =>  'N',
                                'STK_28'        =>  $almacen, /*empty*/
                                'COCFLG_28'     =>  '', /*empty*/
                                'FORCUR_28'     =>  $dp->Precio,
                                'HSTAT_28'      =>  'R',
                                'SLSREP_28'     =>  '', /*empty*/
                                'COMMIS_28'     =>  0,
                                'DRPSHP_28'     =>  '', /*empty*/
                                'QUMQTY_28'     =>  0,
                                'TAXCDE1_28'    =>  $pedido->cliente_info->TXCDE1_23,
                                'TAX1_28'       =>  $pedido->Iva === 'Y' ? ($dp->Precio * $dp->Cantidad) * 0.19 : 0,
                                'TAXCDE2_28'    =>  '', /*empty*/
                                'TAX2_28'       =>  0,
                                'TAXCDE3_28'    =>  '', /*empty*/
                                'TAX3_28'       =>  0,
                                'MCOMP_28'      =>  '', /*empty*/
                                'MSITE_28'      =>  '', /*empty*/
                                'UDFKEY_28'     =>  '', /*empty*/
                                'UDFREF_28'     =>  '', /*empty*/
                                'DEXPFLG_28'    =>  'N',
                                'COST_28'       =>  $part->COST_01,
                                'MARKUP_28'     =>  0,
                                'QTORD_28'      =>  '', /*empty*/
                                'XDFINT_28'     =>  0,
                                'XDFFLT_28'     =>  0,
                                'XDFBOL_28'     =>  '', /*empty*/
                                'XDFDTE_28'     =>  null,
                                'XDFTXT_28'     =>  '', /*empty*/
                                'FILLER_28'     =>  '', /*empty*/
                                'CreatedBy'     =>  'EVPIU-'.auth()->user()->username ,
                                'CreationDate'  =>  Carbon::now(),
                                'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username ,
                                'ModificationDate'  =>  Carbon::now(),
                                'BOKDTE_28'     =>  Carbon::now(),
                                'DBKDTE_28'     =>  null,
                                'REVLEV_28'     =>  '', /*empty*/
                                'MANPRC_28'     =>  'N',
                                'ORGPRC_28'     =>  $dp->Precio,
                                'PRCALC_28'     =>  2,
                                'CLASS_28'      =>  '', /*empty*/
                                'WARRES_28'     =>  0,
                                'JOB_28'        =>  '', /*empty*/
                                'CSENDDTE_28'   =>  null,
                                'CONSGND_28'    =>  0,
                                'CURCONSGND_28' =>  0,
                                'CONSIGNSTK_28' =>  '', /*empty*/
                                'CURSHP_28'     => 0
                            ]);



                        DB::connection('MAX')
                            ->table('SO_Detail_Ext')
                            ->insert([
                                'ORDER_LIN_DEL'     =>  $max_ordnum_27.$n2."01",
                                'ARTE'              =>  $dp->Arte,
                                'CodProdCliente'    =>  $dp->Cod_prod_cliente,
                                'Marca'             =>  $dp->Marca
                            ]);




                        DB::connection('MAX')
                            ->table('Order_Master')
                            ->insert([
                                'ORDNUM_10'     =>  $max_ordnum_27,
                                'LINNUM_10'     =>  $n2,
                                'DELNUM_10'     =>  '01',
                                'PRTNUM_10'     =>  $dp->CodigoProducto,
                                'CURDUE_10'     =>  Carbon::now()->addMonth(),
                                'RECFLG_10'     =>  'N',
                                'TAXABLE_10'    =>  'N',
                                'TYPE_10'       =>  'CU',
                                'ORDER_10'      =>  $max_ordnum_27.$n2."01",
                                'VENID_10'      =>  '',  /*empty*/
                                'ORGDUE_10'     =>  Carbon::now()->addMonth(),
                                'PURUOM_10'     =>  '',  /*empty*/
                                'CURQTY_10'     =>  $dp->Cantidad,
                                'ORGQTY_10'     =>  $dp->Cantidad,
                                'DUEQTY_10'     =>  0,
                                'CURPRM_10'     =>  Carbon::now()->addMonth(),
                                'FILL03_10'     =>  '', /*empty*/
                                'ORGPRM_10'     =>  Carbon::now()->addMonth(),
                                'FILL04_10'     =>  '', /*empty*/
                                'FRMPLN_10'     =>  'Y',
                                'STATUS_10'     =>  '3',
                                'STK_10'        =>  $part->DELSTK_01,
                                'CUSORD_10'     =>  $max_ordnum_27.$n2."01",
                                'PLANID_10'     =>  $part->PLANID_01,
                                'BUYER_10'      =>  $part->BUYER_01,
                                'PSCRAP_10'     =>  0,
                                'ASCRAP_10'     =>  0,
                                'SCRPCD_10'     =>  'N',
                                'SCHCDE_10'     =>  'B',
                                'REVLEV_10'     =>  '', /*empty*/
                                'COST_10'       =>  $part->COST_01,
                                'CSTCNV_10'     =>  1,
                                'APRDBY_10'     =>  '', /*empty*/
                                'ORDREF_10'     =>  $max_ordnum_27.$n2."01",
                                'TRNDTE_10'     =>  Carbon::now(),
                                'FILL05_10'     =>  '', /*empty*/
                                'SCHFLG_10'     =>  'R',
                                'CRTRAT_10'     =>  '', /*empty*/
                                'NEGATV_10'     =>  '', /*empty*/
                                'REQPEG_10'     =>  '', /*empty*/
                                'MPNNUM_10'     =>  '', /*empty*/
                                'LABOR_10'      =>  0,
                                'AMMEND_10'     =>  'N',
                                'LOTNUM_10'     =>  '', /*empty*/
                                'BEGSER_10'     =>  '', /*empty*/
                                'REWORK_10'     =>  'N',
                                'CRTSNS_10'     =>  'N',
                                'TTLSNS_10'     =>  0,
                                'FORCUR_10'     =>  0,
                                'EXCESS_10'     =>  0,
                                'UOMCST_10'     =>  0,
                                'UOMCNV_10'     =>  0,
                                'INSREQ_10'     =>  '', /*empty*/
                                'CREDTE_10'     =>  Carbon::now(),
                                'RTEREV_10'     =>  '', /*empty*/
                                'RTEDTE_10'     =>  Carbon::now(),
                                'COMCDE_10'     =>  '', /*empty*/
                                'ORDPTP_10'     =>  '', /*empty*/
                                'JOBEXP_10'     =>  '', /*empty*/
                                'JOBCST_10'     =>  0,
                                'TAXCDE_10'     =>  '', /*empty*/
                                'TAX1_10'       =>  0,
                                'GLREF_10'      =>  '', /*empty*/
                                'CURR_10'       =>  '', /*empty*/
                                'UDFKEY_10'     =>  '', /*empty*/
                                'UDFREF_10'     =>  '', /*empty*/
                                'DISC_10'       =>  0,
                                'RECCOST_10'    =>  0,
                                'MPNMFG_10'     =>  '', /*empty*/
                                'DEXPFLG_10'    =>  'N',
                                'PLSTPRNT_10'   =>  'N',
                                'ROUTPRNT_10'   =>  'N',
                                'REQUES_10'     =>  '', /*empty*/
                                'CLSDTE_10'     =>  null,
                                'XDFINT_10'     =>  0,
                                'XDFFLT_10'     =>  0,
                                'XDFBOL_10'     =>  '', /*empty*/
                                'XDFDTE_10'     =>  null,
                                'XDFTXT_10'     =>  '', /*empty*/
                                'FILLER_10'     =>  '', /*empty*/
                                'CreatedBy'     =>  'EVPIU-'.auth()->user()->username,
                                'CreationDate'  =>  Carbon::now(),
                                'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                                'TSKCDE_10'     =>  '', /*empty*/
                                'TSKTYP_10'     =>  '', /*empty*/
                                'REPORTER_10'   =>  '', /*empty*/
                                'PRIORITY_10'   =>  '', /*empty*/
                                'PHONE_10'      =>  '', /*empty*/
                                'LOCATION_10'   =>  '', /*empty*/
                                'ALTBOM_10'     =>  '', /*empty*/
                                'ALTRTG_10'     =>  '', /*empty*/
                                'CLASS_10'      =>  '', /*empty*/
                                'JOB_10'        =>  '', /*empty*/
                                'SUBSHP_10'     =>  0
                            ]);



                        $cant_comprometida = DB::connection('MAX')
                            ->table('Part_Sales')
                            ->where('PRTNUM_29', '=', $dp->CodigoProducto)
                            ->pluck('QTYCOM_29')->first();



                        DB::connection('MAX')
                            ->table('Part_Sales')
                            ->where('PRTNUM_29', '=', $dp->CodigoProducto)
                            ->update([
                                'QTYCOM_29' => $cant_comprometida + floatval($dp->Cantidad)
                            ]);



                            if($dp->Notas){
                                if(strlen($dp->Notas) <= 50){
                                    DB::connection('MAX')
                                    ->table('SO_Note')
                                    ->insert([
                                        'ORDNUM_30'     => $max_ordnum_27,
                                        'LINNUM_30'     => '01',
                                        'DELNUM_30'     => $n2,
                                        'COMNUM_30'     => '01',
                                        'CODE_30'       => 'B',
                                        'COMNT_30'      => $dp->Notas ?? '',
                                        'CUSTID_30'     =>  '',
                                        'PIDCOD_30'     =>  '',
                                        'MCOMP_30'      =>  '',
                                        'MSITE_30'      =>  '',
                                        'UDFKEY_30'     =>  '',
                                        'UDFREF_30'     =>  '',
                                        'XDFINT_30'     =>  0,
                                        'XDFFLT_30'     =>  0,
                                        'XDFBOL_30'     =>  '',
                                        'XDFDTE_30'     =>  null,
                                        'XDFTXT_30'     =>  '',
                                        'FILLER_30'     =>  '',
                                        'CreatedBy'     =>  'EVPIU-'.auth()->user()->username,
                                        'CreationDate'  =>  Carbon::now(),
                                        'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username,
                                        'ModificationDate' => Carbon::now(),
                                        'RECTYP_30' =>  'ST'
                                    ]);
                                }else{
                                    $notas = str_split($dp->Notas, 50);
                                    $idx2 = 0;

                                    foreach($notas as $nota){
                                        $nn = str_pad($idx2 + 1, 2, 0, STR_PAD_LEFT);

                                        DB::connection('MAX')
                                        ->table('SO_Note')
                                        ->insert([
                                            'ORDNUM_30'     => $max_ordnum_27,
                                            'LINNUM_30'     =>  '01',
                                            'DELNUM_30'     =>  $n2,
                                            'COMNUM_30'     =>  $nn,
                                            'CODE_30'       =>  'B',
                                            'COMNT_30'      =>  $nota ?? '',
                                            'CUSTID_30'     =>  '',
                                            'PIDCOD_30'     =>  '',
                                            'MCOMP_30'      =>  '',
                                            'MSITE_30'      =>  '',
                                            'UDFKEY_30'     =>  '',
                                            'UDFREF_30'     =>  '',
                                            'XDFINT_30'     =>  0,
                                            'XDFFLT_30'     =>  0,
                                            'XDFBOL_30'     =>  '',
                                            'XDFDTE_30'     =>  null,
                                            'XDFTXT_30'     =>  '',
                                            'FILLER_30'     =>  '',
                                            'CreatedBy'     =>  'EVPIU-'.auth()->user()->username,
                                            'CreationDate'  =>  Carbon::now(),
                                            'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username,
                                            'ModificationDate' => Carbon::now(),
                                            'RECTYP_30'     =>  'ST'
                                        ]);
                                        $idx2++;
                                    }
                                }
                            }



                        DB::connection('MAX')
                            ->table('Requirement_detail')
                            ->insert([
                                'ORDER_11'      =>  $max_ordnum_27.$n2."01",
                                'PRTNUM_11'     =>  $dp->CodigoProducto,
                                'CURDUE_11'     =>  $fcha_entrega->DateValue,
                                'FILL01_11'     =>  '',
                                'TYPE_11'       =>  'CU',
                                'ORDNUM_11'     =>  $max_ordnum_27,
                                'LINNUM_11'     =>  $n2,
                                'DELNUM_11'     =>  '01',
                                'CURQTY_11'     =>  $dp->Cantidad,
                                'ORGQTY_11'     =>  $dp->Cantidad,
                                'DUEQTY_11'     =>  $dp->Cantidad,
                                'STATUS_11'     =>  '3',
                                'QTYPER_11'     =>  '1',
                                'LTOSET_11'     =>  '0',
                                'SCRAP_11'      =>  '0',
                                'PICLIN_11'     =>  '0',
                                'ISSQTY_11'     =>  '0',
                                'REQREF_11'     =>  $max_ordnum_27.$n2."01",
                                'ORDPEG_11'     =>  '',
                                'ASCRAP_11'     =>  '0',
                                'MCOMP_11'      =>  '',
                                'MSITE_11'      =>  '',
                                'UDFKEY_11'     =>  '',
                                'UDFREF_11'     =>  '',
                                'DEXPFLG_11'    =>  '',
                                'XDFINT_11'     =>  '0',
                                'XDFFLT_11'     =>  '0',
                                'XDFBOL_11'     =>  '',
                                'XDFDTE_11'     =>  null,
                                'XDFTXT_11'     =>  '',
                                'FILLER_11'     =>  '',
                                'CreatedBy'     =>  'EVPIU-'.auth()->user()->username,
                                'CreationDate'  =>  Carbon::now(),
                                'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username,
                                'ModificationDate'  =>  Carbon::now(),
                            ]);

                        $idx++;
                    }
                    
                    
                    DB::connection('MAX')->select(DB::raw(`UPDATE Requirement_Detail SET CURDUE_11 = CONVERT(date ,CURDUE_11, 23) WHERE ORDNUM_11 = :max_ordnum_27`), array(
                        'max_ordnum_27' => $max_ordnum_27
                    ));
                    $pedido->Ped_MAX = $max_ordnum_27;
                    $pedido->save();
                }else{
                    $pedido =  EncabezadoPedido::find($request->id);

                    $pedido->Estado = $request->estado;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Bodega'        => $request->estado,
                        'DetalleBodega' => $request->descripcion,
                    ]);
                }
                DB::commit();
                DB::connection('MAX')->commit();
                if($request->estado == 10){
                    return response()->json($max_ordnum_27, 200);
                }else{
                    return response()->json('Pedido actualizado', 200);
                }
            }catch (\Exception $e){
                DB::rollBack();
                DB::connection('MAX')->rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    private function calcular_fecha_entrega( $cantidad_dias){
        $dias_habiles =  DB::connection('MAX')
            ->table('Shop_Calendar')
            ->where('ShopDay', '=', 1)
            ->whereDate('DateValue', '>=', Carbon::now())
            ->get();


        if ($cantidad_dias > 0) {
            return $dias_habiles[$cantidad_dias-1];
        }else{
            $date = Carbon::now()->format('Y-m-d h:m:i');
            return (object) [
                'DateValue' => $date
            ];
        }
    }
}
