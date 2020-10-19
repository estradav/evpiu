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

class CarteraController extends Controller
{
    /**
     * lista de pedidos pendientes por gestion
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request){
        if ($request->ajax()){
            try {

                $data = EncabezadoPedido::with('cliente' ,'info_area', 'vendedor')
                    ->where('Estado', '2')
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
        return view('aplicaciones.pedidos.cartera.index');
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
            try {
                $pedido =  EncabezadoPedido::find($request->id);

                if ($request->estado == 3){
                    $pedido->Estado = $request->estado;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Cartera'           =>  $request->estado,
                        'DetalleCartera'    =>  $request->descripcion,
                    ]);

                }else if($request->estado == 4){
                    $pedido->Estado = $request->estado;
                    $pedido->save();

                    $pedido->info_area()->update([
                        'Cartera'               => $request->estado,
                        'DetalleCartera'        => $request->descripcion,
                        'aprobo_cartera'        => auth()->user()->id,
                        'cartera_fecha_resp'    => Carbon::now(),
                        'Costos'                => $request->estado,
                    ]);

                }else if($request->estado == 3.1 || $request->estado == 3.2){
                    $pedido->info_area()->update([
                        'Cartera'           => $request->estado,
                        'DetalleCartera'    => $request->descripcion,
                    ]);
                }
                return response()->json('Pedido actualizado', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}

