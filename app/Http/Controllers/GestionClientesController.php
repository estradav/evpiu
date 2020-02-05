<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GestionClientesController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_Clientes')
                ->select('CIEV_V_Clientes.CUSTID_23 as codigo_cliente',
                    'CIEV_V_Clientes.NAME_23 as razon_social',
                    'CIEV_V_Clientes.NIT as nit',
                    'CIEV_V_Clientes.CITY_23 as ciudad',
                    //'CIEV_V_Clientes.CNTRY_23 as pais',
                    //'CIEV_V_Clientes.CUSTYP_23 as tipo_cliente',
                    'CIEV_V_Clientes.NIT as id',
                    'CIEV_V_Clientes.STATUS_23 as estado'
                )
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->codigo_cliente).'/edit" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
                    return $btn;
                })
                ->addColumn('info', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->codigo_cliente).'/edit" class="btn btn-sm btn-outline-light" id="view-customer"><i class="far fa-eye"></i></a>';
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

    public function Show(Request $request)
    {
        return view('GestionClientes.show');
    }
}
