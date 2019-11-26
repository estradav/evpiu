<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PedidoCostosController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            if (!empty($request->CodVenUsuario != 999)) {
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
                        'pedidos_detalles_area.Costos as SubEstado')
                    ->where('Estado', '=', '4')->orWhere('Estado', '=', '5')
                    ->get();
            } else {
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
                        'pedidos_detalles_area.Costos as SubEstado')
                    ->where('Estado', '=', '4')->orWhere('Estado', '=', '5')
                    ->get();
            }

            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<button class="btn btn-light btn-sm Option" name="Option" id="'.$row->id.'"><i class="fas fa-cogs"></i></button>';
                    $btn = $btn.'<button class="btn btn-light btn-sm Viewpdf" name="Viewpdf" id="'.$row->id.'"><i class="far fa-file-pdf"></i></button>'.'</div>';
                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('Pedidos.Costos');
    }

    public function PedidoCostosUpdate(Request $request)
    {
        if ($request->ajax()) {
            if ($request->EstadoPedido == 5) {
                DB::beginTransaction();
                try {
                    DB::table('encabezado_pedidos')->where('id', '=', $request->id)->update([
                        'Estado' => $request->EstadoPedido
                    ]);

                    DB::table('pedidos_detalles_area')->where('idPedido', '=', $request->id)->update([
                        'Costos' => $request->EstadoPedido,
                        'DetalleCostos' => $request->DescripccionPedido,
                    ]);
                    DB::commit();
                    return response()->json(['Success' => 'Todo Ok']);
                }
                catch (\Exception $e){
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

            if ($request->EstadoPedido == 6){
                DB::beginTransaction();
                try {
                    DB::table('encabezado_pedidos')->where('id', '=', $request->id)->update([
                        'Estado' => $request->EstadoPedido
                    ]);

                    DB::table('pedidos_detalles_area')->where('idPedido', '=', $request->id)->update([
                        'Costos' => $request->EstadoPedido,
                        'DetalleCostos' => $request->DescripccionPedido,
                        'AproboCostos' => $request->User,
                        'Produccion' => $request->EstadoPedido,
                    ]);
                    DB::commit();
                    return response()->json(['Success' => 'Todo Ok']);
                }
                catch (\Exception $e){
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
    }
}
