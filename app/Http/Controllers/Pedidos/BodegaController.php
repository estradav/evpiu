<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BodegaController extends Controller
{
    /**
     * lista de pedidos pendientes por gestion
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public function index(Request $request){
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
                    'pedidos_detalles_area.Bodega as SubEstado')
                ->where('Estado', '=', '8')->orWhere('Estado', '=', '9')
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
        return view('aplicaciones.pedidos.bodega.index');
    }



    /**
     * Cambia el estado del pedido dependiendo de la opcion
     * seleccionada en el modal 'opciones'
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function actualizar_pedido(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('encabezado_pedidos')
                    ->where('id', '=', $request->id)
                    ->update([
                        'Estado' => $request->estado
                ]);

                DB::table('pedidos_detalles_area')
                    ->where('idPedido', '=', $request->id)
                    ->update([
                        'Bodega' => $request->estado,
                        'DetalleBodega' => $request->descripcion,
                ]);
                DB::commit();
                return response()->json('Pedido actualizado', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
