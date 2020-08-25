<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SensorChimeneaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('sensores.index');
    }

    public function data_chimenea(Request $request)
    {
        $start_date = $request->star_date;
        $end_date   = $request->end_date;

        $data = DB::table('sensor_chimeneas')
            ->whereBetween('fecha',  [$start_date, $end_date])
            ->get();

        $attrs = array();
        foreach ($data as $key => $value) {
            $time = explode(':',$value->time);
            $time = $time[0].':00:00';

            $attrs[$value->fecha][] = array(
                'fecha' => $value->fecha,
                'time' => $time,
                'temperature_inyecctora' => floatval($value->temperature_inyecctora),
                'temperature_horno' => floatval($value->temperature_horno),
            );
        }

        $array = array();

        foreach ($attrs as $day){
            $groups = array();
            $inyec_array = array();
            $horno_array = array();

            foreach ($day as $item) {
                $key = $item['time'];
                array_push($inyec_array,$item['temperature_inyecctora']);
                array_push($horno_array, $item['temperature_horno']);

                if (!isset($groups[$key])) {
                    $groups[$key] = array(
                        'time' => $key,
                        'temperature_inyecctora' => $item['temperature_inyecctora'],
                        'temperature_horno' => $item['temperature_horno'],
                        'items' => 1,
                        'fecha' => $item['fecha']
                    );
                } else {
                    $groups[$key]['temperature_inyecctora'] = $groups[$key]['temperature_inyecctora'] + $item['temperature_inyecctora'];
                    $groups[$key]['temperature_horno'] = $groups[$key]['temperature_horno'] + $item['temperature_horno'];
                    $groups[$key]['items']++;
                }
            }
            $groups['max_and_min'] =  [
                'max_inyecctora' => max($inyec_array),
                'min_inyecctora' => min($inyec_array),
                'max_horno'      => max($horno_array),
                'min_horno'      => min($horno_array)
            ];
            array_push($array, $groups);
        }

        return response()->json($array,200);
    }

    public function data_gas(Request $request)
    {
        $start_date = $request->star_date;
        $end_date   = $request->end_date;

        $data = DB::table('sensor_gas')
            ->whereBetween('fecha',  [$start_date, $end_date])
            ->get();


        $attrs = array();
        foreach ($data as $key => $value) {
            $time = explode(':',$value->time);
            $time = $time[0].':00:00';

            $attrs[$value->fecha][] = array(
                'fecha'     => $value->fecha,
                'time'      => $time,
                'lectura'   => floatval(str_replace(',', '.', str_replace('.', '', $value->lectura))),
            );
        }


        $array = array();

        foreach ($attrs as $day) {
            $groups = array();
            foreach ($day as $item) {
                $key = $item['time'];
                if (!isset($groups[$key])) {
                    $groups[$key] = array(
                        'time' => $key,
                        'lectura' => floatval($item['lectura']),
                        'items' => 1,
                        'fecha' => $item['fecha']
                    );
                } else {
                    $groups[$key]['lectura'] =  $item['lectura'] - $groups[$key]['lectura'];
                    $groups[$key]['items']++;
                }
            }

            array_push($array, $groups);
        }

        return response()->json($array,200);
    }
}
