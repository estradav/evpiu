<?php

namespace App\Http\Controllers\Pedidos;

use App\EncabezadoPedido;
use App\Http\Controllers\Controller;
use App\MaestroPedido;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class VentasController extends Controller
{
    /**
     * lista de pedidos creados por el vendedor
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request){
        if ($request->ajax()){
            if (Auth::user()->hasRole('super-admin')){
                $data = EncabezadoPedido::orderBy('id', 'asc')
                    ->with('cliente' ,'info_area')
                    ->get();

            }else{
                $data = EncabezadoPedido::where('vendedor_id', auth()->user()->id)
                    ->with('cliente')
                    ->orderBy('id','desc')
                    ->get();
            }

            return Datatables::of($data)
                ->editColumn('created_at', function ($row){
                    Carbon::setLocale('es');
                    return  $row->created_at->format('d M Y h:i a');
                })
                ->addColumn('opciones', function($row){
                    return '
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="option_dropdown_menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <i class="fas fa-bars"></i>  Acciones
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button class="dropdown-item promover" type="button" id="'.$row->id.'">ENVIAR A CARTERA</button>
                                <button class="dropdown-item anular" type="button" id="'.$row->id.'">ANULAR</button>
                                <button class="dropdown-item re_abrir" type="button" id="'.$row->id.'">RE-ABRIR</button>
                                <button class="dropdown-item ver_pdf" type="button" id="'.$row->id.'">VER</button>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="'.route('venta.edit', $row->id).'" >EDITAR</a>
                                <button class="dropdown-item clonar" type="button" id="'.$row->id.'">CLONAR</button>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('aplicaciones.pedidos.ventas.index');
    }


    /**
     * Enviar el pedido al area de cartera,
     * evalua si cumple las condiciones para ser enviado
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function enviar_cartera(Request $request){
        if ($request->ajax()){
            try {
                $pedido = EncabezadoPedido::find($request->id);

                if ($pedido->Estado == 0){
                    return response()
                        ->json('Este pedido esta anulado, para poder enviarlo a cartera debe estar en estado borrador', 500);

                } else if ($pedido->Estado == 1){
                    $pedido->Estado = 2;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Cartera' => 2
                    ]);

                    return response()
                        ->json('Pedido enviado a cartera', 200);

                }else if ($pedido->Estado == 2){
                    return response()
                        ->json('Este pedido ya fue enviado a cartera', 500);

                }else if ($pedido->Estado > 3 && $pedido->Estado < 11){
                    return response()
                        ->json('Este pedido no puede ser enviado a cartera, por que actualmente lo esta gestionando otra area', 500);

                }else if($pedido->Estado == 10){
                    return response()
                        ->json('Este pedido ya fue completado', 500);

                }
            }catch (Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Cambia el estado del pedido a anulado
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function anular_pedido(Request $request){
        if ($request->ajax()){
            try {
                $pedido = EncabezadoPedido::find($request->id);

                if ($pedido->Estado > 0 && $pedido->Estado <= 5){

                    $pedido->Estado = 0;
                    $pedido->save();

                    return response()
                        ->json('Pedido anulado', 200);

                }else if ($pedido->Estado == 0){
                    return response()
                        ->json('Este pedido ya fue anulado', 500);
                }else{
                    return response()
                        ->json('Este pedido no puede ser anulado', 500);
                }
            }catch (Exception $e){
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Cambia el estado del pedido a borrador, solo se puede realizar
     * esta accion si el pedido esta en estado anulado
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function re_abrir_pedido(Request $request){
        if ($request->ajax()){
            try {
                $pedido = EncabezadoPedido::find($request->id);

                if ($pedido->Estado == 0){

                    $pedido->Estado = 1;
                    $pedido->save();

                    return response()
                        ->json('Pedido actualizado', 200);
                }else{
                    return response()
                        ->json('Solo puedes re-abrir pedidos que han sido anulados', 500);
                }
            }catch (Exception $e){
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Formulario de edicion de pedidos, si el pedido pasa al area de
     * costos no podra ser editado, adicionalmente solo lo podra editar
     * el usuario que creo o sele asigno el pedido
     *
     * @param $id
     * @return RedirectResponse
     */
    public function edit($id){
        try {
            $encabezado = EncabezadoPedido::with('detalle', 'cliente')->find($id);

            if ($encabezado->Estado == 0 || $encabezado->Estado == 1 || $encabezado->Estado == 3 || $encabezado->Estado == 5 || $encabezado->Estado == 7 || $encabezado->Estado == 9 ||  $encabezado->Estado == 12){
                return view('aplicaciones.pedidos.ventas.edit',
                    compact('encabezado'));

            }else{
                return redirect()
                    ->back()
                    ->with([
                        'message'    => 'Solo se puede editar un pedido en estado borrador o anulado',
                        'alert-type' => 'error'
                    ]);
            }
        }catch (Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
            ]);
        }
    }



    /**
     * Obtiene la lista de productos de la bd de max
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function listar_productos_max(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();
                $queries = DB::connection('MAX')
                    ->table('CIEV_V_productos')
                    ->where('Descripcion', 'LIKE', '%'.$query.'%')
                    ->orWhere('Pieza', 'LIKE', '%'.$query.'%')
                    ->take(20)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value'         => trim($q->Pieza).' - '.trim($q->Descripcion),
                        'stock'         => trim($q->Cant),
                        'codigo'        => trim($q->Pieza),
                        'descripcion'   => trim($q->Descripcion)

                    ];
                }
                return response()->json($results, 200);
            }catch (Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Listado de artes
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function listar_artes(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();
                $queries = DB::connection('EVPIUM')
                    ->table('V_Artes')
                    ->where('CodigoArte', 'LIKE', '%'.$query.'%')
                    ->take(10)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value' =>  trim($q->CodigoArte)
                    ];
                }
                return response()->json($results, 200);
            }catch (Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Actualizacion de pedido luego de la edicion
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $encabezado = $request->encabezado;
                $detalle = $request->items;
                $destino_produccion = array();
                $destino_bodega = array();
                $destino_troqueles = array();

                foreach ($detalle as $det){
                    if ($det['destino'] == 'Produccion'){
                        array_push($destino_produccion, $det);
                    }
                    else if($det['destino'] == 'Bodega'){
                        array_push($destino_bodega, $det);
                    }
                    else if($det['destino'] == 'Troqueles'){
                        array_push($destino_troqueles, $det);
                    }
                }


                if (sizeof($detalle) == 0){
                    return response()
                        ->json('Debe agregar al menos un producto antes de guardar el pedido', 500);
                }else{
                    if(sizeof($destino_produccion) == sizeof($detalle)){
                        EncabezadoPedido::where('id', $encabezado['id'])
                            ->update([
                                'OrdenCompra'       =>  $encabezado['oc'],
                                'Descuento'         =>  $encabezado['descuento'],
                                'Iva'               =>  $encabezado['tiene_iva'],
                                'Notas'             =>  $encabezado['notas_generales'],
                                'Bruto'             =>  $encabezado['total_bruto'],
                                'TotalDescuento'    =>  $encabezado['total_descuento'],
                                'TotalSubtotal'     =>  $encabezado['subtotal'],
                                'TotalIVA'          =>  $encabezado['total_iva'],
                                'TotalPedido'       =>  $encabezado['total_pedido'],
                                'Estado'            =>  1,
                                'Destino'           =>  1
                            ]);



                        if (!empty($encabezado['id_maestro'])){

                            MaestroPedido::where('id', $encabezado['id_maestro'])
                                ->update([
                                    'id_bodega'     => null,
                                    'id_produccion' => $encabezado['id'],
                                    'id_troqueles'  => null,
                                    'updated_at'    => Carbon::now()
                                ]);
                        }


                        $id_no_borrar = array();
                        $registros = DB::table('detalle_pedidos')
                            ->where('idPedido','=', $encabezado['id'])
                            ->pluck('id')
                            ->toArray();

                        foreach ($destino_produccion as $det) {

                            $existe = DB::table('detalle_pedidos')
                                ->where('id', '=', $det['id'])
                                ->count();


                            if ($existe == 1){
                                DB::table('detalle_pedidos')
                                    ->where('id','=',$det['id'])
                                    ->update([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  1,

                                    ]);

                                array_push($id_no_borrar, intval($det['id']));

                            }elseif ($det['id'] == null){
                                $id = DB::table('detalle_pedidos')
                                    ->insertGetId([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  1,

                                    ]);
                                array_push($id_no_borrar, intval($id));
                            }
                        }
                        $eliminar = array_diff($registros, $id_no_borrar);

                        foreach ($eliminar as $e){
                            DB::table('detalle_pedidos')
                                ->where('idPedido','=', $encabezado['id'])
                                ->delete($e);
                        }
                    }
                    else if(sizeof($destino_bodega) == sizeof($detalle)){
                        DB::table('encabezado_pedidos')
                            ->where('id','=', $encabezado['id'])
                            ->update([
                                'OrdenCompra'       =>  $encabezado['oc'],
                                'Descuento'         =>  $encabezado['descuento'],
                                'Iva'               =>  $encabezado['tiene_iva'],
                                'Notas'             =>  $encabezado['notas_generales'],
                                'Bruto'             =>  $encabezado['total_bruto'],
                                'TotalDescuento'    =>  $encabezado['total_descuento'],
                                'TotalSubtotal'     =>  $encabezado['subtotal'],
                                'TotalIVA'          =>  $encabezado['total_iva'],
                                'TotalPedido'       =>  $encabezado['total_pedido'],
                                'Estado'            =>  1,
                                'Destino'           =>  2
                            ]);


                        if (!empty($encabezado['id_maestro'])){
                            DB::table('maestro_pedidos')
                                ->where('id', '=', $encabezado['id_maestro'])
                                ->update([
                                    'id_bodega'     => $encabezado['id'],
                                    'updated_at'    => Carbon::now()
                                ]);
                        }

                        $id_no_borrar = array();
                        $registros = DB::table('detalle_pedidos')
                            ->where('idPedido','=', $encabezado['id'])
                            ->pluck('id')
                            ->toArray();


                        foreach ($destino_bodega as $det) {

                            $existe = DB::table('detalle_pedidos')
                                ->where('id', '=', $det['id'])
                                ->count();


                            if ($existe == 1){
                                DB::table('detalle_pedidos')
                                    ->where('id','=',$det['id'])
                                    ->update([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  2,
                                    ]);

                                array_push($id_no_borrar, intval($det['id']));

                            }elseif ($det['id'] == null){
                                $id = DB::table('detalle_pedidos')
                                    ->insertGetId([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  2,

                                    ]);
                                array_push($id_no_borrar, intval($id));
                            }
                        }
                        $eliminar = array_diff($registros, $id_no_borrar);


                        foreach ($eliminar as $e){
                            DB::table('detalle_pedidos')
                                ->where('idPedido','=', $encabezado['id'])
                                ->delete($e);
                        }
                    }
                    else if(sizeof($destino_troqueles) == sizeof($detalle)){
                        DB::table('encabezado_pedidos')
                            ->where('id','=', $encabezado['id'])
                            ->update([
                                'OrdenCompra'       =>  $encabezado['oc'],
                                'Descuento'         =>  $encabezado['descuento'],
                                'Iva'               =>  $encabezado['tiene_iva'],
                                'Notas'             =>  $encabezado['notas_generales'],
                                'Bruto'             =>  $encabezado['total_bruto'],
                                'TotalDescuento'    =>  $encabezado['total_descuento'],
                                'TotalSubtotal'     =>  $encabezado['subtotal'],
                                'TotalIVA'          =>  $encabezado['total_iva'],
                                'TotalPedido'       =>  $encabezado['total_pedido'],
                                'Estado'            =>  1,
                                'Destino'           =>  3
                            ]);


                        if (!empty($encabezado['id_maestro'])){
                            DB::table('maestro_pedidos')
                                ->where('id', '=', $encabezado['id_maestro'])
                                ->update([
                                    'id_bodega'     => null,
                                    'id_produccion' => null,
                                    'id_troqueles'  => $encabezado['id'],
                                    'updated_at'    => Carbon::now()
                                ]);
                        }

                        $id_no_borrar = array();
                        $registros = DB::table('detalle_pedidos')
                            ->where('idPedido','=', $encabezado['id'])
                            ->pluck('id')
                            ->toArray();

                        foreach ($destino_produccion as $det) {
                            $existe = DB::table('detalle_pedidos')
                                ->where('id', '=', $det['id'])
                                ->count();

                            if ($existe === 1){
                                DB::table('detalle_pedidos')
                                    ->where('id','=',$det['id'])
                                    ->update([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  3,
                                    ]);

                                array_push($id_no_borrar, intval($det['id']));

                            }elseif ($det['id'] === null){
                                $id = DB::table('detalle_pedidos')
                                    ->insertGetId([
                                        'idPedido'          =>  $encabezado['id'],
                                        'CodigoProducto'    =>  $det['cod'] ,
                                        'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                        'Descripcion'       =>  $det['producto'],
                                        'Arte'              =>  $det['arte'],
                                        'Marca'             =>  $det['marca'],
                                        'Notas'             =>  $det['notas'],
                                        'R_N'               =>  $det['n_r'],
                                        'Unidad'            =>  $det['unidad'],
                                        'Precio'            =>  $det['precio'],
                                        'Cantidad'          =>  $det['cantidad'],
                                        'Total'             =>  $det['total'],
                                        'Destino'           =>  3,

                                    ]);
                                array_push($id_no_borrar, intval($id));
                            }
                        }
                        $eliminar = array_diff($registros, $id_no_borrar);

                        foreach ($eliminar as $e){
                            DB::table('detalle_pedidos')
                                ->where('idPedido','=', $encabezado['id'])
                                ->delete($e);
                        }
                    }
                    else{
                        $maestro = DB::table('maestro_pedidos')
                            ->where('id', '=', $encabezado['id_maestro'])
                            ->first();

                        if(sizeof($destino_produccion) > 0){
                            $estado_destino = DB::table('encabezado_pedidos')
                                ->where('id', '=', $maestro->id_produccion)
                                ->pluck('Estado')
                                ->first();


                            if ($maestro->id_produccion != null && $estado_destino < 10){
                                foreach ($destino_produccion as $det) {
                                    $existe = DB::table('detalle_pedidos')
                                        ->where('id', '=', $det['id'])
                                        ->count();

                                    if ($existe === 1){
                                        DB::table('detalle_pedidos')
                                            ->where('id','=',$det['id'])
                                            ->update([
                                                'idPedido'          =>  $maestro->id_produccion,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  1,
                                            ]);
                                    }elseif ($det['id'] === null){
                                        DB::table('detalle_pedidos')
                                            ->insertGetId([
                                                'idPedido'          =>  $maestro->id_produccion,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  1,
                                            ]);
                                    }
                                }
                            }
                            else{
                                $id_pedido = DB::table('encabezado_pedidos')
                                    ->insertGetId([
                                        'OrdenCompra'       => $request->encabezado['oc'],
                                        'CodCliente'        => $request->encabezado['cod_cliente'],
                                        'NombreCliente'     => $request->encabezado['nombre_cliente'],
                                        'DireccionCliente'  => $request->encabezado['direccion'],
                                        'Ciudad'            => $request->encabezado['ciudad'],
                                        'Telefono'          => $request->encabezado['telefono'],
                                        'CodVendedor'       => $request->encabezado['vendedor'],
                                        'NombreVendedor'    => User::where('codvendedor','=', $request->encabezado['vendedor'])->pluck('name')->first(),
                                        'CondicionPago'     => $request->encabezado['condicion_pago'],
                                        'Descuento'         => $request->encabezado['descuento'],
                                        'Iva'               => $request->encabezado['tiene_iva'],
                                        'Estado'            => 1,
                                        'Bruto'             => $request->encabezado['total_bruto'],
                                        'TotalDescuento'    => $request->encabezado['total_descuento'],
                                        'TotalSubtotal'     => $request->encabezado['subtotal'],
                                        'TotalIVA'          => $request->encabezado['total_iva'],
                                        'TotalPedido'       => $request->encabezado['total_pedido'],
                                        'Notas'             => $request->encabezado['notas_generales'],
                                        'Destino'           => 1,
                                        'created_at'        => Carbon::now(),
                                    ]);


                                foreach ($destino_produccion as $item){
                                    DB::table('detalle_pedidos')
                                        ->insert([
                                            'idPedido'          =>  $id_pedido,
                                            'CodigoProducto'    =>  $item['cod'] ,
                                            'Cod_prod_cliente'  =>  $item['cod_prod_cliente'],
                                            'Descripcion'       =>  $item['producto'],
                                            'Arte'              =>  $item['arte'],
                                            'Marca'             =>  $item['marca'],
                                            'Notas'             =>  $item['notas'],
                                            'R_N'               =>  $item['n_r'],
                                            'Unidad'            =>  $item['unidad'],
                                            'Precio'            =>  $item['precio'],
                                            'Cantidad'          =>  $item['cantidad'],
                                            'Total'             =>  $item['total'],
                                            'Destino'           =>  1,
                                    ]);
                                }

                                /* DB::table('pedidos_log')
                                     ->insert([
                                         'id_pedido'     =>  $id_pedido,
                                         'area'          =>  'VENTAS',
                                         'detalle'       =>  'creo un pedido para produccion',
                                         'usuario'       =>  Auth::user()->username,
                                         'created_at'    =>  Carbon::now(),
                                         'updated_at'    =>  Carbon::now()
                                     ]);*/

                                DB::table('pedidos_detalles_area')
                                    ->insert([
                                        'idPedido'     =>  $id_pedido,
                                        'created_at'   =>  Carbon::now(),
                                        'updated_at'   =>  Carbon::now(),
                                    ]);


                                if ($maestro->id_produccion !== null){
                                    $maestro_nuevo = DB::table('maestro_pedidos')
                                        ->insertGetId([
                                            'created_at'    =>  Carbon::now(),
                                            'updated_at'    =>  Carbon::now()
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $maestro_nuevo
                                        ]);
                                }else{
                                    DB::table('maestro_pedidos')
                                        ->where('id', '=', $encabezado['id_maestro'])
                                        ->update([
                                            'id_produccion'  =>  $id_pedido
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $encabezado['id_maestro']
                                        ]);

                                }
                            }
                        }
                        if(sizeof($destino_bodega) > 0){
                            $estado_destino = DB::table('encabezado_pedidos')
                                ->where('id', '=', $maestro->id_bodega)
                                ->pluck('Estado')
                                ->first();

                            if ($maestro->id_bodega !== null && $estado_destino < 10){
                                foreach ($destino_bodega as $det) {
                                    $existe = DB::table('detalle_pedidos')
                                        ->where('id', '=', $det['id'])
                                        ->count();

                                    if ($existe === 1){
                                        DB::table('detalle_pedidos')
                                            ->where('id','=',$det['id'])
                                            ->update([
                                                'idPedido'          =>  $maestro->id_bodega,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  2,
                                            ]);
                                    }elseif ($det['id'] === null){
                                        DB::table('detalle_pedidos')
                                            ->insertGetId([
                                                'idPedido'          =>  $maestro->id_bodega,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  2,
                                            ]);
                                    }
                                }
                            }else{
                                $id_pedido = DB::table('encabezado_pedidos')
                                    ->insertGetId([
                                        'OrdenCompra'       => $request->encabezado['oc'],
                                        'CodCliente'        => $request->encabezado['cod_cliente'],
                                        'NombreCliente'     => $request->encabezado['nombre_cliente'],
                                        'DireccionCliente'  => $request->encabezado['direccion'],
                                        'Ciudad'            => $request->encabezado['ciudad'],
                                        'Telefono'          => $request->encabezado['telefono'],
                                        'CodVendedor'       => $request->encabezado['vendedor'],
                                        'NombreVendedor'    => User::where('codvendedor','=', $request->encabezado['vendedor'])->pluck('name')->first(),
                                        'CondicionPago'     => $request->encabezado['condicion_pago'],
                                        'Descuento'         => $request->encabezado['descuento'],
                                        'Iva'               => $request->encabezado['tiene_iva'],
                                        'Estado'            => 1,
                                        'Bruto'             => $request->encabezado['total_bruto'],
                                        'TotalDescuento'    => $request->encabezado['total_descuento'],
                                        'TotalSubtotal'     => $request->encabezado['subtotal'],
                                        'TotalIVA'          => $request->encabezado['total_iva'],
                                        'TotalPedido'       => $request->encabezado['total_pedido'],
                                        'Notas'             => $request->encabezado['notas_generales'],
                                        'Destino'           => 2,
                                        'created_at'        => Carbon::now(),
                                    ]);


                                foreach ($destino_bodega as $item){
                                    DB::table('detalle_pedidos')
                                        ->insert([
                                            'idPedido'          => $id_pedido,
                                            'CodigoProducto'    =>  $item['cod'] ,
                                            'Cod_prod_cliente'  =>  $item['cod_prod_cliente'],
                                            'Descripcion'       =>  $item['producto'],
                                            'Arte'              =>  $item['arte'],
                                            'Marca'             =>  $item['marca'],
                                            'Notas'             =>  $item['notas'],
                                            'R_N'               =>  $item['n_r'],
                                            'Unidad'            =>  $item['unidad'],
                                            'Precio'            =>  $item['precio'],
                                            'Cantidad'          =>  $item['cantidad'],
                                            'Total'             =>  $item['total'],
                                            'Destino'           =>  2,
                                            'created_at'        => Carbon::now(),
                                        ]);
                                }

                                /* DB::table('pedidos_log')
                                     ->insert([
                                         'id_pedido'     =>  $id_pedido,
                                         'area'          =>  'VENTAS',
                                         'detalle'       =>  'creo un pedido para produccion',
                                         'usuario'       =>  Auth::user()->username,
                                         'created_at'    =>  Carbon::now(),
                                         'updated_at'    =>  Carbon::now()
                                     ]);*/

                                DB::table('pedidos_detalles_area')
                                    ->insert([
                                        'idPedido'     =>  $id_pedido,
                                        'created_at'   =>  Carbon::now(),
                                        'updated_at'   =>  Carbon::now(),
                                    ]);


                                if ($maestro->id_bodega !== null){
                                    $maestro_nuevo = DB::table('maestro_pedidos')
                                        ->insertGetId([
                                            'created_at'    =>  Carbon::now(),
                                            'updated_at'    =>  Carbon::now()
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $maestro_nuevo
                                        ]);
                                }else{
                                    DB::table('maestro_pedidos')
                                        ->where('id', '=', $encabezado['id_maestro'])
                                        ->update([
                                            'id_bodega'  =>  $id_pedido
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $encabezado['id_maestro']
                                        ]);

                                }
                            }
                        }
                        if(sizeof($destino_troqueles) > 0){
                            $estado_destino = DB::table('encabezado_pedidos')
                                ->where('id', '=', $maestro->id_troqueles)
                                ->pluck('Estado')
                                ->first();

                            if ($maestro->id_troqueles !== null && $estado_destino < 10){
                                foreach ($destino_bodega as $det) {
                                    $existe = DB::table('detalle_pedidos')
                                        ->where('id', '=', $det['id'])
                                        ->count();

                                    if ($existe == 1){
                                        DB::table('detalle_pedidos')
                                            ->where('id','=',$det['id'])
                                            ->update([
                                                'idPedido'          =>  $maestro->id_troqueles,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  3,
                                            ]);
                                    }elseif ($det['id'] === null){
                                        DB::table('detalle_pedidos')
                                            ->insertGetId([
                                                'idPedido'          =>  $maestro->id_troqueles,
                                                'CodigoProducto'    =>  $det['cod'] ,
                                                'Cod_prod_cliente'  =>  $det['cod_prod_cliente'],
                                                'Descripcion'       =>  $det['producto'],
                                                'Arte'              =>  $det['arte'],
                                                'Marca'             =>  $det['marca'],
                                                'Notas'             =>  $det['notas'],
                                                'R_N'               =>  $det['n_r'],
                                                'Unidad'            =>  $det['unidad'],
                                                'Precio'            =>  $det['precio'],
                                                'Cantidad'          =>  $det['cantidad'],
                                                'Total'             =>  $det['total'],
                                                'Destino'           =>  3,
                                            ]);
                                    }
                                }
                            }else{
                                $id_pedido = DB::table('encabezado_pedidos')
                                    ->insertGetId([
                                        'OrdenCompra'       => $request->encabezado['oc'],
                                        'CodCliente'        => $request->encabezado['cod_cliente'],
                                        'NombreCliente'     => $request->encabezado['nombre_cliente'],
                                        'DireccionCliente'  => $request->encabezado['direccion'],
                                        'Ciudad'            => $request->encabezado['ciudad'],
                                        'Telefono'          => $request->encabezado['telefono'],
                                        'CodVendedor'       => $request->encabezado['vendedor'],
                                        'NombreVendedor'    => User::where('codvendedor','=', $request->encabezado['vendedor'])->pluck('name')->first(),
                                        'CondicionPago'     => $request->encabezado['condicion_pago'],
                                        'Descuento'         => $request->encabezado['descuento'],
                                        'Iva'               => $request->encabezado['tiene_iva'],
                                        'Estado'            => 1,
                                        'Bruto'             => $request->encabezado['total_bruto'],
                                        'TotalDescuento'    => $request->encabezado['total_descuento'],
                                        'TotalSubtotal'     => $request->encabezado['subtotal'],
                                        'TotalIVA'          => $request->encabezado['total_iva'],
                                        'TotalPedido'       => $request->encabezado['total_pedido'],
                                        'Notas'             => $request->encabezado['notas_generales'],
                                        'Destino'           => 3,
                                        'created_at'        => Carbon::now(),
                                    ]);


                                foreach ($destino_troqueles as $item){
                                    DB::table('detalle_pedidos')
                                        ->insert([
                                            'idPedido'         => $id_pedido,
                                            'CodigoProducto'    =>  $item['cod'] ,
                                            'Cod_prod_cliente'  =>  $item['cod_prod_cliente'],
                                            'Descripcion'       =>  $item['producto'],
                                            'Arte'              =>  $item['arte'],
                                            'Marca'             =>  $item['marca'],
                                            'Notas'             =>  $item['notas'],
                                            'R_N'               =>  $item['n_r'],
                                            'Unidad'            =>  $item['unidad'],
                                            'Precio'            =>  $item['precio'],
                                            'Cantidad'          =>  $item['cantidad'],
                                            'Total'             =>  $item['total'],
                                            'Destino'           =>  3,
                                            'created_at'        => Carbon::now(),
                                        ]);
                                }

                                /* DB::table('pedidos_log')
                                     ->insert([
                                         'id_pedido'     =>  $id_pedido,
                                         'area'          =>  'VENTAS',
                                         'detalle'       =>  'creo un pedido para produccion',
                                         'usuario'       =>  Auth::user()->username,
                                         'created_at'    =>  Carbon::now(),
                                         'updated_at'    =>  Carbon::now()
                                     ]);*/

                                DB::table('pedidos_detalles_area')
                                    ->insert([
                                        'idPedido'     =>  $id_pedido,
                                        'created_at'   =>  Carbon::now(),
                                        'updated_at'   =>  Carbon::now(),
                                    ]);


                                if ($maestro->id_bodega !== null){
                                    $maestro_nuevo = DB::table('maestro_pedidos')
                                        ->insertGetId([
                                            'created_at'    =>  Carbon::now(),
                                            'updated_at'    =>  Carbon::now()
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $maestro_nuevo
                                        ]);
                                }else{
                                    DB::table('maestro_pedidos')
                                        ->where('id', '=', $encabezado['id_maestro'])
                                        ->update([
                                            'id_troqueles'  =>  $id_pedido
                                        ]);

                                    DB::table('encabezado_pedidos')
                                        ->where('id', '=', $id_pedido)
                                        ->update([
                                            'id_maestro'    => $encabezado['id_maestro']
                                        ]);

                                }
                            }
                        }
                    }
                }
                DB::commit();
                return response()->json('Pedido actualizado',200);


            }catch (Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Obtiene la informacion necesaria para dibujar el
     * modal del pdf del pedido
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function ver_pedido_pdf(Request $request){
        if ($request->ajax()){
            try {
                $pedido = EncabezadoPedido::with('info_area', 'detalle', 'cliente', 'vendedor')
                    ->find($request->id);

                return response()
                    ->json($pedido, 200);

            }catch (Exception $e){
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Informacion del estado del pedido por area
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function info_area(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('pedidos_detalles_area')
                    ->where('idPedido', '=', $request->id)
                    ->first();

                if ($request->area == 'cartera'){
                    if ($data->Cartera == 2){
                        return response()
                            ->json([
                                'icon'      => 'info',
                                'estado'    => 'Pendiente por gestion',
                                'detalle'   => ''
                            ], 200);

                    }else if ($data->Cartera == 3){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Rechazado',
                                'detalle'   => $data->DetalleCartera
                            ], 200);

                    }else if ($data->Cartera == 3.1){
                        return response()
                            ->json([
                                'icon'      => 'warning',
                                'estado'    => 'En estudio de cartera',
                                'detalle'   => $data->DetalleCartera
                            ], 200);

                    }else if ($data->Cartera == 3.2){
                        return response()
                            ->json([
                                'icon'      => 'warning',
                                'estado'    => 'Retenido por cartera',
                                'detalle'   => $data->DetalleCartera
                            ], 200);

                    }else if ($data->Cartera == 4){
                        return response()
                            ->json([
                                'icon'      => 'success',
                                'estado'    => 'Aprobado',
                                'detalle'   => '<b>APROBÓ: </b>'.$data->AproboCartera.'<br> <b>DETALLE:</b> '.$data->DetalleCartera
                            ], 200);

                    }else if ($data->Cartera == null){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Sin enviar',
                                'detalle'   => 'Este pedido no ha sido enviado a cartera'
                            ], 200);
                    }
                }
                else if ($request->area == 'costos'){
                    if ($data->Costos == 4){
                        return response()
                            ->json([
                                'icon'      => 'info',
                                'estado'    => 'Pendiente por gestion',
                                'detalle'   => ''
                            ], 200);

                    }else if ($data->Costos == 5){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Rechazado',
                                'detalle'   => $data->DetalleCostos
                            ], 200);

                    }else if ($data->Costos == 6){
                        return response()
                            ->json([
                                'icon'      => 'success',
                                'estado'    => 'Aprobado',
                                'detalle'   => '<b>APROBÓ: </b>'.$data->AproboCostos.'<br> <b>DETALLE:</b> '.$data->DetalleCostos
                            ], 200);

                    }else if ($data->Costos == null){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Sin enviar',
                                'detalle'   => 'Este pedido no ha sido enviado a costos'
                            ], 200);
                    }
                }
                else if ($request->area == 'produccion'){
                    if ($data->Produccion == 6){
                        return response()
                            ->json([
                                'icon'      => 'info',
                                'estado'    => 'Pendiente por gestion',
                                'detalle'   => ''
                            ], 200);

                    }else if ($data->Produccion == 7){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Rechazado',
                                'detalle'   => $data->DetalleProduccion
                            ], 200);

                    }else if ($data->Produccion == 7){
                        return response()
                            ->json([
                                'icon'      => 'success',
                                'estado'    => 'Aprobado',
                                'detalle'   => '<b>APROBÓ: </b>'.$data->AproboProduccion.'<br> <b>DETALLE:</b> '.$data->DetalleProduccion
                            ], 200);

                    }else if ($data->Produccion == 8){
                        return response()
                            ->json([
                                'icon'      => 'success',
                                'estado'    => 'Aprobado',
                                'detalle'   => $data->DetalleProduccion
                            ], 200);

                    }
                    else if ($data->Produccion == null){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Sin enviar',
                                'detalle'   => 'Este pedido no ha sido enviado a produccion'
                            ], 200);
                    }
                }
                else if ($request->area == 'bodega'){
                    if ($data->Bodega == 8){
                        return response()
                            ->json([
                                'icon'      => 'info',
                                'estado'    => 'Pendiente por gestion',
                                'detalle'   => ''
                            ], 200);

                    }else if ($data->Bodega == 9){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Rechazado',
                                'detalle'   => $data->DetalleBodega
                            ], 200);

                    }else if ($data->Bodega == 10){
                        return response()
                            ->json([
                                'icon'      => 'success',
                                'estado'    => 'Aprobado',
                                'detalle'   => '<b>APROBÓ: </b>'.$data->AproboBodega.'<br> <b>DETALLE:</b> '.$data->DetalleBodega
                            ], 200);

                    }else if ($data->Bodega == null){
                        return response()
                            ->json([
                                'icon'      => 'error',
                                'estado'    => 'Sin enviar',
                                'detalle'   => 'Este pedido no ha sido enviado a bodega'
                            ], 200);
                    }
                }


            }catch (Exception $e){
                return response()
                    ->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Formulario de creacion de pedidos
     *
     * @return RedirectResponse
     */
    public function create(){
        try {
            $vendedores =  DB::table('users')
                ->where('app_roll','=','vendedor')
                ->orderBy('name','asc')
                ->get();

            $condicion_pago =  DB::connection('MAX')
                ->table('Code_Master')
                ->where('CDEKEY_36','=','TERM')
                ->orderBy('DESC_36','asc')
                ->get();

            return view('aplicaciones.pedidos.ventas.create', compact('vendedores', 'condicion_pago'));

        }catch (Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }



    /**
     * Obtiene la informacion de un cliente
     * para la creacion de pedidos
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function info_cliente(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::connection('MAX')->table('CIEV_V_Clientes')
                    ->where('CIEV_V_Clientes.RAZON_SOCIAL', 'LIKE', '%'.$query.'%')
                    ->orWhere('CIEV_V_Clientes.CODIGO_CLIENTE', 'LIKE', '%'.$query.'%')->take(20)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value'         => trim($q->RAZON_SOCIAL),
                        'cod'           => trim($q->CODIGO_CLIENTE),
                        'direccion'     => trim($q->DIRECCION),
                        'ciudad'        => trim($q->CIUDAD),
                        'telefono'      => trim($q->TEL1),
                        'plazo'         => trim($q->PLAZO),
                        'retenido'      => trim($q->ACTIVO),
                        'descuento'     => number_format($q->DESCUENTO,0,'','')
                    ];
                }
                return response()->json($results, 200);

            }catch (Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    /**
     * Guarda un pedido nuevo
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(Request $request){
        if ($request->ajax()){
            try {
                $produccion = [];
                $bodega = [];
                $troqueles = [];


                if ($request->items){
                    foreach($request->items as $item){
                        if ($item['destino'] == 'Produccion'){
                            array_push($produccion, $item);
                        }else if ($item['destino'] == 'Bodega'){
                            array_push($bodega, $item);
                        }else{
                            array_push($troqueles, $item);
                        }
                    }
                    DB::beginTransaction();

                    $maestro = DB::table('maestro_pedidos')
                        ->insertGetId([
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);


                    if ($produccion){
                        $id_pedido = DB::table('encabezado_pedidos')
                            ->insertGetId([
                                'OrdenCompra'       => $request->encabezado['oc'],
                                'CodCliente'        => $request->encabezado['cod_cliente'],
                                'vendedor_id'       => $request->encabezado['vendedor'],
                                'Descuento'         => $request->encabezado['descuento'],
                                'Iva'               => $request->encabezado['tiene_iva'],
                                'Estado'            => 1,
                                'Bruto'             => $request->encabezado['total_bruto'],
                                'TotalDescuento'    => $request->encabezado['total_descuento'],
                                'TotalSubtotal'     => $request->encabezado['subtotal'],
                                'TotalIVA'          => $request->encabezado['total_iva'],
                                'TotalPedido'       => $request->encabezado['total_pedido'],
                                'Notas'             => $request->encabezado['notas_generales'],
                                'Destino'           => 1,
                                'created_at'        => Carbon::now(),
                                'id_maestro'        => $maestro
                            ]);

                        DB::table('maestro_pedidos')
                            ->where('id', '=', $maestro)
                            ->update([
                                'id_produccion' => $id_pedido
                            ]);

                        foreach ($produccion as $item){
                            DB::table('detalle_pedidos')
                                ->insert([
                                    'idPedido'         => $id_pedido,
                                    'CodigoProducto'   => $item['cod'],
                                    'Cod_prod_cliente' => $item['cod_prod_cliente'],
                                    'Descripcion'      => $item['producto'],
                                    'Arte'             => $item['arte'],
                                    'Marca'            => $item['marca'],
                                    'Notas'            => $item['notas'],
                                    'Unidad'           => $item['unidad'],
                                    'Cantidad'         => $item['cantidad'],
                                    'Precio'           => $item['precio'],
                                    'Total'            => $item['total'],
                                    'Destino'          => 1,
                                    'R_N'              => $item['n_r'],
                                    'created_at'       => Carbon::now(),
                                ]);
                        }

                        DB::table('pedidos_log')
                            ->insert([
                                'id_pedido'     =>  $id_pedido,
                                'area'          =>  'VENTAS',
                                'detalle'       =>  'creo un pedido para produccion',
                                'usuario'       =>  auth()->user()->id,
                                'created_at'    =>  Carbon::now(),
                                'updated_at'    =>  Carbon::now()
                            ]);

                        DB::table('pedidos_detalles_area')
                            ->insert([
                                'idPedido'     =>  $id_pedido,
                                'created_at'   =>  Carbon::now(),
                                'updated_at'   =>  Carbon::now(),
                            ]);

                    }
                    if($bodega){
                        $id_pedido = DB::table('encabezado_pedidos')
                            ->insertGetId([
                                'OrdenCompra'       => $request->encabezado['oc'],
                                'CodCliente'        => $request->encabezado['cod_cliente'],
                                'vendedor_id'       => $request->encabezado['vendedor'],
                                'Descuento'         => $request->encabezado['descuento'],
                                'Iva'               => $request->encabezado['tiene_iva'],
                                'Estado'            => 1,
                                'Bruto'             => $request->encabezado['total_bruto'],
                                'TotalDescuento'    => $request->encabezado['total_descuento'],
                                'TotalSubtotal'     => $request->encabezado['subtotal'],
                                'TotalIVA'          => $request->encabezado['total_iva'],
                                'TotalPedido'       => $request->encabezado['total_pedido'],
                                'Notas'             => $request->encabezado['notas_generales'],
                                'Destino'           => 2,
                                'created_at'        => Carbon::now(),
                                'id_maestro'        => $maestro
                            ]);

                        DB::table('maestro_pedidos')
                            ->where('id', '=', $maestro)
                            ->update([
                                'id_bodega' => $id_pedido
                            ]);

                        foreach ($bodega as $item){
                            DB::table('detalle_pedidos')
                                ->insert([
                                    'idPedido'         => $id_pedido,
                                    'CodigoProducto'   => $item['cod'],
                                    'Cod_prod_cliente' => $item['cod_prod_cliente'],
                                    'Descripcion'      => $item['producto'],
                                    'Arte'             => $item['arte'],
                                    'Marca'            => $item['marca'],
                                    'Notas'            => $item['notas'],
                                    'Unidad'           => $item['unidad'],
                                    'Cantidad'         => $item['cantidad'],
                                    'Precio'           => $item['precio'],
                                    'Total'            => $item['total'],
                                    'Destino'          => 2,
                                    'R_N'              => $item['n_r'],
                                    'created_at'       => Carbon::now(),
                                ]);
                        }

                        DB::table('pedidos_log')
                            ->insert([
                                'id_pedido'     =>  $id_pedido,
                                'area'          =>  'VENTAS',
                                'detalle'       =>  'creo un pedido para bodega',
                                'usuario'       =>  auth()->user()->id,
                                'created_at'    =>  Carbon::now(),
                                'updated_at'    =>  Carbon::now()
                            ]);

                        DB::table('pedidos_detalles_area')
                            ->insert([
                                'idPedido'     =>  $id_pedido,
                                'created_at'   =>  Carbon::now(),
                                'updated_at'   =>  Carbon::now(),
                            ]);

                    }

                    if ($troqueles){
                        $id_pedido = DB::table('encabezado_pedidos')
                            ->insertGetId([
                                'OrdenCompra'       => $request->encabezado['oc'],
                                'CodCliente'        => $request->encabezado['cod_cliente'],
                                'vendedor_id'       => $request->encabezado['vendedor'],
                                'Descuento'         => $request->encabezado['descuento'],
                                'Iva'               => $request->encabezado['tiene_iva'],
                                'Estado'            => 1,
                                'Bruto'             => $request->encabezado['total_bruto'],
                                'TotalDescuento'    => $request->encabezado['total_descuento'],
                                'TotalSubtotal'     => $request->encabezado['subtotal'],
                                'TotalIVA'          => $request->encabezado['total_iva'],
                                'TotalPedido'       => $request->encabezado['total_pedido'],
                                'Notas'             => $request->encabezado['notas_generales'],
                                'Destino'           => 3,
                                'created_at'        => Carbon::now(),
                                'id_maestro'        => $maestro
                            ]);

                        DB::table('maestro_pedidos')
                            ->where('id', '=', $maestro)
                            ->update([
                                'id_troqueles' => $id_pedido
                            ]);

                        foreach ($troqueles as $item){
                            DB::table('detalle_pedidos')
                                ->insert([
                                    'idPedido'         => $id_pedido,
                                    'CodigoProducto'   => $item['cod'],
                                    'Cod_prod_cliente' => $item['cod_prod_cliente'],
                                    'Descripcion'      => $item['producto'],
                                    'Arte'             => $item['arte'],
                                    'Marca'            => $item['marca'],
                                    'Notas'            => $item['notas'],
                                    'Unidad'           => $item['unidad'],
                                    'Cantidad'         => $item['cantidad'],
                                    'Precio'           => $item['precio'],
                                    'Total'            => $item['total'],
                                    'Destino'          => 3,
                                    'R_N'              => $item['n_r'],
                                    'created_at'       => Carbon::now(),
                                ]);
                        }
                        DB::table('pedidos_log')
                            ->insert([
                                'id_pedido'     =>  $id_pedido,
                                'area'          =>  'VENTAS',
                                'detalle'       =>  'creo un pedido para troqueles',
                                'usuario'       =>  auth()->user()->id,
                                'created_at'    =>  Carbon::now(),
                                'updated_at'    =>  Carbon::now()
                            ]);



                        DB::table('pedidos_detalles_area')
                            ->insert([
                                'idPedido'     =>  $id_pedido,
                                'created_at'   =>  Carbon::now(),
                                'updated_at'   =>  Carbon::now(),
                            ]);

                    }
                    DB::commit();
                    return response()->json('Pedido guardado con exito', 200);
                }else{
                    return response()->json('Debes agregar al menos un item al pedido', 500);
                }
            }catch (Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }




    /**
     * Permite clonar un pedido ya existente
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function clonar_pedido(Request $request){
        if ($request->ajax()) {
            DB::beginTransaction();
            try{
                $id_origen = $request->get('id');

                $encabezado_origen = DB::table('encabezado_pedidos')
                    ->where('id', '=', $id_origen)
                    ->first();


                $detalle_origen =  DB::table('detalle_pedidos')
                    ->where('idPedido', '=', $id_origen)
                    ->get();


                $maestro = DB::table('maestro_pedidos')
                    ->insertGetId([
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                    ]);


                $encabezado_destino = DB::table('encabezado_pedidos')
                    ->insertGetId([
                        'OrdenCompra'       =>  $encabezado_origen->OrdenCompra,
                        'CodCliente'        =>  $encabezado_origen->CodCliente,
                        'vendedor_id'       =>  $request->encabezado['vendedor'],
                        'Descuento'         =>  $encabezado_origen->Descuento,
                        'Iva'               =>  $encabezado_origen->Iva,
                        'Estado'            =>  '1',
                        'Bruto'             =>  $encabezado_origen->Bruto,
                        'TotalDescuento'    =>  $encabezado_origen->TotalDescuento,
                        'TotalSubtotal'     =>  $encabezado_origen->TotalSubtotal,
                        'TotalIVA'          =>  $encabezado_origen->TotalIVA,
                        'TotalPedido'       =>  $encabezado_origen->TotalPedido,
                        'Notas'             =>  $encabezado_origen->Notas,
                        'Destino'           =>  $encabezado_origen->Destino,
                        'created_at'        =>  Carbon::now(),
                        'updated_at'        =>  Carbon::now(),
                        'id_maestro'        =>  $maestro
                    ]);


                DB::table('pedidos_detalles_area')
                    ->insert([
                        'idPedido'     =>  $encabezado_destino,
                        'created_at'   =>  Carbon::now(),
                        'updated_at'   =>  Carbon::now(),
                    ]);

                foreach ($detalle_origen as $item){
                    DB::table('detalle_pedidos')
                        ->insert([
                            'idPedido'         =>  $encabezado_destino,
                            'CodigoProducto'   => $item['cod'],
                            'Cod_prod_cliente' => $item['cod_prod_cliente'],
                            'Descripcion'      => $item['producto'],
                            'Arte'             => $item['arte'],
                            'Marca'            => $item['marca'],
                            'Notas'            => $item['notas'],
                            'Unidad'           => $item['unidad'],
                            'Cantidad'         => $item['cantidad'],
                            'Precio'           => $item['precio'],
                            'Total'            => $item['total'],
                            'Destino'          => 3,
                            'R_N'              => $item['n_r'],
                            'created_at'       => Carbon::now(),
                            'updated_at'       =>  Carbon::now()
                        ]);
                }
                DB::commit();
                return response()->json($encabezado_destino, 200);

            }catch (Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
