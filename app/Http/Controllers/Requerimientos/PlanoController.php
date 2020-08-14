<?php

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    public function index(){
        try {
            $data = DB::table('propuestas_requerimientos as p')
                ->join('encabezado_requerimientos as r','p.idRequerimiento','=','r.id')
                ->where('p.estado', '=', '3')
                ->groupBy('p.idRequerimiento')
                ->select( 'r.*')
                ->get();

            return view('aplicaciones.requerimientos.planos.index', compact('data'));

        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }
}
