<?php

namespace App\Http\Controllers;

use App\Notifications\NuevoPedido;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->CodVenUsuario != 999) {
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra','NombreCliente', 'CodCliente','CodCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','created_at')
                    ->where('CodVendedor', '=', $request->CodVenUsuario)
                    ->orderBy('id','desc')
                    ->get();
            }else{
                $data = DB::table('encabezado_pedidos')
                    ->select('id', 'OrdenCompra', 'CodCliente','CodCliente','NombreCliente','DireccionCliente','Ciudad','Telefono',
                        'CodVendedor','NombreVendedor','CondicionPago','Descuento','Iva','Estado','created_at')
                    ->orderBy('id','desc')
                    ->get();
            }

            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Promover" name="Promover" id="'.$row->id.'"><i class="fas fa-check"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Anular" name="Anular" id="'.$row->id.'"><i class="fas fa-times"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Reopen" name="Reopen" id="'.$row->id.'"><i class="fas fa-door-open"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Viewpdf" name="Viewpdf" id="'.$row->id.'"><i class="fas fa-file-pdf"></i></button>';
                    $btn = $btn.'<a href="'.route('pedidos.edit', $row->id).'" class="btn btn-light btn-sm edit" id="edit"><i class="fas fa-edit"></i></a></div>';

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
          $User =  DB::table('users')->where('app_roll','=','vendedor')->get();
        }
        return response()->json($User);
    }

    public function SearchClients(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('MAX')->table('CIEV_V_Clientes')
            ->where('CIEV_V_Clientes.RAZON_SOCIAL', 'LIKE', '%'.$query.'%')
            ->orWhere('CIEV_V_Clientes.CODIGO_CLIENTE', 'LIKE', '%'.$query.'%')->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'         => trim($q->RAZON_SOCIAL),
                'CodigoCliente' => trim($q->CODIGO_CLIENTE),
                'Direccion'     => trim($q->DIRECCION),
                'Ciudad'        => trim($q->CIUDAD),
                'Telefono'      => trim($q->TEL1),
                'Plazo'         => trim($q->PLAZO),
                'retenido'      => trim($q->ACTIVO),
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

        $queries = DB::connection('MAX')->table('CIEV_V_productos')
            ->where('Descripcion', 'LIKE', '%'.$query.'%')
            ->orWhere('Pieza', 'LIKE', '%'.$query.'%')
            ->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'         => trim($q->Pieza).' - '.trim($q->Descripcion),
                'Stock'         => trim($q->Cant),
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
         $date = Carbon::now();
         foreach($destino as $dest){
             if ($dest['destino'] == 'Produccion'){
                 $produccion[] = $dest;
             } else{
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

                     $destino_n = null;
                     if ($d['destino'] == 'Produccion'){
                         $destino_n = 1;
                     }else{
                         $destino_n = 2;
                     }

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
                         'Destino'          => $destino_n,
                         'R_N'              => $d['n_r'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'     =>  $invoice,
                     'created_at'   =>  $date,
                     'updated_at'   =>  $date
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

                    $destino_n = null;
                    if ($d['destino'] == 'Produccion'){
                        $destino_n = 1;
                    }else{
                        $destino_n = 2;
                    }
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
                        'Destino'          => $destino_n,
                        'R_N'              => $d['n_r'],
                        'created_at'       => $date,
                    ]);
                }

                DB::table('pedidos_detalles_area')->insert([
                    'idPedido'     =>  $invoice,
                    'created_at'   =>  $date,
                    'updated_at'   =>  $date
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
                     $destino_n = null;
                     if ($d['destino'] == 'Produccion'){
                         $destino_n = 1;
                     }else{
                         $destino_n = 2;
                     }
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
                         'Destino'          => $destino_n,
                         'R_N'              => $d['n_r'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'     =>  $invoice,
                     'created_at'   =>  $date,
                     'updated_at'   =>  $date
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
                     $destino_n = null;
                     if ($d['destino'] == 'Produccion'){
                         $destino_n = 1;
                     }else{
                         $destino_n = 2;
                     }
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
                         'Destino'          => $destino_n,
                         'R_N'              => $d['n_r'],
                         'created_at'       => $date,
                     ]);
                 }

                 DB::table('pedidos_detalles_area')->insert([
                     'idPedido'     =>  $invoice,
                     'created_at'   =>  $date,
                     'updated_at'   =>  $date
                 ]);

                 DB::commit();
                 return response()->json(['Success' => 'Todo Ok']);
                 $user_name = Auth::user();

                 $this->sendNotification('nuevo_pedido',$invoice,  $user_name);

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

    public function nuevo_pedido_index()
    {
        $vendedores =  DB::table('users')
            ->where('app_roll','=','vendedor')
            ->orderBy('name','asc')
            ->get();

        return view('Pedidos.nuevo_pedido',compact('vendedores'));
    }

    public function edit($id){
        $encabezado = DB::table('encabezado_pedidos')
            ->where('id','=',$id)
            ->first();

        $detalle = DB::table('detalle_pedidos')
            ->where('idPedido','=',$id)
            ->get();


        return view('Pedidos.edit',compact('encabezado','detalle'));
    }

    public function update(Request $request){
        $encabezado = $request->encabezado[0];


        $detalle = $request->Items;


        DB::table('encabezado_pedidos')
            ->where('id','=', $encabezado['id'])
            ->update([
                'OrdenCompra'       =>  $encabezado['OrdComp'],
                'Descuento'         =>  $encabezado['descuento'],
                'Iva'               =>  $encabezado['SelectIva'],
                'Notas'             =>  $encabezado['GeneralNotes'],
                'Bruto'             =>  $encabezado['TotalItemsBruto'],
                'TotalDescuento'    =>  $encabezado['TotalItemsDiscount'],
                'TotalSubtotal'     =>  $encabezado['TotalItemsSubtotal'],
                'TotalIVA'          =>  $encabezado['TotalItemsIva'],
                'TotalPedido'       =>  $encabezado['TotalItemsPrice'],
                'Estado'            =>  1
            ]);


        $id_no_borrar = array();

        $registros = DB::table('detalle_pedidos')
            ->where('idPedido','=',$encabezado['id'])
            ->pluck('id')
            ->toArray();


        foreach ($detalle as $det){
            $existe = DB::table('detalle_pedidos')
                ->where('id','=', $det['id'])
                ->count();

            $destino_n = null;
            if ($det['destino'] === 'Produccion'){
                $destino_n = 1;
            }else{
                $destino_n = 2;
            }

            if ($existe === 1){

                DB::table('detalle_pedidos')
                    ->where('id','=',$det['id'])
                    ->update([
                        'idPedido'          =>  $encabezado['id'],
                        'CodigoProducto'    =>  $det['codproducto'] ,
                        'Descripcion'       =>  $det['producto'],
                        'Arte'              =>  $det['arte'],
                        'Notas'             =>  $det['notas'],
                        'Unidad'            =>  $det['unidad'],
                        'Precio'            =>  $det['precio'],
                        'Cantidad'          =>  $det['cantidad'],
                        'Total'             =>  $det['total'],
                ]);

                array_push($id_no_borrar, intval($det['id']));

            }elseif ($det['id'] === null ){
                $id = DB::table('detalle_pedidos')
                    ->insertGetId([
                        'idPedido'          =>  $encabezado['id'],
                        'CodigoProducto'    =>  $det['codproducto'] ,
                        'Descripcion'       =>  $det['producto'],
                        'Arte'              =>  $det['arte'],
                        'Notas'             =>  $det['notas'],
                        'Unidad'            =>  $det['unidad'],
                        'Precio'            =>  $det['precio'],
                        'Cantidad'          =>  $det['cantidad'],
                        'Total'             =>  $det['total'],
                        'Destino'           =>  $destino_n,
                        'R_N'               =>  $det['n_r'],

                ]);
                array_push($id_no_borrar, intval($id));
            }
        }


        $eliminar = array_diff($registros, $id_no_borrar);

        foreach ($eliminar as $e){
            DB::table('detalle_pedidos')
                ->where('idPedido','=',$encabezado['id'])
                ->delete($e);
        }


        return response()->json('success',200);
    }



    public function sendNotification($type, $id_pedido, $user_name)
    {
        if ($type == 'nuevo_pedido'){
            $users = User::all();

            foreach ($users as $user){
                if ($user->hasRole('super-admin')){
                    $user_name->notify(new NuevoPedido([
                        'title'   => 'Se creo un pedido',
                        'user'    => $user_name,
                        'content' => 'El usuario '.$user_name.' creo el pedido # '.$id_pedido
                    ]));
                }
            }
        }
    }
}
