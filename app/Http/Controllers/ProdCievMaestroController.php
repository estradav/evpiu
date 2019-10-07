<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdCievMaestroController extends Controller
{
    public function index()
    {
        return view('ProductosCIEV.Maestros.index');
    }
}
