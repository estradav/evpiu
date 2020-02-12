<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GestionClientesController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_ClientesMAXDMS')
                ->select('CodigoMAX',
                    'CodigoDMS',
                    'NITMAX',
                    'NombreMAX',
                    'EstadoMAX'
                )
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->CodigoMAX).'/show" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('info', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->CodigoMAX).'/show" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['opciones','info'])
                ->make(true);
        }
        return view('GestionClientes.index');
    }

    public function FormaEnvio(Request $request)
    {
        if ($request->ajax()){
            $FormaEnvio =  DB::connection('MAX')->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','SHIP')
                ->get();
        }
        return response()->json($FormaEnvio);
    }

    public function Plazo(Request $request)
    {
        if ($request->ajax()){
            $Condicion =  DB::connection('MAX')->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','TERM')
                ->get();
        }
        return response()->json($Condicion);
    }

    public function Paises(Request $request)
    {
        if ($request->ajax()){
            $Paises =  DB::connection('DMS')->table('y_paises')
                ->get();
        }
        return response()->json($Paises);
    }

    public function Departamentos(Request $request)
    {
        if ($request->ajax()){
            $Departamentos =  DB::connection('DMS')->table('y_departamentos')
                ->where('pais','=', $request->id_pais)
                ->get();
        }
        return response()->json($Departamentos);
    }

    public function Ciudades(Request $request)
    {
        if ($request->ajax()){
            $Ciudades =  DB::connection('DMS')->table('y_ciudades')
                ->where('pais','=', $request->id_pais)
                ->where('departamento', '=',$request->id_departamento)
                ->get();
        }
        return response()->json($Ciudades);
    }

    public function TipoCliente(Request $request)
    {
        if ($request->ajax()){
            $Tipo_cliente =  DB::connection('MAX')->table('Customer_Types')
                ->get();
        }
        return response()->json($Tipo_cliente);
    }

    public function GuardarCliente(Request $request)
    {
        DB::beginTransaction();
    }

    public function show($numero)
    {
        $facturas = DB::connection('MAX')
            ->table('invoice_master')
            ->where('CUSTID_31','=',$numero)
            ->where('STYPE_31','=','CU')
            ->count();

        $notas_credito = DB::connection('MAX')
            ->table('invoice_master')
            ->where('CUSTID_31','=',$numero)
            ->where('STYPE_31','=','CR')
            ->count();

        $cliente = DB::connection('MAX')
            ->table('CIEV_V_Clientes')
            ->where('CODIGO_CLIENTE','=',$numero)
            ->get();

        $productos_tendencia = DB::connection('MAX')
            ->table('CIEV_V_FacturasDetalladas')
            ->where('CodigoCliente','=',$numero)
            ->select('CodigoProducto',
                DB::raw('count(*) as Total'),
                DB::raw('sum(Cantidad) as Comprado'))
            ->groupBy('CodigoProducto')
            ->orderBy('Comprado','desc')
            ->take(5)
            ->get()
            ->toArray();


        return view('GestionClientes.show')->with([
            'facturas'          => $facturas,
            'notas_credito'     => $notas_credito,
            'cliente'           => $cliente,
            'productos_tend'    => $productos_tendencia,
        ]);


    }

    public function ProductosEnTendenciaPorMes(Request $request)
    {
        $current_year = Carbon::now();
        $current_year = $current_year->year;

        $ene = 0;
        $feb = 0;
        $mar = 0;
        $abr = 0;
        $may = 0;
        $jun = 0;
        $jul = 0;
        $ago = 0;
        $sep = 0;
        $oct = 0;
        $nov = 0;
        $dic = 0;

        if (request()->ajax()){

            if (!empty($request->from_date)) {

            }else{
                for ($i = 1; $i <= 12; $i++){
                    $tendencia_mes = DB::connection('MAX')
                        ->table('CIEV_V_FacturasDetalladas')
                        ->where('CodigoCliente','=',$request->cliente)
                        ->where('Año','=',$current_year)
                        ->where('Mes','=',$i)
                        ->select(DB::raw('sum(TotalItem) as Base'))
                        ->groupBy( 'Mes')
                        ->get();

                    if ($i == 1){
                        $ene = $tendencia_mes[0]->Base;
                    }
                    if ($i == 2){
                        $feb = $tendencia_mes[0]->Base;
                    }
                    if ($i == 3){
                        $mar = $tendencia_mes[0]->Base;
                    }
                    if ($i == 4){
                        $abr = $tendencia_mes[0]->Base;
                    }
                    if ($i == 5){
                        $may = $tendencia_mes[0]->Base;
                    }
                    if ($i == 6){
                        $jun = $tendencia_mes[0]->Base;
                    }
                    if ($i == 7){
                        $jul = $tendencia_mes[0]->Base;
                    }
                    if ($i == 8){
                        $ago = $tendencia_mes[0]->Base;
                    }
                    if ($i == 9){
                        $sep = $tendencia_mes[0]->Base;
                    }
                    if ($i == 10){
                        $oct = $tendencia_mes[0]->Base;
                    }
                    if ($i == 11){
                        $nov = $tendencia_mes[0]->Base;
                    }
                    if ($i == 12){
                        $dic = $tendencia_mes[0]->Base;
                    }

                }
            }

            return response()->json([
                'ene'   => $ene,
                'feb'   => $feb,
                'mar'   => $mar,
                'abr'   => $abr,
                'may'   => $may,
                'jun'   => $jun,
                'jul'   => $jul,
                'ago'   => $ago,
                'sep'   => $sep,
                'oct'   => $oct,
                'nov'   => $nov,
                'dic'   => $dic
            ]);
        }
    }

    public function ClientesFaltantesDMS(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_ClientesMAX_DMS')
                ->where('CodigoDMS','=',null)
                ->select('CodigoMAX',
                    'CodigoDMS',
                    'NITMAX',
                    'NombreMAX',
                    'EstadoMAX'
                )
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="javascript:void(0)" class="btn btn-sm btn-outline-light Sync-DMS" id="'.trim($row->CodigoMAX).'"><i class="fas fa-sync-alt"></i> Sync</a>';
                    return $btn;
                })

                ->rawColumns(['opciones'])
                ->make(true);
        }
    }


}
