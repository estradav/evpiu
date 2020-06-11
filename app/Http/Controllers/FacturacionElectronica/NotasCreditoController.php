<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class NotasCreditoController extends Controller
{

    /**
     * Envia un conjunto de facturas al WebService de fenalco
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws Exception
     */
    public function index(Request $request){
        $fromdate = Carbon::now()->format('Y-m-d 00:00:00');
        $todate = Carbon::now()->format('Y-m-d 23:59:59');

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $data = DB::connection('MAX')
                    ->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE_FacturasTotalizadas.bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.OC as OC',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente',
                        'CIEV_V_FE.codigo_alterno as cod_alter')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc','=','CR')
                    ->whereBetween('fecha', array($request->from_date, $request->to_date))
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }else {
                $data = DB::connection('MAX')
                    ->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE_FacturasTotalizadas.bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.OC',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente',
                        'CIEV_V_FE.codigo_alterno as cod_alter')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc','=','CR')
                    ->whereBetween('fecha', array($fromdate, $todate))
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/nc/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="edit-fac"><i class="fas fa-edit" style="color: #3085d6"></i></a>';
                    $btn = $btn.'<button class="btn btn-sm btn-outline-light download-vg" id="'.$row->id.'"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>'.'</div>';
                    return $btn;
                })
                ->addColumn('selectAll', function($row){
                    $btn = '<input type="checkbox" class="checkboxes test" id="'.$row->id.'" name="'.$row->id.'">';
                    return $btn;
                })
                ->addColumn('EstadoDian',function($row){
                    $div = '<div class="container" style="align-items: center !important; margin-left: 2px; margin-right: 2px"><div class="preloader_datatable"></div>';
                    return $div;
                })
                ->rawColumns(['opciones','selectAll','EstadoDian'])
                ->make(true);
        }
        return view('aplicaciones.facturacion_electronica.notas_credito.index');
    }
}
