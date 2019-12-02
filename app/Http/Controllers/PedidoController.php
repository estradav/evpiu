<?php

namespace App\Http\Controllers;

use App\EncabezadoPedido;
use App\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

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
            }else{
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra', 'CodCliente','CodCliente','NombreCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','created_at')
                    ->get();
            }

            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Promover" name="Promover" id="'.$row->id.'"><i class="fas fa-check"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Anular" name="Anular" id="'.$row->id.'"><i class="fas fa-times"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Reopen" name="Reopen" id="'.$row->id.'"><i class="fas fa-door-open"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Viewpdf" name="Viewpdf" id="'.$row->id.'"><i class="far fa-file-pdf"></i></button>'.'</div>';

                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('Pedidos.Pedidos');
    }

    public function GetUsers(Request $request)
    {
        if ($request->ajax()){
          $User =  DB::table('users')->where('codvendedor','<>',null)->get();
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

        $queries = DB::connection('MAX')->table('CIEV_V_Inventario')
            ->where('Descripcion', 'LIKE', '%'.$query.'%')
            ->orWhere('Pieza', 'LIKE', '%'.$query.'%')->take(10)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'         => trim($q->Pieza).' - '.trim($q->Descripcion),
                'PriceItem'     => trim('0'),
                'Stock'         => trim($q->CantLiquidable),
                'Code'          => trim($q->Pieza),
                'Descripcion'   => trim($q->Descripcion)

            ];
        }
        return response()->json($results);
    }

    public function SavePedido(Request $request)
    {
         $destino = $request->Items;
         $produccion = [];
         $bodega = [];
         $date = date('Y-m-d H:i:s');
         foreach($destino as $dest){
             if ($dest['destino'] == 1){
                 $produccion[] = $dest;
             }
             else{
                 $bodega[] = $dest;
             }
         }

         if($produccion == null && $bodega != null){
             DB::beginTransaction();
             try{
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
                     'Bruto'             => $request->encabezado[0]['TotalItemsBruto'],
                     'TotalDescuento'    => $request->encabezado[0]['TotalItemsDiscount'],
                     'TotalSubtotal'     => $request->encabezado[0]['TotalItemsSubtotal'],
                     'TotalIVA'          => $request->encabezado[0]['TotalItemsIva'],
                     'TotalPedido'       => $request->encabezado[0]['TotalItemsPrice'],
                     'Notas'             => $request->encabezado[0]['GeneralNotes'],
                     'Destino'           => '2',
                     'created_at'        => $date,
                 ]);

                 foreach ($bodega as $d){
                     DB::table('detalle_pedidos')->insert([
                         'idPedido'         => $invoice,
                         'CodigoProducto'   => $d['codproducto'],
                         'Descripcion'      => $d['producto'],
                         'Arte'             => $d['arte'],
                         'Notas'            => $d['notas'],
                         'Unidad'           => $d['unidad'],
                         'Cantidad'         => $d['cantidad'],
                         'Precio'           => $d['precio'],
                         'Total'            => $d['total'],
                         'Destino'          => $d['destino'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'  =>  $invoice,
                 ]);


                 DB::commit();
                 return response()->json(['Success' => 'Todo Ok']);

             }catch (\Exception $e){
                 DB::rollback();
                 echo json_encode(array(
                     'error' => array(
                         'msg' => $e->getMessage(),
                         'code' => $e->getCode(),
                         'code2' =>$e->getLine(),
                     ),
                 ));
             }
         }

         if($produccion != null && $bodega == null){
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
                    'Bruto'             => $request->encabezado[0]['TotalItemsBruto'],
                    'TotalDescuento'    => $request->encabezado[0]['TotalItemsDiscount'],
                    'TotalSubtotal'     => $request->encabezado[0]['TotalItemsSubtotal'],
                    'TotalIVA'          => $request->encabezado[0]['TotalItemsIva'],
                    'TotalPedido'       => $request->encabezado[0]['TotalItemsPrice'],
                    'Notas'             => $request->encabezado[0]['GeneralNotes'],
                    'Destino'           => '1',
                    'created_at'        => $date,
                ]);

                foreach ($produccion as $d){
                    DB::table('detalle_pedidos')->insert([
                        'idPedido'         => $invoice,
                        'CodigoProducto'   => $d['codproducto'],
                        'Descripcion'      => $d['producto'],
                        'Arte'             => $d['arte'],
                        'Notas'            => $d['notas'],
                        'Unidad'           => $d['unidad'],
                        'Cantidad'         => $d['cantidad'],
                        'Precio'           => $d['precio'],
                        'Total'            => $d['total'],
                        'Destino'          => $d['destino'],
                        'created_at'       => $date,
                    ]);
                }

                DB::table('pedidos_detalles_area')->insert([
                    'idPedido'  =>  $invoice,
                ]);


                DB::commit();
                return response()->json(['Success' => 'Todo Ok']);



            } catch (\Exception $e){
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'code2' =>$e->getLine(),
                    ),
                ));
            }
         }

         if ($produccion != null && $bodega != null){
             DB::beginTransaction();
             try{
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
                     'Bruto'             => $request->encabezado[0]['TotalItemsBruto'],
                     'TotalDescuento'    => $request->encabezado[0]['TotalItemsDiscount'],
                     'TotalSubtotal'     => $request->encabezado[0]['TotalItemsSubtotal'],
                     'TotalIVA'          => $request->encabezado[0]['TotalItemsIva'],
                     'TotalPedido'       => $request->encabezado[0]['TotalItemsPrice'],
                     'Notas'             => $request->encabezado[0]['GeneralNotes'],
                     'Destino'           => '2',
                     'created_at'        => $date,
                 ]);

                 foreach ($bodega as $d){
                     DB::table('detalle_pedidos')->insert([
                         'idPedido'         => $invoice,
                         'CodigoProducto'   => $d['codproducto'],
                         'Descripcion'      => $d['producto'],
                         'Arte'             => $d['arte'],
                         'Notas'            => $d['notas'],
                         'Unidad'           => $d['unidad'],
                         'Cantidad'         => $d['cantidad'],
                         'Precio'           => $d['precio'],
                         'Total'            => $d['total'],
                         'Destino'          => $d['destino'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'  =>  $invoice,
                 ]);


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
                     'Bruto'             => $request->encabezado[0]['TotalItemsBruto'],
                     'TotalDescuento'    => $request->encabezado[0]['TotalItemsDiscount'],
                     'TotalSubtotal'     => $request->encabezado[0]['TotalItemsSubtotal'],
                     'TotalIVA'          => $request->encabezado[0]['TotalItemsIva'],
                     'TotalPedido'       => $request->encabezado[0]['TotalItemsPrice'],
                     'Notas'             => $request->encabezado[0]['GeneralNotes'],
                     'Destino'           => '1',
                     'created_at'        => $date,
                 ]);

                 foreach ($produccion as $d){
                     DB::table('detalle_pedidos')->insert([
                         'idPedido'         => $invoice,
                         'CodigoProducto'   => $d['codproducto'],
                         'Descripcion'      => $d['producto'],
                         'Arte'             => $d['arte'],
                         'Notas'            => $d['notas'],
                         'Unidad'           => $d['unidad'],
                         'Cantidad'         => $d['cantidad'],
                         'Precio'           => $d['precio'],
                         'Total'            => $d['total'],
                         'Destino'          => $d['destino'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'  =>  $invoice,
                 ]);

                 DB::commit();
                 return response()->json(['Success' => 'Todo Ok']);

             }catch (\Exception $e){
                 DB::rollback();
                 echo json_encode(array(
                     'error' => array(
                         'msg' => $e->getMessage(),
                         'code' => $e->getCode(),
                         'code2' =>$e->getLine(),
                     ),
                 ));
             }
         }
    }

    public function PedidoPromoverCartera(Request $request)
    {
        if ($request->ajax()) {
            DB::table('encabezado_pedidos')->where('id','=',$request->id)->update([
               'estado' => 2
            ]);
            DB::table('pedidos_detalles_area')->where('idPedido','=',$request->id)->update([
                'Cartera' => 2
            ]);
            return response()->json();
        }else{
            return response()->json(['Error' => 'Error']);
        }
    }

    public function Estadopedido(Request $request){
        if ($request->ajax()) {
            $resultado = DB::table('encabezado_pedidos')->where('id', '=', $request->id)->select('estado')->get();
            return response()->json($resultado);
        }

    }

    public function PedidoReabrir(Request $request)
    {
        if ($request->ajax()) {
            DB::table('encabezado_pedidos')->where('id','=',$request->id)->update([
                'estado' => 1
            ]);
            return response()->json();
        }else{
            return response()->json(['Error' => 'Error']);
        }
    }

    public function PedidoAnular(Request $request)
    {
        if ($request->ajax()) {
            DB::table('encabezado_pedidos')->where('id','=',$request->id)->update([
                'estado' => 0
            ]);
            return response()->json();
        }else{
            return response()->json(['Error' => 'Error']);
        }
    }

    public function imprimir(Request $request)
    {
        if ($request->ajax()) {
            $encabezado = DB::table('encabezado_pedidos')
                ->join('pedidos_detalles_area','encabezado_pedidos.id','=','pedidos_detalles_area.idPedido')
                ->where('id', '=', $request->id)->get();
            $detalle = DB::table('detalle_pedidos')->where('idPedido', '=', $request->id)->get();

            return response()->json([$encabezado, $detalle]);
        }
    }

    public function getStep(Request $request)
    {
        if ($request->ajax()) {
            $Value = DB::table('pedidos_detalles_area')->where('idPedido','=',$request->id)->get();

            return response()->json($Value);
        }else{
            return response()->json(['Error' => 'Error']);
        }
    }

    public function SearchArts(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('EVPIUM')->table('V_Artes')
            ->where('CodigoArte', 'LIKE', '%'.$query.'%')
            ->take(10)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value' =>  trim($q->CodigoArte)
            ];
        }
        return response()->json($results);
    }
}
