<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodTipoProducto;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TipoProductoController extends Controller
{
    /**
     * Lista tipos de producto
     *
     * @return Response
     */
    public function index(){
        $data = CodTipoProducto::latest()->get();

        return response()->view('aplicaciones.productos.maestros.tipo_producto.index',
            compact('data'));
    }


    /**
     * Elimina un registro via ajax
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {
            CodTipoProducto::find($id)->delete();
            return response()->json('Registro eliminado',200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Devuelve los datos para la edicion
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){
        try {
            $data = CodTipoProducto::find($id);
            return response()->json($data);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Agrega o edita un registro
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request){
        if ($request->ajax()){
            try {
                CodTipoProducto::updateOrCreate(
                    ['id' => $request->id], [
                        'usuario'       => Auth::user()->username,
                        'cod'           => $request->cod ?? $request->code,
                        'name'          => $request->name,
                        'coments'       => $request->comments,
                    ]);
                return response()->json('registro guardado', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * En la creacion de tipo de producto valida si el codigo
     * del registro ya existe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validar_codigo (Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_tipo_productos')
                    ->where('cod','=', $request->cod)
                    ->count();
                if($data == 0) {
                    return response()->json(true,200);
                }else {
                    return response()->json(false,200);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }
}
