<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodLinea;
use App\CodTipoProducto;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LineaController extends Controller
{
    /**
     * Lista tipos de producto
     *
     * @return Factory|View
     */
    public function index(){
        $data = DB::table('cod_lineas')
            ->leftJoin('cod_tipo_productos','cod_lineas.tipoproducto_id','=','cod_tipo_productos.id')
            ->select('cod_lineas.cod as cod','cod_lineas.name as name','cod_lineas.abreviatura as abrev','cod_lineas.coments as coment',
                'cod_tipo_productos.name as tp','cod_lineas.id as id','cod_lineas.usuario as user','cod_lineas.created_at as created','cod_lineas.updated_at as update')
            ->get();

        $tipo_productos = CodTipoProducto::orderBy('name', 'asc')->get();

        return view('aplicaciones.productos.maestros.linea.index', compact('data','tipo_productos'));
    }


    /**
     * Elimina un registro via ajax
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {
            CodLinea::find($id)->delete();
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
            $data = CodLinea::find($id);
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
                CodLinea::updateOrCreate(
                    ['id' => $request->id], [
                        'cod'               => $request->cod ?? $request->code,
                        'tipoproducto_id'   => $request->tipo_producto,
                        'name'              => $request->name,
                        'abreviatura'       => $request->abrev,
                        'coments'           => $request->comments,
                ]);
                return response()->json('registro guardado', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }



    /**
     * En la creacion de linea valida si el codigo
     * del registro ya existe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validar_codigo (Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_lineas')
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
