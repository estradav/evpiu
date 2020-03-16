<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Exception\Exception;
use Yajra\DataTables\DataTables;

class BitacoraOmffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
            $data =  DB::table('bitacora_omff')
                ->select(DB::raw('DATE(created_at) as date, machine , tb, rz, vz, z, workshift, operator, maintenance, type_maintenance, id '), DB::raw('count(*) as views'))
                ->groupBy('date')
                ->get();

                Log::info('[BitacoraOMFF]: Datatables cargado correctamente');

            }catch(Exception $e){
                Log::emergency('[BitacoraOMFF]: '. $e->getLine());
            }

            return Datatables::of($data)
                ->addColumn('Opciones',
                    '<div class="btn-group ml-auto">
                    @can("bitacora_omff.ver")
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$date}}" data-original-title="info" class="btn btn-sm info" id="{{$date}}"><i class="fas fa-info-circle" style="color: #3085d6"></i> Ver datos</a>
                    @endcan
                    </div>'
                )
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->date)->toDateString();
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('BitacoraOMFF.index');
    }

    public function Create()
    {
        return view('BitacoraOMFF.create');
    }


    public function create_hl1()
    {
        return view('BitacoraOMFF.hl1_form');
    }

    public function Store(Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::table('bitacora_omff')->insert([
                    'machine'               => $request->machine,
                    'tb'                    => $request->TB,
                    'rz'                    => $request->RZ,
                    'vz'                    => $request->VZ,
                    'z'                     => $request->Z,
                    'workshift'             => $request->turno,
                    'operator'              => $request->operario,
                    'maintenance'           => $request->maintenance,
                    'type_maintenance'      => $request->type_maintenance,
                    'operator_maintenance'  => $request->operator_maintenance,
                    'created_by'            => $request->created_by,
                    'observations'          => $request->observations,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now()
                ]);

                Log::info('[BitacoraOMFF]: Registro guardado correctamente');

                return response()->json(['ok'],200);
            }catch(Exception $e){
                Log::error('[BitacoraOMFF]: '. $e->getLine());
                return false;
            }
        }
    }

    public function Details(Request $request)
    {
        if ($request->ajax()) {
            try {
                $values = DB::table('bitacora_omff')
                    ->where('created_at','like',$request->date.'%')
                    ->select('machine','workshift', DB::raw('sum(tb) as tb'),DB::raw('sum(rz) as rz'),DB::raw('sum(vz) as vz'),DB::raw('sum(z) as z'))
                    ->groupBy('machine', 'workshift')
                    ->get()->toArray();

                $turno1 = [];
                $turno2 = [];
                $turno3 = [];

                foreach ($values as $v){
                    if ($v->workshift == '1'){
                        array_push($turno1,$v);
                    }elseif ($v->workshift == '2'){
                        array_push($turno2,$v);
                    }elseif ($v->workshift == '3'){
                        array_push($turno3,$v);
                    }
                }
                return response()->json(['turno1' => $turno1, 'turno2' => $turno2,'turno3' => $turno3],200);

            }catch(Exception $e){
                Log::emergency('[BitacoraOMFF]: '. $e->getLine());
                return false;
            }
        }
    }

    public function chart_peer_day(Request $request)
    {
        try {
            $P300 = [];
            $P301 = [];
            $P302 = [];
            $P303 = [];
            $P304 = [];
            $P305 = [];
            $P306 = [];
            $P307 = [];
            $P308 = [];

            $dates_query = DB::table('bitacora_omff')
                ->select('machine','workshift', DB::raw('sum(tb) as tb'),DB::raw('DATE(created_at) as date'),DB::raw('sum(rz) as rz'),DB::raw('sum(vz) as vz'),DB::raw('sum(z) as z'))
                ->groupBy( 'date','machine')
                ->get()->toArray();

            foreach ($dates_query as $value) {
                if ($value->machine == 'P300') {
                    $P300[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P301') {
                    $P301[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P302') {
                    $P302[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P303') {
                    $P303[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P304') {
                    $P304[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P305') {
                    $P305[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P306') {
                    $P306[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P307') {
                    $P307[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                } else if ($value->machine == 'P308') {
                    $P308[] = ['fecha' => $value->date, 'lingotes' => $value->rz + $value->vz + $value->z + $value->tb];
                }
            }

            $P300_days = []; $P300_values = [];
            $P301_days = []; $P301_values = [];
            $P302_days = []; $P302_values = [];
            $P303_days = []; $P303_values = [];
            $P304_days = []; $P304_values = [];
            $P305_days = []; $P305_values = [];
            $P306_days = []; $P306_values = [];
            $P307_days = []; $P307_values = [];
            $P308_days = []; $P308_values = [];

            foreach ($P300 as $P){
                array_push($P300_days, $P['fecha']);
                array_push($P300_values, $P['lingotes']);
            }
            foreach ($P301 as $P){
                array_push($P301_days, $P['fecha']);
                array_push($P301_values, $P['lingotes']);
            }
            foreach ($P302 as $P){
                array_push($P302_days, $P['fecha']);
                array_push($P302_values, $P['lingotes']);
            }
            foreach ($P303 as $P){
                array_push($P303_days, $P['fecha']);
                array_push($P303_values, $P['lingotes']);
            }
            foreach ($P304 as $P){
                array_push($P304_days, $P['fecha']);
                array_push($P304_values, $P['lingotes']);
            }
            foreach ($P305 as $P){
                array_push($P305_days, $P['fecha']);
                array_push($P305_values, $P['lingotes']);
            }
            foreach ($P306 as $P){
                array_push($P306_days, $P['fecha']);
                array_push($P306_values, $P['lingotes']);
            }
            foreach ($P307 as $P){
                array_push($P307_days, $P['fecha']);
                array_push($P307_values, $P['lingotes']);
            }
            foreach ($P308 as $P){
                array_push($P308_days, $P['fecha']);
                array_push($P308_values, $P['lingotes']);
            }


            $P300 = [];
            $P301 = [];
            $P302 = [];
            $P303 = [];
            $P304 = [];
            $P305 = [];
            $P306 = [];
            $P307 = [];
            $P308 = [];

            array_push($P300,['date' => $P300_days,'value' => $P300_values]);
            array_push($P301,['date' => $P301_days,'value' => $P301_values]);
            array_push($P302,['date' => $P302_days,'value' => $P302_values]);
            array_push($P303,['date' => $P303_days,'value' => $P303_values]);
            array_push($P304,['date' => $P304_days,'value' => $P304_values]);
            array_push($P305,['date' => $P305_days,'value' => $P305_values]);
            array_push($P306,['date' => $P306_days,'value' => $P306_values]);
            array_push($P307,['date' => $P307_days,'value' => $P307_values]);
            array_push($P308,['date' => $P308_days,'value' => $P308_values]);


            return response()->json([
                'P300'  => $P300,
                'P301'  => $P301,
                'P302'  => $P302,
                'P303'  => $P303,
                'P304'  => $P304,
                'P305'  => $P305,
                'P306'  => $P306,
                'P307'  => $P307,
                'P308'  => $P308,
            ]);

        }catch(Exception $e){
            Log::emergency('[BitacoraOMFF]: '. $e->getLine());
            return response()->json('error',404);
        }
    }

    public function Save_Hl1 (Request $request)
    {
        if ($request->ajax()) {
            try {
                DB::table('bitacora_omff_hl1')->insert([
                    'start'                 => $request->start,
                    'end'                   => $request->end,
                    'operator'              => $request->operario,
                    'lingotes'              => $request->lingotes,
                    'created_by'            => $request->created_by,
                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now()
                ]);
                Log::info('[BitacoraOMFF]: Registro guardado correctamente');
                return response()->json(['ok'],200);

            }catch(Exception $e){
                Log::error('[BitacoraOMFF]: '. $e->getLine());
                return false;
            }
        }
    }

    public function Details_Hl1(Request $request)
    {
        $values = DB::table('bitacora_omff_hl1')
            ->where('created_at','like',$request->date.'%')
            ->select(DB::raw('DATE(created_at) as date'),DB::raw('sum(lingotes) as lingotes'))
            ->groupBy('date')
            ->get()->toArray();

        return response()->json($values);
    }

    public function hl1(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data =  DB::table('bitacora_omff_hl1')
                    ->select(DB::raw('DATE(created_at) as date, id, start, end '), DB::raw('count(*) as views'))
                    ->groupBy('date')
                    ->get();

                Log::info('[BitacoraOMFF]: Datatables cargado correctamente');

            }catch(Exception $e){
                Log::emergency('[BitacoraOMFF]: '. $e->getLine());
            }

            return Datatables::of($data)
                ->addColumn('Opciones',
                    '<div class="btn-group ml-auto">
                    @can("bitacora_omff.ver")
                    <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$date}}" data-original-title="info" class="btn btn-sm info_hl1" id="{{$date}}"><i class="fas fa-info-circle" style="color: #3085d6"></i> Ver datos</a>
                    @endcan
                    </div>'
                )
                ->editColumn('created_at', function ($data) {
                    return Carbon::parse($data->date)->toDateString();
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
    }
}
