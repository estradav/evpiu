<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\Factory;
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
     * @return Factory|View
     * @throws Exception
     */
    public function actualizar_estado(Request $request){
        if ($request->ajax()){
            try {
                DB::beginTransaction();
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
                }
                DB::commit();

                return response()->json('Pedido actualizado', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }

}
