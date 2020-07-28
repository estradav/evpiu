<?php

namespace App\Http\Controllers\Pedidos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TroquelesController extends Controller
{
    public function index(){

        return view('aplicaciones.pedidos.troqueles.index');
    }
}
