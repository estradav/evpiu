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
                    ->select('id', 'OrdenCompra','NombreCliente', 'CodCliente','CodCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','created_at')
                    ->where('CodVendedor', '=', $request->CodVenUsuario)
                    ->where('estado', '=', $request->Estado)
                    ->get();
            } else {
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra', 'CodCliente','CodCliente','NombreCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','created_at')
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

        $queries = DB::connection('MAX')->table('CIEV_V_ProductosVentaStock')
            ->where('CIEV_V_ProductosVentaStock.Descripcion1', 'LIKE', '%'.$query.'%')
            ->orWhere('CIEV_V_ProductosVentaStock.Producto', 'LIKE', '%'.$query.'%')->take(10)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'     => trim($q->Producto).' - '.trim($q->Descripcion1),
                'PriceItem' => trim('0'),
                'Stock'     => trim($q->Inventario)
            ];
        }
        return response()->json($results);
    }

    public function SavePedido(Request $request)
    {
        $date = date('Y-m-d H:i:s');

         DB::beginTransaction();
        try {
            $invoice = DB::table('encabezado_pedidos')->insertGetId([
                'OrdenCompra'       => $request->encabezado[0]['OrdComp'],
                'CodCliente'        => $request->encabezado[0]['CodCliente'],
                'NombreCliente'     => $request->encabezado[0]['NombreCliente'],
                'DireccionCliente'  => $request->encabezado[0]['address'],
                'Ciudad'            => $request->encabezado[0]['city'],
                'Telefono'          => $request->encabezado[0]['phone'],
                'CodVendedor'       => $request->encabezado[0]['CodVendedor'],
                'NombreVendedor'    => $request->encabezado[0]['NombreVendedor'],
                'CondicionPago'     => $request->encabezado[0]['CondicionPago'],
                'Descuento'         => $request->encabezado[0]['descuento'],
                'Iva'               => $request->encabezado[0]['SelectIva'],
                'Estado'            => '1',
                'created_at'        => $date,
            ]);


            $data = $request->Items;
            foreach ($data as $d){
                DB::table('detalle_pedido')->insert([
                    'idPedido'         => $invoice,
                    'CodigoProducto'   => $d['producto'],
                    'Descripcion'      => $d['producto'],
                    'Notas'            => $d['notas'],
                    'Unidad'           => $d['unidad'],
                    'Cantidad'         => $d['cantidad'],
                    'Precio'           => $d['precio'],
                    'Total'            => $d['total'],
                    'created_at'       => $date,
                ]);
            }
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

            return response()->json(['Error' => 'Fallo']);
        }
    }
}
