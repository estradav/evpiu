<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Dompdf\Options;

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
        ini_set('max_execution_time', 180);

        DB::table('employee_prevention_days')
            ->where('id','=',$request['result']['id'])
            ->update([
                'time_enter'   => $request['result']['time_exit']
            ]);

        return response()->json(['Guardado con exito'],200);
    }


    public function edit_temperature(Request $request){
        DB::table('employee_prevention_temperature_peer_day')
            ->where('id','=', $request['result']['id'])
            ->update([
                'temperature'   =>  $request['result']['temperature'],
                'created_at'    =>  $request['result']['time']

            ]);

        return response()->json(['Guardado con exito'],200);
    }

    public function edit_created_at(Request $request){

        $date_format = $request['result']['created_at'];
        $date_format = explode("-",$date_format);
        $date_format = $date_format[2]."-".$date_format[1]."-".$date_format[0]." 00:00:00";

        DB::table('employee_prevention_days')
            ->where('id','=', $request['result']['id'])
            ->update([
               'created_at' =>  $date_format
            ]);

        return response()->json(['Guardado con exito'],200);
    }

    public function download_informe(Request $request ){
        $data = DB::table('employee_prevention_days')
            ->join('employee_prevention','employee_prevention_days.id_employee','=','employee_prevention.id')
            ->whereBetween('created_at', array($request->star_date, $request->end_date))
            ->select('employee_prevention_days.id','employee_prevention_days.created_at',
                'employee_prevention_days.time_enter', 'employee_prevention.employee', 'employee_prevention.id as emp_id')
            ->get();


        $attrs = [];
        foreach ($data as $key => $value) {
            $attrs[$value->employee][] = $value;
        }

        foreach ($attrs as $value){
            for ($j = 0; $j <= sizeof($value)-1; $j++){
                $temperatures = DB::table('employee_prevention_temperature_peer_day')
                    ->where('id_day','=',$value[$j]->id)
                    ->get('temperature');

                $value[$j]->temperature = $temperatures;
            }
        }

        $values = [
            'fechas'    => $request->star_date.' - '.$request->end_date,
            'data'      => $attrs
        ];

        $pdf = PDF::loadView('medida_prevencion.pdf', $values);
        return $pdf->download('archivo.pdf');
    }

    public function change_status(Request $request){

        $status =   DB::table('employee_prevention')->where('id','=', $request->id)->pluck('state');

        try {
            if ($status[0] === 1){
                DB::table('employee_prevention')->where('id','=', $request->id)->update([
                    'state'    =>  0
                ]);
            }else {
                DB::table('employee_prevention')->where('id','=', $request->id)->update([
                    'state'    =>  1
                ]);
            }
            return response()->json('Guardado', 200);
        }catch (\Exception $e){

            return response()->json($e->getMessage(), 500);
        }

    }
}
