<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Psy\Exception\Exception;
use Yajra\DataTables\DataTables;

class BitacoraOmffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =  DB::table('bitacora_omff')->select(DB::raw('DATE(created_at) as date, machine , tb, rz, vz, z, workshift, operator, maintenance, type_maintenance, id '), DB::raw('count(*) as views'))
                ->groupBy('date')
                ->get();


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

    public function Create(Request $request)
    {
        return view('BitacoraOMFF.create');
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
                return response()->json(['ok'],200);
            } catch (Exception $e) {
                report($e);

                return false;
            }
        }
    }

    public function Details(Request $request)
    {
        if ($request->ajax()) {

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
        }
    }
}
