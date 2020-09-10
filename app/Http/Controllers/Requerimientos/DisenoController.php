<?php

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisenoController extends Controller
{
    public function index(){
        try {
            if (Auth::user()->hasRole('super-admin') || Auth::user()->hasRole('super-diseno')){
                $data = DB::table('encabezado_requerimientos')
                    ->leftJoin('cod_codigos','encabezado_requerimientos.producto_id','=','cod_codigos.id')
                    ->select('encabezado_requerimientos.id as id',
                        'cod_codigos.descripcion as producto',
                        'encabezado_requerimientos.informacion',
                        'encabezado_requerimientos.marca_id',
                        'encabezado_requerimientos.estado',
                        'encabezado_requerimientos.created_at',
                        'encabezado_requerimientos.updated_at',
                        'encabezado_requerimientos.vendedor_id',
                        'encabezado_requerimientos.diseñador_id')
                    ->orderBy('estado', 'desc')
                    ->get();
            }else{
                $data = DB::table('encabezado_requerimientos')
                    ->leftJoin('cod_codigos','encabezado_requerimientos.producto_id','=','cod_codigos.id')
                    ->where('diseñador_id','=', Auth::user()->id)
                    ->select('encabezado_requerimientos.id as id',
                        'cod_codigos.descripcion as producto',
                        'encabezado_requerimientos.informacion',
                        'encabezado_requerimientos.marca_id',
                        'encabezado_requerimientos.estado',
                        'encabezado_requerimientos.created_at',
                        'encabezado_requerimientos.updated_at',
                        'encabezado_requerimientos.vendedor_id',
                        'encabezado_requerimientos.diseñador_id')
                    ->orderBy('estado', 'desc')
                    ->get();
            }
            return view('aplicaciones.requerimientos.diseno.index', compact('data'));

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
