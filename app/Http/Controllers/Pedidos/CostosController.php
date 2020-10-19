<?php

namespace App\Http\Controllers\Pedidos;

use App\EncabezadoPedido;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
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
                $data = EncabezadoPedido::with('cliente' ,'info_area' , 'vendedor')
                    ->where('Estado', '4')
                    ->get();

                return Datatables::of($data)
                    ->editColumn('created_at', function ($row){
                        Carbon::setLocale('es');
                        return  $row->created_at->format('d M Y h:i a');
                    })
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
                    $pedido = EncabezadoPedido::find($request->id);


                    $pedido->Estado = $request->estado;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Costos'        => $request->estado,
                        'DetalleCostos' => $request->descripcion,
                    ]);


                }else if ($request->estado == 6){
                    $pedido = EncabezadoPedido::find($request->id);

                    if ($pedido->Destino == 1){

                        $pedido->Estado = $request->estado;
                        $pedido->save();

                        $pedido->info_area()->update([
                            'Costos'            => $request->estado,
                            'DetalleCostos'     => $request->descripcion,
                            'costos_fecha_resp' => Carbon::now(),
                            'aprobo_costos'     => auth()->user()->id,
                            'Produccion'        => $request->estado,
                        ]);


                    }elseif ($pedido->Destino == 2){

                        $pedido->Estado = 8;
                        $pedido->save();

                        $pedido->info_area()->update([
                            'Costos'            => 6,
                            'DetalleCostos'     => $request->descripcion,
                            'aprobo_costos'     => auth()->user()->id,

                            'Produccion'        => 8,
                            'DetalleProduccion' => 'Este pedido es de bodega',
                            'aprobo_produccion' => null,
                            'Bodega'            => 8
                        ]);

                    }elseif ($pedido->Destino == 3){
                        /*este destino no funciona correctamente*/

                        $pedido->Estado = 11;
                        $pedido->save();

                        $pedido->info_area()->update([
                            'Costos'                => 6,
                            'DetalleCostos'         => $request->descripcion,
                            'aprobo_costos'         => auth()->user()->id,
                            'costos_fecha_resp'     => Carbon::now(),

                            'Produccion'            => 8,
                            'DetalleProduccion'     => 'Pedido de troqueles',
                            'produccion_fecha_resp' => Carbon::now(),


                            'Bodega'                => 8,
                            'DetalleBodega'         => 'Pedido de troqueles',
                            'bodega_fecha_resp'     => Carbon::now(),


                            'Troqueles'             => 11
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
