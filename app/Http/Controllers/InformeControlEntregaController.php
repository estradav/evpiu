<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeControlEntregaController extends Controller
{
    public function index(Request $request)
    {

        if (request()->ajax()) {
            if (!empty($request->customer)){
                $values = DB::connection('MAX')
                    ->table('')
                    ->where('','',0)
                    ->get();

            }
        }

        return view('Informes.ControlEntregas.index');
    }



}
