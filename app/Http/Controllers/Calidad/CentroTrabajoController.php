<?php

namespace App\Http\Controllers\Calidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CentroTrabajoController extends Controller
{
    public function index(){
        return view('aplicaciones.calidad.inspeccion_centros_trabajo.index');
    }


    public function consultar_op(Request $request){
        if ($request->ajax()) {
            try {


            }catch (\Exception $e){

            }
        }
    }
}
