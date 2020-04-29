<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EditMedidaPrevencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $registros = DB::table('employee_prevention')->get();

        return view('medida_prevencion.edit_index',compact('registros'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $employee = DB::table('employee_prevention')
            ->where('id','=', $id)
            ->get();

        $days = DB::table('employee_prevention_days')
            ->where('id_employee','=',$id)
            ->get();

        for ($j = 0; $j <= count($days) -1 ; $j++){
            $tempeatures =  DB::table('employee_prevention_temperature_peer_day')
                ->where('id_day','=',$days[$j]->id)
                ->select('id','temperature', 'created_at')
                ->get();

            $days[$j]->temperature = $tempeatures;
        }
        return view('medida_prevencion.edit',compact('employee','days'));
    }


    /**
     * Update time entrance to employee.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function edit_time_enter(Request $request)
    {
        DB::table('employee_prevention_days')
            ->where('id','=',$request['result']['id'])
            ->update([
                'time_enter'   => $request['result']['time_enter']
            ]);

        return response()->json(['Guardado con exito'],200);
    }


    /**
     * Update time exit to employee.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function edit_time_exit(Request $request)
    {
        DB::table('employee_prevention_days')
            ->where('id','=',$request['result']['id'])
            ->update([
                'time_enter'   => $request['result']['time_exit']
            ]);

        return response()->json(['Guardado con exito'],200);
    }


    public function edit_temperature(Request $request)
    {
        DB::table('employee_prevention_temperature_peer_day')
            ->where('id','=', $request['result']['id'])
            ->update([
                'temperature'   =>  $request['result']['temperature'],
                'created_at'    =>  $request['result']['time']

            ]);

        return response()->json(['Guardado con exito'],200);
    }

}
