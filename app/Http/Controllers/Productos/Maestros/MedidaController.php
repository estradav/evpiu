<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodLinea;
use App\CodMedida;
use App\CodSublinea;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MedidaController extends Controller
{
    /**
     * Lista de medidas
     *
     * @return Factory|View
     */
    public function index(){
        $data = DB::table('cod_medidas')
            ->leftJoin('cod_lineas','cod_medidas.med_lineas_id','=','cod_lineas.id')
            ->leftJoin('cod_sublineas','cod_medidas.med_sublineas_id','=','cod_sublineas.id')
            ->select('cod_medidas.cod as cod','cod_medidas.denominacion as denm','cod_medidas.updated_at as upt',
                'cod_medidas.diametro as diametro','cod_medidas.pestana as pestana','cod_medidas.espesor as espesor',
                'cod_medidas.base as base','cod_medidas.mm2 as mm2','cod_medidas.perforacion as perforacion','cod_medidas.altura as altura',
                'cod_medidas.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_medidas.id as id')
            ->get();

        $lineas = CodLinea::orderBy('name','asc')->get();

        return view('aplicaciones.productos.maestros.medida.index', compact('data', 'lineas'));
    }


    /**
     * lista de caracteristicas y de unidades de medida
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listar_cara_y_unidad_medida(Request $request){
        if ($request->ajax()){
            try {
                $unidades_medida = CodSublinea::find($request->sublineas_id);
                $und_medida = $unidades_medida->UnidadesMedida;
                $carac_unidades_medida = $unidades_medida->CaracteristicasUnidadesMedida;
                return response()->json(['unidades_medida' => $und_medida, 'carac_unidades_medida' => $carac_unidades_medida], 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * devuelve el ultimo codigo generado y una lista de codigos
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function info_calculo_cod(Request $request){
        if ($request->ajax()){
            try {
                $codigos = DB::table('cod_medidas')
                    ->where('med_lineas_id','=', $request->linea)
                    ->where('med_sublineas_id','=', $request->sublinea)
                    ->pluck('cod')
                    ->toArray();

                $ultimo_cod = DB::table('cod_medidas')
                    ->where('id', DB::raw("(select max(`id`) from cod_medidas where med_lineas_id = $request->linea and med_sublineas_id = $request->sublinea )"))
                    ->pluck('cod')
                    ->toArray();

                return response()->json(['codigos' => $codigos, 'ultimo' => $ultimo_cod], 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
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
            $data = CodMedida::find($id);
            $sublineas = $this->listar_sublineas($data->med_lineas_id);
            $car_udm = $this->listar_carac_y_unidad_medida($data->med_sublineas_id);


            return response()->json(['values' => $data, 'sublineas' => $sublineas, 'carac_udm' => $car_udm], 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Elimina un registro via ajax
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id){
        try {
            CodMedida::find($id)->delete();
            return response()->json('regitro eliminado',200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Valida que que la denominacion no se repita
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function validar_denominacion(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_medidas')
                    ->where('med_lineas_id','=', $request->linea)
                    ->where('med_lineas_id','=', $request->sublinea)
                    ->where('denominacion','=', $request->denominacion)
                    ->count();
                if ($data === 0){
                    return response()->json(true,200);
                }else{
                    return response()->json(false,200);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
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
                CodMedida::updateOrCreate(['id' => $request->id],
                    [   'cod'               => $request->cod,
                        'denominacion'      => $request->denominacion,
                        'diametro'          => $request->Diametro,
                        'pestana'           => $request->Pestaña,
                        'espesor'           => $request->Espesor,
                        'base'              => $request->Base,
                        'altura'            => $request->Altura,
                        'perforacion'       => $request->Perforacion,
                        'coments'           => $request->coments,
                        'med_lineas_id'     => $request->linea,
                        'med_sublineas_id'  => $request->sublinea,
                        'mm2'               => $request->mm2,
                        'usuario'       => Auth::user()->username,

                    ]);
                return response()->json('Registro guardado',200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * Lista de sublineas
     * funcion privada
     *
     * @param $linea_id
     * @return void
     */
    private function listar_sublineas($linea_id){
        return CodSublinea::where('lineas_id', $linea_id)
            ->orderby('name', 'asc')
            ->get();
    }


    /**
     * Lista de caracteristicas y de unidades de medida
     * funcion privada
     *
     * @param $sublinea_id
     * @return array
     */
    private function listar_carac_y_unidad_medida($sublinea_id){
        try {
            $unidades_medida = CodSublinea::find($sublinea_id);
            $und_medida = $unidades_medida->UnidadesMedida;
            $carac_unidades_medida = $unidades_medida->CaracteristicasUnidadesMedida;
            return ['unidades_medida' => $und_medida, 'carac_unidades_medida' => $carac_unidades_medida];

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
