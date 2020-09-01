<?php

namespace App\Http\Controllers\Comercial;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index()
    {
        try {
            if (Auth::user()->hasRole('super-admin')) {
                $clientes = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->orderBy('RAZON_SOCIAL', 'asc')
                    ->take(10)
                    ->get();
            } else {
                $clientes = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->where('VENDEDOR', '=', Auth::user()->codvendedor)
                    ->orderBy('RAZON_SOCIAL', 'asc')
                    ->get();
            }
            return view('aplicaciones.comercial.index', compact('clientes'));

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with([
                    'message' => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }



    public function obtener_eventos(Request $request){
        try {

            $data = DB::table('events_activities')
                ->where('created_by', '=', Auth::user()->id)
                ->where('type', '=', $request->type)
                ->where('nit', '=', $request->client)
                ->where('start','>=', $request->start)
                ->where('end', '<=', $request->end)
                ->get();

            return response()->json($data, 200);

        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
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
                        'created_by'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                    ]);
                return response()->json('success', 200);
            }catch(Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
