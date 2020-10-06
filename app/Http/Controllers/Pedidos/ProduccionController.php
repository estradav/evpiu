<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProduccionController extends Controller
{
    /**
     * lista de pedidos pendientes por gestion
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if ($request->ajax()) {
            $data = DB::table('encabezado_pedidos')
                ->join('pedidos_detalles_area','encabezado_pedidos.id','=','pedidos_detalles_area.idPedido')
                ->select('encabezado_pedidos.id as id',
                    'encabezado_pedidos.OrdenCompra as OrdenCompra',
                    'encabezado_pedidos.NombreCliente as NombreCliente',
                    'encabezado_pedidos.CodCliente as CodCliente',
                    'encabezado_pedidos.NombreVendedor as NombreVendedor',
                    'encabezado_pedidos.CondicionPago as CondicionPago',
                    'encabezado_pedidos.Descuento as Descuento',
                    'encabezado_pedidos.Iva as Iva',
                    'encabezado_pedidos.Estado as Estado',
                    'encabezado_pedidos.created_at as created_at',
                    'pedidos_detalles_area.Produccion as SubEstado')
                ->where('Estado', '=', '6')
                ->get();

            return Datatables::of($data)
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
        return view('aplicaciones.pedidos.produccion.index');
    }



    /**
     * lista de pedidos terminados
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function listar_terminados(Request $request){
        if ($request->ajax()){
            $data = DB::table('encabezado_pedidos')
                ->join('pedidos_detalles_area','encabezado_pedidos.id','=','pedidos_detalles_area.idPedido')
                ->select('encabezado_pedidos.id as id',
                    'encabezado_pedidos.OrdenCompra as OrdenCompra',
                    'encabezado_pedidos.NombreCliente as NombreCliente',
                    'encabezado_pedidos.CodCliente as CodCliente',
                    'encabezado_pedidos.NombreVendedor as NombreVendedor',
                    'encabezado_pedidos.CondicionPago as CondicionPago',
                    'encabezado_pedidos.Descuento as Descuento',
                    'encabezado_pedidos.Iva as Iva',
                    'encabezado_pedidos.Estado as Estado',
                    'encabezado_pedidos.created_at as created_at',
                    'pedidos_detalles_area.Produccion as SubEstado')
                ->where('Estado', '=', '10')
                ->get();

            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    return '
                        <div class="btn-group btn-sm" role="group">
                            <button class="btn btn-light ver_pdf" id="'.$row->id.'"><i class="fas fa-file-pdf"></i> Ver PDF</button>
                        </div>';
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
    }



    /**
     * Cambia el estado del pedido dependiendo de la opcion
     * seleccionada en el modal 'opciones'
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function actualizar_estado(Request $request){
        if ($request->ajax()){
            try {
                DB::beginTransaction();
                DB::connection('MAXP')->beginTransaction();

                if ($request->estado == 7){
                    DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)
                        ->update([
                            'Estado' => $request->estado
                    ]);

                    DB::table('pedidos_detalles_area')
                        ->where('idPedido', '=', $request->id)
                        ->update([
                            'Produccion' => $request->estado,
                            'DetalleProduccion' => $request->descripcion,
                    ]);

                }elseif ($request->estado == 8){
                    DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)
                        ->update([
                            'Estado' => $request->estado
                    ]);

                    DB::table('pedidos_detalles_area')
                        ->where('idPedido', '=', $request->id)
                        ->update([
                            'Produccion'        => $request->estado,
                            'DetalleProduccion' => $request->descripcion,
                            'AproboProduccion'  => Auth::user()->username,
                            'Bodega'            => $request->estado,
                    ]);

                }else if($request->estado == 10){
                    DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)
                        ->update([
                            'Estado' => $request->estado
                        ]);

                    DB::table('pedidos_detalles_area')
                        ->where('idPedido', '=', $request->id)
                        ->update([
                            'Produccion'        => 8,
                            'DetalleProduccion' => $request->descripcion,
                            'AproboProduccion'  => Auth::user()->username,
                            'Bodega'            => $request->estado,
                            'DetalleBodega'     => $request->descripcion,
                            'AproboBodega'      => Auth::user()->username,
                        ]);



                    $max_ordnum_27 =  DB::connection('MAXP')
                        ->table('SO_Master')->max('ORDNUM_27');

                    $max_ordnum_27 = $max_ordnum_27 + 1;

                    $encabezado_ped =  DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)->first();



                    $cliente = DB::connection('MAXP')
                        ->table('Customer_Master')
                        ->where('CUSTID_23', '=',  $encabezado_ped->CodCliente)
                        ->first();





                    $detalle_ped = DB::table('detalle_pedidos')
                        ->where('idPedido', '=', $request->id)->get();


                    DB::connection('MAXP')
                        ->table('SO_Master')
                        ->insert([
                            'ORDNUM_27'     =>  $max_ordnum_27,
                            'CUSTID_27'     =>  $encabezado_ped->CodCliente,
                            'GLXREF_27'     =>  41209505                                                                                                                                                       ,
                            'STYPE_27'      =>  'CU',
                            'STATUS_27'     =>  3,
                            'CUSTPO_27'     =>  $encabezado_ped->OrdenCompra,
                            'ORDID_27'      =>  '', /*empty*/
                            'ORDDTE_27'     =>  Carbon::now(),
                            'FILL01A_27'    =>  '', /*empty*/
                            'FILL01_27'     =>  '', /*empty*/
                            'SHPCDE_27'     =>  '', /*empty*/
                            'REP1_27'       =>  $cliente->SLSREP_23,
                            'SPLIT1_27'     =>  100,
                            'REP2_27'       =>  '', /*empty*/
                            'SPLIT2_27'     =>  0,
                            'REP3_27'       =>  '', /*empty*/
                            'SPLIT3_27'     =>  0,
                            'COMMIS_27'     =>  $cliente->COMMIS_23,
                            'TERMS_27'      =>  $cliente->TERMS_23,
                            'SHPVIA_27'     =>  $cliente->SHPVIA_23,
                            'XURR_27'       =>  '', /*empty*/
                            'FOB_27'        =>  $cliente->CITY_23,
                            'TAXCD1_27'     =>  $cliente->TAXCDE1_23,
                            'TAXCD2_27'     =>  '', /*empty*/
                            'TAXCD3_27'     =>  '', /*empty*/
                            'COMNT1_27'     =>  '', /*empty*/
                            'COMNT2_27'     =>  '', /*empty*/
                            'COMNT3_27'     =>  '', /*empty*/
                            'SHPLBL_27'     =>  0,
                            'INVCE_27'      =>  'N',
                            'APPINV_27'     =>  '', /*empty*/
                            'REASON_27'     =>  21, // 23 si es bodega
                            'NAME_27'       =>  $cliente->NAME_23,
                            'ADDR1_27'      =>  $cliente->ADDR1_23,
                            'ADDR2_27'      =>  $cliente->ADDR2_23,
                            'CITY_27'       =>  $cliente->CITY_23,
                            'STATE_27'      =>  $cliente->STATE_23,
                            'ZIPCD_27'      =>  $cliente->ZIPCD_23,
                            'CNTRY_27'      =>  $cliente->CNTRY_23,
                            'PHONE_27'      =>  $cliente->PHONE_23,
                            'CNTCT_27'      =>  $cliente->CNTCT_23,
                            'TAXPRV_27'     =>  $cliente->TAXPRV_23,
                            'FEDTAX_27'     =>  'N',
                            'TAXABL_27'     =>  $cliente->TAXABL_23,
                            'EXCRTE_27'     =>  1,
                            'FIXVAR_27'     =>  'V',
                            'CURR_27'       =>  $cliente->CURR_23,
                            'RCLDTE_27'     =>  null,
                            'FILL02_27'     =>  '', /*empty*/
                            'TTAX_27'       =>  '', /*empty*/
                            'LNETAX_27'     =>  'N',
                            'ADDR3_27'      =>  $cliente->ADDR3_23,
                            'ADDR4_27'      =>  $cliente->ADDR4_23,
                            'ADDR5_27'      =>  $cliente->ADDR5_23,
                            'ADDR6_27'      =>  $cliente->ADDR6_23,
                            'MCOMP_27'      =>  $cliente->MCOMP_23,
                            'MSITE_27'      =>  $cliente->MSITE_23,
                            'UDFKEY_27'     =>  '', /*empty*/
                            'UDFREF_27'     =>  '', /*empty*/
                            'SHPTHRU_27'    =>  '', /*empty*/
                            'XDFINT_27'     =>  0,
                            'XDFFLT_27'     =>  0,
                            'XDFBOL_27'     =>  '', /*empty*/
                            'XDFDTE_27'     =>  '', /*empty*/
                            'XDFTXT_27'     =>  '', /*empty*/
                            'FILLER_27'     =>  '', /*empty*/
                            'CreatedBy'     =>  'EVPIU-'.auth()->user()->username ,
                            'CreationDate'  =>  Carbon::now(),
                            'ModifiedBy'    =>  'EVPIU-'.auth()->user()->username ,
                            'ModificationDate'  =>  Carbon::now(),
                            'BILLCDE_27'    =>  '' /*empty*/
                        ]);


                    $idx = 0;

                    foreach ($detalle_ped as $dp){
                        $n2 = str_pad($idx + 1, 2, 0, STR_PAD_LEFT);


                        $part = DB::connection('MAXP')
                            ->table('Part_Master')
                            ->where('PRTNUM_01', '=', $dp->CodigoProducto)
                            ->first();


                        DB::connection('MAXP')
                            ->table('SO_Detail')
                            ->insert([
                                'ORDNUM_28'     =>  $max_ordnum_27,
                                'LINNUM_28'     =>  $n2,
                                'DELNUM_28'     =>  '01',
                                'STATUS_28'     =>  3,
                                'CUSTID_28'     =>  $encabezado_ped->CodCliente,
                                'PRTNUM_28'     =>  $dp->CodigoProducto,
                                'EDILIN_28'     =>  '', /*empty*/
                                'TAXABL_28'     =>  $cliente->TAXABL_23,
                                'GLXREF_28'     =>  61209505,
                                'CURDUE_28'     =>  '',
                                'QTLINE_28'     =>  '', /*empty*/
                                'ORGDUE_28'     =>  '',
                                'QTDEL_28'      =>  '', /*empty*/
                                'CUSDUE_28'     =>  '',
                                'PROBAB_28'     =>  0,
                                'SHPDTE_28'     =>  '',
                                'FILL04_28'     =>  '', /*empty*/
                                'SLSUOM_28'     =>  'UN',
                                'REFRNC_28'     =>  '',
                                'PRICE_28'      =>  $dp->Precio,
                                'ORGQTY_28'     =>  $dp->Cantidad,
                                'CURQTY_28'     =>  $dp->Cantidad,
                                'BCKQTY_28'     =>  0,
                                'SHPQTY_28'     =>  $dp->Cantidad,
                                'DUEQTY_28'     =>  0,
                                'INVQTY_28'     =>  0,
                                'DISC_28'       =>  $dp->Cantidad,
                                'STYPE_28'      =>  'CU',
                                'PRNT_28'       =>  'N',
                                'AKPRNT_28'     =>  'N',
                                'STK_28'        =>  '', /*empty*/
                                'COCFLG_28'     =>  '', /*empty*/
                                'FORCUR_28'     =>  $dp->Precio,
                                'HSTAT_28'      =>  'R',
                                'SLSREP_28'     =>  '', /*empty*/
                                'COMMIS_28'     =>  0,
                                'DRPSHP_28'     =>  '', /*empty*/
                                'QUMQTY_28'     =>  0,
                                'TAXCDE1_28'    =>  $cliente->TAXCDE1_23,
                                'TAX1_28'       =>  ($dp->Precio * $dp->Cantidad) * 0.19,
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
                            ]);



                        DB::connection('MAXP')
                            ->table('SO_Detail_Ext')
                            ->insert([
                                'ORDER_LIN_DEL'     =>  $max_ordnum_27.$n2."01",
                                'ARTE'              =>  $dp->Arte,
                                'CodProdCliente'    =>  $dp->Cod_prod_cliente,
                                'Marca'             =>  $dp->Marca
                            ]);


                        DB::connection('MAXP')
                            ->table('Order_Master')
                            ->insert([
                                'ORDNUM_10'     =>  $max_ordnum_27,
                                'LINNUM_10'     =>  $n2,
                                'DELNUM_10'     =>  '01',
                                'PRTNUM_10'     =>  $dp->CodigoProducto,
                                'CURDUE_10'     =>  '',
                                'RECFLG_10'     =>  'N',
                                'TAXABLE_10'    =>  'N',
                                'TYPE_10'       =>  'CU',
                                'ORDER_10'      =>  $max_ordnum_27.$n2."01",
                                'VENID_10'      =>  '',  /*empty*/
                                'ORGDUE_10'     =>  '',
                                'PURUOM_10'     =>  '',  /*empty*/
                                'CURQTY_10'     =>  $dp->Cantidad,
                                'ORGQTY_10'     =>  $dp->Cantidad,
                                'DUEQTY_10'     =>  0,
                                'CURPRM_10'     =>  '',
                                'FILL03_10'     =>  '', /*empty*/
                                'ORGPRM_10'     =>  '',
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



                        $cant_comprometida = DB::connection('MAXP')
                            ->table('Part_Sales')
                            ->where('PRTNUM_29', '=', $dp->CodigoProducto)
                            ->pluck('QTYCOM_29');


                        DB::connection('MAXP')
                            ->table('Part_Sales')
                            ->where('PRTNUM_29', '=', $dp->CodigoProducto)
                            ->update([
                                'QTYCOM_29' => $cant_comprometida+$dp->Cantidad
                            ]);

                        $idx++;
                    }
                }
                DB::commit();
                DB::connection('MAXP')->commit();

                return response()->json('Pedido actualizado', 200);
            }catch (\Exception $e){
                DB::rollBack();
                DB::connection('MAXP')->rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }

}
