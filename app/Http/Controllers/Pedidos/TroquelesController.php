<?php

namespace App\Http\Controllers\Pedidos;

use App\ClienteMax;
use App\EncabezadoPedido;
use App\Http\Controllers\Controller;
use App\MaestroPedido;
use Illuminate\Http\Request;

class TroquelesController extends Controller
{
    public function index(){


        $data = MaestroPedido::with('bodega', 'troqueles', 'produccion')->orderBy('id', 'desc')->first();

        $data2 = EncabezadoPedido::with('cliente', 'detalle', 'info_area')->first();

        $data3 = ClienteMax::where('CODIGO_CLIENTE', '10053')->get();


        dd( $data2 );


        return view('aplicaciones.pedidos.troqueles.index', compact('data2'));
    }
}
