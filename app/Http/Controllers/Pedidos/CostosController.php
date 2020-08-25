<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CostosController extends Controller
{
    /**
     * lista de pedidos pendientes por gestion
     *
     * @param Request $request
     * @return Factory|View
     * @throws Exception
     */
    public  function index(Request $request){
        if ($request->ajax()){
            try {
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
                    ->where('Estado', '=', '4')
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

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
        return view('aplicaciones.pedidos.costos.index');
    }



    /**
     * Cambia el estado del pedido dependiendo de la opcion
     * seleccionada en el modal 'opciones'
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function actualizar_estado(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                if ($request->estado == 5) {
                    DB::table('encabezado_pedidos')
                        ->where('id', '=', $request->id)
                        ->update([
                            'Estado' => $request->estado
                        ]);

                    DB::table('pedidos_detalles_area')
                        ->where('idPedido', '=', $request->id)
                        ->update([
                            'Costos'        => $request->estado,
                            'DetalleCostos' => $request->descripcion,
                        ]);

                }else if ($request->estado == 6){
                    $destino = DB::table('encabezado_pedidos')
                        ->where('id','=',$request->id)
                        ->select('Destino')
                        ->first();

                    if ($destino->Destino == 1){
                        DB::table('encabezado_pedidos')
                            ->where('id', '=', $request->id)
                            ->update([
                                'Estado' => $request->estado
                            ]);

                        DB::table('pedidos_detalles_area')
                            ->where('idPedido', '=', $request->id)
                            ->update([
                                'Costos'        => $request->estado,
                                'DetalleCostos' => $request->descripcion,
                                'AproboCostos'  => Auth::user()->username,
                                'Produccion'    => $request->estado,
                        ]);
                    }elseif ($destino->Destino == 2){
                        DB::table('encabezado_pedidos')
                            ->where('id', '=', $request->id)
                            ->update([
                                'Estado' => '8'
                            ]);

                        DB::table('pedidos_detalles_area')
                            ->where('idPedido', '=', $request->id)
                            ->update([
                                'Costos'            => '6',
                                'DetalleCostos'     => $request->descripcion,
                                'AproboCostos'      => Auth::user()->username,
                                'Produccion'        => '8',
                                'DetalleProduccion' => 'Este pedido es de bodega',
                                'AproboProduccion'  => Auth::user()->username,
                                'Bodega'            => '8'
                            ]);
                    }elseif ($destino->Destino == 3){

                        /*este destino no funciona correctamente*/
                        DB::table('encabezado_pedidos')
                            ->where('id', '=', $request->id)
                            ->update([
                                'Estado' => '8'
                            ]);

                        DB::table('pedidos_detalles_area')
                            ->where('idPedido', '=', $request->id)
                            ->update([
                                'Costos'            => '6',
                                'DetalleCostos'     => $request->descripcion,
                                'AproboCostos'      => Auth::user()->username,
                                'Produccion'        => '8',
                                'DetalleProduccion' => 'Pedido de troqueles',
                                'AproboProduccion'  => Auth::user()->username,
                                'Bodega'            => '8'
                            ]);
                    }
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
