<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index(){
        try {
            $vendedores = User::where('app_roll', 'vendedor')->Orderby('name', 'asc')->get();
            return view('aplicaciones.comercial.dashboard', compact('vendedores'));
        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }

    }


    public function consultar_clientes(Request $request){
        if($request->ajax()){
            try {
                $clientes = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->where('VENDEDOR', '=', $request->id)
                    ->orderBy('RAZON_SOCIAL', 'asc')
                    ->get();

                return response()->json($clientes, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function consultar_info_cliente(Request $request){
        if ($request->ajax()){
            try {
                $eventos_visitas = DB::table('events_activities')
                    ->where('created_by', '=', User::where('codvendedor',$request->vendedor)->pluck('id')->first() )
                    ->where('nit', '=', $request->cliente)
                    ->where('type', '=', '1')
                    ->get();

                $eventos_actividades = DB::table('events_activities')
                    ->where('created_by', '=', User::where('codvendedor',$request->vendedor)->pluck('id')->first() )
                    ->where('nit', '=', $request->cliente)
                    ->where('type', '=', '0')
                    ->get();

                return response()->json([
                    'eventos_visitas'       => $eventos_visitas,
                    'eventos_actividades'   => $eventos_actividades
                ], 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function store(Request $request){
        if($request->ajax()){
            try{
                $start =  strtotime($request->date.' '.$request->start);
                $start = date('Y-m-d H:i:s', $start);

                $end = strtotime($request->date.' '.$request->end);
                $end = date('Y-m-d H:i:s', $end);


                DB::table('events_activities')
                    ->insert([
                        'title'         =>  $request->title,
                        'start'         =>  $start,
                        'end'           =>  $end,
                        'type'          =>  $request->type,
                        'nit'           =>  $request->nit,
                        'created_by'    =>  User::where('codvendedor',$request->vendedor)->pluck('id')->first(),
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                    ]);
                return response()->json('success', 200);
            }catch(\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }

}
