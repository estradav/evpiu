<?php

namespace App\Http\Controllers;

use App\EncabezadoPedido;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->CodVenUsuario != 999)) {
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra', 'CodCliente','CodCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado')
                    ->where('CodVendedor', '=', $request->CodVenUsuario)
                    ->where('estado', '=', $request->Estado)
                    ->get();
            } else {
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra', 'CodCliente','CodCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado')
                    ->get();
            }

            return DataTables::of($data)
                ->make(true);
        }
        return view('Pedidos.Pedidos');
    }

    public function GetUsers(Request $request)
    {
        if ($request->ajax()){
          $User =  DB::table('users')->get();
        }
        return response()->json($User);
    }

    public function SearchClients(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('MAX')->table('CIEV_V_Clientes')
            ->where('CIEV_V_Clientes.NAME_23', 'LIKE', '%'.$query.'%')
            ->orWhere('CIEV_V_Clientes.CUSTID_23', 'LIKE', '%'.$query.'%')->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'         => trim($q->NAME_23),
                'CodigoCliente' => trim($q->CUSTID_23),
                'Direccion'     => trim($q->ADDR1_23),
                'Ciudad'        => trim($q->CITY_23),
                'Telefono'      => trim($q->PHONE_23),
                'Plazo'         => trim($q->PLAZO),
                'retenido'      => trim($q->STATUS_23),
                'descuento'     => number_format($q->DESCUENTO,0,'','')
            ];
        }
        return response()->json($results);
    }

    public function GetCondicion(Request $request)
    {
        if ($request->ajax()){
            $Condicion =  DB::connection('MAX')->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','TERM')
                ->get();
        }
        return response()->json($Condicion);
    }

    public function SearchProductsMax(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('MAX')->table('CIEV_V_Clientes')
            ->where('CIEV_V_Clientes.NAME_23', 'LIKE', '%'.$query.'%')
            ->orWhere('CIEV_V_Clientes.CUSTID_23', 'LIKE', '%'.$query.'%')->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'     => trim($q->NAME_23),
                'PriceItem' => trim($q->CUSTID_23),
                'Stock'     => trim($q->d)
            ];
        }
        return response()->json($results);
    }
}
