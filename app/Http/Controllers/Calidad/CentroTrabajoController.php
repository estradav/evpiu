<?php

namespace App\Http\Controllers\Calidad;

use App\Http\Controllers\Controller;
use App\InspectionWorkCenter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CentroTrabajoController extends Controller
{
    public function index(){
        $operators = User::where('app_roll', 'operario')->get();
        return view('aplicaciones.calidad.inspeccion_centros_trabajo.index', compact('operators'));
    }


    public function consultar_op(Request $request){
        if ($request->ajax()) {
            try {
                $op = $request->production_order.'0000';


                $data_max = DB::connection('MAX')
                    ->table('CIEV_V_EstadoOP')
                    ->where('ORDNUM_14', '=', $request->production_order)
                    ->get();

                $registros = InspectionWorkCenter::where('production_order', '=', $op)
                    ->with('inspector')
                    ->with('operator')
                    ->get();

                return response()->json([
                    'registros' => $registros,
                    'data_max'  => $data_max
                ], 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }

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
}
