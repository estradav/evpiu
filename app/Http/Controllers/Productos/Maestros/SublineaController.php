<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodLinea;
use App\CodSublinea;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Mockery\Exception;

class SublineaController extends Controller
{
    /**
     * Lista tipos de producto
     *
     * @return Factory|View
     */
    public function index(){
        $data = DB::table('cod_sublineas')
            ->leftJoin('cod_lineas','cod_sublineas.lineas_id','=','cod_lineas.id')
            ->select('cod_sublineas.cod as cod',
                'cod_sublineas.name as name',
                'cod_sublineas.abreviatura as abrev',
                'cod_sublineas.coments as coment',
                'cod_lineas.name as linea',
                'cod_lineas.cod as cod_linea',
                'cod_sublineas.id as id')
            ->get();

        $lineas = CodLinea::orderBy('name','asc')->get();
        $unidades_medida = DB::table('unidades_medidas')->get();
        $carac_unidades_medida = DB::table('caracteristicas_unidades_medidas')->get();

        return view('aplicaciones.productos.maestros.sublinea.index',
            compact('data', 'lineas', 'unidades_medida', 'carac_unidades_medida'));
    }


    /**
     * Elimina un registro via ajax
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {
            CodSublinea::find($id)->delete();
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

            $codsublinea = CodSublinea::find($id);
            $UnidadesMedidaArray = [];

            foreach ($codsublinea->UnidadesMedida as $UnidadesMedid) {
                $UnidadesMedidaArray[$UnidadesMedid->id] = $UnidadesMedid->descripcion;
            }

            foreach ($codsublinea->CaracteristicasUnidadesMedida as $CarUnidadesMedida) {
                $CarUnidadesMedidaArray[$CarUnidadesMedida->id] = $CarUnidadesMedida->descripcion;
            }

            return response()->json([
                'sublinea' => $codsublinea,
                'medida' => $UnidadesMedidaArray,
                'carmedida' => $CarUnidadesMedidaArray], 200);

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
            if ($request->encabezado['id'] == null) {
                DB::beginTransaction();
                try {
                    $sb = DB::table('cod_sublineas')
                        ->insertGetId([
                            'cod'           => $request->encabezado['codigo'],
                            'name'          => $request->encabezado['name'],
                            'hijo'          => $request->encabezado['hijo'],
                            'lineas_id'     => $request->encabezado['linea'],
                            'abreviatura'   => $request->encabezado['abre'],
                            'coments'       => $request->encabezado['coments'],
                            'usuario'       => Auth::user()->username,

                        ]);

                    $umedidas = $request->umedidas;
                    foreach ($umedidas as $d) {
                        DB::table('medidas_to_sublineas')
                            ->insert([
                                'sub_id' => $sb,
                                'med_id' => $d,
                        ]);
                    }

                    $carmedidas = $request->carmedidas;
                    foreach ($carmedidas as $d) {
                        DB::table('caracteristicasmedidas_to_sublineas')
                            ->insert([
                                'sub_id'        => $sb,
                                'car_med_id'    => $d,
                        ]);
                    }
                    DB::commit();
                    return response()->json('registro guardado', 200);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json($e->getMessage(), 500);
                }
            } else {
                DB::beginTransaction();
                try {
                    DB::table('cod_sublineas')
                        ->where('id', $request->encabezado['id'])
                        ->update([
                            'cod'               => $request->encabezado['codigo'],
                            'name'              => $request->encabezado['name'],
                            'hijo'              => $request->encabezado['hijo'],
                            'lineas_id'         => $request->encabezado['linea'],
                            'abreviatura'       => $request->encabezado['abre'],
                            'coments'           => $request->encabezado['coments'],

                        ]);

                    DB::table('medidas_to_sublineas')
                        ->where('sub_id','=',$request->encabezado['id'])
                        ->delete();

                    DB::table('caracteristicasmedidas_to_sublineas')
                        ->where('sub_id','=',$request->encabezado['id'])
                        ->delete();

                    $umedidas = $request->umedidas;
                    foreach ($umedidas as $d) {
                        DB::table('medidas_to_sublineas')->insert([
                            'sub_id' => $request->encabezado['id'],
                            'med_id' => $d,
                        ]);
                    }

                    $carmedidas = $request->carmedidas;
                    foreach ($carmedidas as $d) {
                        DB::table('caracteristicasmedidas_to_sublineas')->insert([
                            'sub_id'        => $request->encabezado['id'],
                            'car_med_id'    => $d,
                        ]);
                    }
                    DB::commit();
                    return response()->json('Registro guardado', 200);
                } catch (\Exception $e){
                    DB::rollback();
                    return response()->json($e->getMessage(), 500);
                }
            }
        }
    }



    /**
     * En la creacion de sublinea valida si el codigo
     * del registro ya existe
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validar_codigo (Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_sublineas')
                    ->where('lineas_id','=',$request->linea)
                    ->where('cod','=',$request->cod)
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



    /**
     * Lista de unidades de medida filtrada por sublinea
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unidades_medida(Request $request){
        if ($request->ajax()){
            try {
                $sub = CodSublinea::find($request->id);
                $UnidadesMedidaArray = [];

                foreach ($sub->UnidadesMedida as $UnidadesMedid) {
                    $UnidadesMedidaArray[] = $UnidadesMedid->descripcion;
                }
                return response()->json($UnidadesMedidaArray, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }



    /**
     * Lista de caracteristicas unidades de medida filtrada por sublinea
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function caracteristicas_unidades_medida(Request $request){
        if ($request->ajax()){
            try {
                $sub = CodSublinea::find($request->id);
                $CarUnidadesMedidaArray = [];

                foreach ($sub->CaracteristicasUnidadesMedida as $CarUnidadesMedida) {
                    $CarUnidadesMedidaArray[] = $CarUnidadesMedida->descripcion;
                }
                return response()->json($CarUnidadesMedidaArray, 200);
            }catch (Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }

}
