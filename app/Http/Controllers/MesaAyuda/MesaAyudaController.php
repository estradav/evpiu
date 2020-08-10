<?php

namespace App\Http\Controllers\MesaAyuda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MesaAyudaController extends Controller
{
    public function requerimientos_admon(){
        return view('aplicaciones.tickets.index');
    }
}
