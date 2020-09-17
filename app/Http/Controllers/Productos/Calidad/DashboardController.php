<?php

namespace App\Http\Controllers\Productos\Calidad;

use App\Http\Controllers\Controller;
use App\InspectionWorkCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        return view('aplicaciones.productos.calidad.dashboard.index');
    }


    public function consultar_bimestre(Request  $request){
        //if ($request->ajax()) {
            try {
                $year = $request->get('year');
                $bimester = $request->get('bimester');
                $bimester = explode('-', $bimester);


                $date_start =  Carbon::parse($year.'-'.$bimester[0].'-1')->format('Y-m-d');
                $date_end   =  Carbon::parse($year.'-'.$bimester[1].'-1')->format('Y-m-d');


                $date_start = new Carbon($date_start);
                $date_end = new Carbon($date_end);


                $date_start = $date_start->startOfMonth()->format('Y-m-d H:i:s');
                $date_end = $date_end->endOfMonth()->format('Y-m-d H:i:s');



                /*Inspecciones por bimestre*/
                $inspections = InspectionWorkCenter::whereBetween('created_at', [$date_start, $date_end])
                    ->select('cause',
                        DB::raw("COUNT(cause) as cause_quantity"),
                    )->groupBy('cause')
                    ->get();
                $count_cause = $inspections->groupBy('cause');



                $inspections_centers = InspectionWorkCenter::whereBetween('created_at', [$date_start, $date_end])
                    ->select('center',
                        DB::raw("SUM(non_conforming_quantity) as non_conforming_quantity"),
                        DB::raw("SUM(quantity_inspected) as quantity_inspected"),
                        DB::raw("SUM(conforming_quantity) as conforming_quantity"),
                        DB::raw("SUM(non_conforming_quantity) as non_conforming_quantity"),
                        DB::raw("COUNT(center) as center_quantity"),
                    )->groupBy('center')
                    ->get();
                $inspections_centers = $inspections_centers->groupBy('center');








                return response()
                    ->json([
                        'causes'                => $count_cause,
                        'inspections_centers'   => $inspections_centers,
                ], 200);


            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        //}
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
}
