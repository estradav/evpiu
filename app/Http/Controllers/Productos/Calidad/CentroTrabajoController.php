<?php

namespace App\Http\Controllers\Productos\Calidad;

use App\CauseInspWorkCenter;
use App\Http\Controllers\Controller;
use App\InspectionWorkCenter;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CentroTrabajoController extends Controller
{

    /**
     * Formulario de consulta
     *
     * @return Factory|View
     */
    public function index(){
        $operators = User::where('app_roll', 'operario')
            ->orderBy('name', 'asc')
            ->get();

        $causes = CauseInspWorkCenter::orderBy('name', 'asc')->get();

        return view('aplicaciones.productos.calidad.inspeccion_centros_trabajo.index', compact('operators', 'causes'));
    }


    /**
     * Consulta una orden de produccion tanto en MAX como en EVPIU
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function consultar_op(Request $request){
        if ($request->ajax()) {
            try {
                $op = $request->production_order.'0000';


                $data_max = DB::connection('MAX')
                    ->table('CIEV_V_EstadoOP')
                    ->where('ORDNUM_14', '=', $request->production_order)
                    ->first();


                $registros = InspectionWorkCenter::where('production_order', $op)
                    ->with('inspector')
                    ->with('operator')
                    ->with('cause')
                    ->get();

                $registros = $this->group_by("center", $registros);


                $centros_trabajo = DB::connection('MAX')
                    ->table('CIEV_V_EstadoOP')
                    ->where('ORDNUM_14', '=', $request->production_order)
                    ->orderBy('OPRSEQ_14', 'asc')
                    ->pluck('WRKCTR_14')->toArray();


                $centro_actual = DB::connection('MAX')
                    ->table('CIEV_V_EstadoOP')
                    ->where('ORDNUM_14', '=', $request->production_order)
                    ->where('CTActual', '=', 'Y')
                    ->orderBy('OPRSEQ_14', 'asc')
                    ->pluck('WRKCTR_14')->toArray();

                $centro_actual = array_unique($centro_actual, SORT_STRING);
                $centro_actual =  array_merge($centro_actual, array());


                $result = array_unique($centros_trabajo, SORT_STRING);
                $result = array_merge($result, array());


                return response()->json([
                    'registros'     => $registros,
                    'data_max'      => $data_max,
                    'centros'       => $result, //SFC_WORK_CENTER,
                    'centro_actual' => $centro_actual
                ], 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * Guarda un registro de inspeccion
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request){
        if ($request->ajax()) {
            try {
                $formData = $request->all();
                InspectionWorkCenter::create($formData);

                return response()->json('Registro guardado!', 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * Obtiene informacion de una inspeccion especifica
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function info_review(Request $request){
        if ($request->ajax()) {
            try {
                $data = InspectionWorkCenter::where('id', $request->id)
                    ->with('inspector')
                    ->with('operator')
                    ->with('cause')
                    ->first();

                return response()->json($data, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * Agrupa los elementos de un array por una
     * clave dada en este caso el centro de trabajo
     *
     * @param $key
     * @param $data
     * @return array
     */
    private function group_by($key, $data) {
        $result = array();

        foreach($data as $val) {
            if(isset($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }


    /**
     * Consulta la descripccion de un centro de trabajo,
     * esto es netamente visual
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function consultar_descripcion_centro_trabajo(Request  $request){
        if ($request->ajax()) {
            try {
                $result = DB::connection('MAX')
                    ->table('SFC_Work_Center')
                    ->where('WRKCTR_13', '=', $request->string)
                    ->pluck('DESC_13')->first();

                return response()->json($result, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
