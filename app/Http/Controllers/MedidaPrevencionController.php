<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Type;


class MedidaPrevencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        try {
            $empleados = DB::connection('DMS')
                ->table('V_CIEV_Personal')
                ->where('estado', '=','A')
                ->pluck('nombres');
        }catch (\Exception $e){
            $empleados = [];
        }

        $empleados_registrados = DB::table('employee_prevention')
            ->where('state','=','1')
            ->get();

        return view('medida_prevencion.index',compact('empleados','empleados_registrados'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        return response()->json($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        $empleado_existe = DB::table('employee_prevention')
            ->where('employee','=',$request->empleado)
            ->count();

        if($empleado_existe == 0){
            $nuevo_empleado = DB::table('employee_prevention')->insertGetId([
                'employee'      =>  $request->empleado,
                'state'         =>  1
            ]);

            $nuevo_dia = DB::table('employee_prevention_days')->insertGetId([
                'id_employee'   =>  $nuevo_empleado,
                'time_enter'    =>  $request->datetime,
                'time_exit'     =>  ' ',
                'question_1'    =>  $request->question_1,
                'question_2'    =>  $request->question_2,
                'question_3'    =>  $request->question_3,
                'question_4'    =>  $request->question_4,
                'question_5'    =>  $request->question_5,
                'question_6'    =>  $request->question_6,
                'notes'         =>  $request->notas,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);

            DB::table('employee_prevention_temperature_peer_day')->insert([
                'id_day'        =>  $nuevo_dia ,
                'temperature'   =>  $request->temperatura,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);

            return response()->json(['Empleado registrado con exito!'],200);
        }
        elseif($empleado_existe == 1){

            $info_empleado = DB::table('employee_prevention')
                ->where('employee','=',$request->empleado)
                ->get();


            $dia = DB::table('employee_prevention_days')
                ->where('id_employee','=',$info_empleado[0]->id)
                ->whereDate('created_at','=', Carbon::now())
                ->count();

            if($dia == 1 && $info_empleado[0]->state == 1){
                return response()->json(['El empleado seleccionado ya se encuenta trabajando'],200);
            }
            elseif ($dia == 1 && $info_empleado[0]->state == 0){
                DB::table('employee_prevention')
                    ->where('employee','=', $request->empleado)
                    ->update([
                        'state'  => '1'
                    ]);
            }
            else if($dia == 0){
                $nuevo_dia = DB::table('employee_prevention_days')->insertGetId([
                    'id_employee'   =>  $info_empleado[0]->id,
                    'time_enter'    =>  $request->datetime,
                    'time_exit'     =>  ' ',
                    'question_1'    =>  $request->question_1,
                    'question_2'    =>  $request->question_2,
                    'question_3'    =>  $request->question_3,
                    'question_4'    =>  $request->question_4,
                    'question_5'    =>  $request->question_5,
                    'question_6'    =>  $request->question_6,
                    'notes'         =>  $request->notas,
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ]);
                DB::table('employee_prevention_temperature_peer_day')->insert([
                    'id_day'        =>  $nuevo_dia ,
                    'temperature'   =>  $request->temperatura,
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ]);
            }

            if ($info_empleado[0]->state == 1){
                return response()->json(['El empleado seleccionado ya se encuenta trabajando'],200);
            }
            elseif ($info_empleado[0]->state == 0){
                DB::table('employee_prevention')
                    ->where('employee','=',$request->empleado)
                    ->update([ 'state' => '1' ]);
                return response()->json(['Empleado registrado'],200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request)
    {
        $days = DB::table('employee_prevention_days')
            ->where('id_employee','=',$request->id)
            ->get();

        for ($j = 0; $j <= count($days) -1 ; $j++){
            $tempeatures =  DB::table('employee_prevention_temperature_peer_day')
                ->where('id_day','=',$days[$j]->id)
                ->select('id','temperature', 'created_at')
                ->get();

            $days[$j]->temperature = $tempeatures;
        }
        return response()->json(['days' => $days ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return void
     */
    public function registry_temperature_in_day(Request $request)
    {
        $dia_id = DB::table('employee_prevention_days')
            ->where('id_employee','=', $request['result']['id'])
            ->whereDate('created_at','=', Carbon::now())->pluck('id');


        DB::table('employee_prevention_temperature_peer_day')
            ->insert([
                'id_day'        =>  $dia_id[0],
                'temperature'   =>  $request['result']['temperatura_input'],
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function exit_employee_in_day(Request $request)
    {
        $dia_id = DB::table('employee_prevention_days')
            ->where('id_employee','=', $request['result']['id'])
            ->whereDate('created_at','=', Carbon::now())->pluck('id');


        DB::table('employee_prevention_temperature_peer_day')
            ->insert([
                'id_day'        =>  $dia_id[0],
                'temperature'   =>  $request['result']['temperatura_input'],
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);

        DB::table('employee_prevention_days')
            ->where('id_employee','=', $request['result']['id'])
            ->whereDate('created_at','=', Carbon::now())
            ->update([
                'time_exit'  =>  $request['result']['hora_salida']
        ]);

        DB::table('employee_prevention')
            ->where('id','=', $request['result']['id'])
            ->update([
               'state'  => '0'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function get_all_employees(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            $tags = DB::connection('DMS')
                ->table('V_CIEV_Personal')
                ->where('estado', '=','A')
                ->get();
            $formatted_tags = [];
            foreach ($tags as $tag) {
                $formatted_tags[] = ['id' => $tag->nombres, 'text' => $tag->nombres];
            }
            return response()->json($formatted_tags);
        }
    }

    public function edit_temperature (Request $request){
        DB::table('employee_prevention_temperature_peer_day')
            ->where('id','=',$request->id_edit_temperature)
            ->update([
                'temperature'   => $request->temperature_edit_temperature,
                'created_at'    => $request->date_edit_temperature
            ]);

        return response()->json(['Guardado con exito'],200);
    }
}
