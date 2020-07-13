<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodCaracteristica;
use App\CodLinea;
use App\CodSublinea;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CaracteristicaController extends Controller
{
    /**
     * Lista tipos de producto
     *
     * @return Factory|View
     */
    public function index(){
        $data = DB::table('cod_caracteristicas')
            ->leftJoin('cod_lineas','cod_caracteristicas.car_lineas_id','=','cod_lineas.id')
            ->leftJoin('cod_sublineas','cod_caracteristicas.car_sublineas_id','=','cod_sublineas.id')
            ->select('cod_caracteristicas.cod as cod','cod_caracteristicas.name as name','cod_caracteristicas.abreviatura as abrev','cod_caracteristicas.updated_at as updated',
                'cod_caracteristicas.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_caracteristicas.id as id')
            ->get();

        $lineas = CodLinea::all();

        return view('aplicaciones.productos.maestros.caracteristica.index', compact('data', 'lineas'));
    }


    /**
     * Elimina un registro via ajax
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {
            CodCaracteristica::find($id)->delete();
            return response()->json('registro eliminado', 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * Devuelve los datos para la edicion
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id){
        try{
            $data = CodCaracteristica::find($id);
            return response()->json($data, 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * Lista de sublineas por id de linea
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listar_sublineas(Request $request){
        if ($request->ajax()){
            try {
                $data = CodSublinea::where('lineas_id', $request->linea_id)
                    ->orderby('name', 'asc')
                    ->get();
                return response()->json($data, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * valida si el codigo
     * del registro ya existe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validar_codigo(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_caracteristicas')
                    ->where('car_lineas_id','=',$request->linea)
                    ->where('car_sublineas_id','=',$request->sublinea)
                    ->where('cod','=',$request->cod)
                    ->count();
                if ($data == 0){
                    return response()->json(true, 200);
                }else{
                    return response()->json(false, 200);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
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
                CodCaracteristica::updateOrCreate(['id' => $request->id],
                    [   'cod'               => $request->cod ?? $request->code,
                        'name'              => $request->name,
                        'car_lineas_id'     => $request->linea,
                        'car_sublineas_id'  => $request->sublinea,
                        'abreviatura'       => $request->abrev,
                        'coments'           => $request->coments,
                    ]);
                return response()->json('registro guardado', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
