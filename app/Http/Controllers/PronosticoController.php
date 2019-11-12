<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PronosticoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->OpenAndClose)) {
                $data = DB::connection('MAX')->table('CIEV_V_Pronosticos')
                    ->select('CIEV_V_Pronosticos.NumeroPronostico as numero',
                        'CIEV_V_Pronosticos.FechaPronostico as fecha',
                        'CIEV_V_Pronosticos.Referencia as ref',
                        'CIEV_V_Pronosticos.Descripcion as descrip',
                        'CIEV_V_Pronosticos.Detalle as detail',
                        'CIEV_V_Pronosticos.Acabado as acabado',
                        'CIEV_V_Pronosticos.Cantidad as cant',
                        'CIEV_V_Pronosticos.Cliente as NumeroCli',
                        'CIEV_V_Pronosticos.RazonSocial as NombreCli',
                        'CIEV_V_Pronosticos.Estado as estado')
                    ->where('estado','=',$request->OpenAndClose)
                    ->orderBy('estado', 'desc')
                    ->get();
            }else{
                $data = DB::connection('MAX')->table('CIEV_V_Pronosticos')
                    ->select('CIEV_V_Pronosticos.NumeroPronostico as numero',
                        'CIEV_V_Pronosticos.FechaPronostico as fecha',
                        'CIEV_V_Pronosticos.Referencia as ref',
                        'CIEV_V_Pronosticos.Descripcion as descrip',
                        'CIEV_V_Pronosticos.Detalle as detail',
                        'CIEV_V_Pronosticos.Acabado as acabado',
                        'CIEV_V_Pronosticos.Cantidad as cant',
                        'CIEV_V_Pronosticos.Cliente as NumeroCli',
                        'CIEV_V_Pronosticos.RazonSocial as NombreCli',
                        'CIEV_V_Pronosticos.Estado as estado')
                    ->where('estado','=','3')
                    ->orderBy('estado', 'asc')
                    ->get();
            }
           return DataTables::of($data)
               ->make(true);
        }
        return view('Pronosticos.index');
    }

    public function Inventory (Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->Valor)) {
            $Inv = DB::connection('MAX')->table('CIEV_V_Inventario')
                ->select('CIEV_V_Inventario.Descripcion as descripcion',
                    'CIEV_V_Inventario.Cant as total',
                    'CIEV_V_Inventario.Pieza as pieza',
                    'CIEV_V_Inventario.CantComprometida as CantComp')
                ->where('pieza','=',$request->Valor)->take(1)
                ->get();
            }

            return response()->json($Inv);
        }
    }

    Public  function CantCompro (Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->Comprmetida)) {
                $Quantity = DB::connection('MAX')->table('CIEV_V_OVAbiertas')
                    ->select('CIEV_V_OVAbiertas.REFERENCIA as Ref',
                        'CIEV_V_OVAbiertas.Ov as Ordvent',
                        'CIEV_V_OVAbiertas.razon_social as Client',
                        'CIEV_V_OVAbiertas.cant_actual as Pedida',
                        'CIEV_V_OVAbiertas.Cant_despachada as Enviada',
                        'CIEV_V_OVAbiertas.Cant_facturada as Factu',
                        'CIEV_V_OVAbiertas.Cant_pendiente as Pendi')
                    ->where('CIEV_V_OVAbiertas.REFERENCIA','=',$request->Comprmetida)
                    ->get();
            }
            return DataTables::of($Quantity)
                ->make(true);
        }
    }

    Public  function DetailsLots (Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->Detalle)) {
                $DetxLot = DB::connection('MAX')->table('CIEV_V_Inventario')
                    ->select('CIEV_V_Inventario.lote as lote',
                        'CIEV_V_Inventario.Bodega as bodega',
                        'CIEV_V_Inventario.cant as cantidad')
                    ->where('pieza','=',$request->Detalle)
                    ->get();
            }
            return DataTables::of($DetxLot)
                ->make(true);
        }
    }






    public function Pronostics (Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->Numero)) {
                $var = DB::connection('MAX')->table('CIEV_V_EstadoOP')
                   /* ->join('CIEV_V_EstadoOP','CIEV_V_OP_Pronosticos.pronostico','like','CIEV_V_EstadoOP.ov')*/

                    ->join('CIEV_V_OP_Pronosticos', 'CIEV_V_EstadoOP.ov', 'like', 'CIEV_V_OP_Pronosticos.pronostico')
                    ->where('CIEV_V_EstadoOP.ov', 'like', $request->Numero . '%')
                    ->select('CIEV_V_OP_Pronosticos.NombreVendedor as vendedor',
                        'CIEV_V_OP_Pronosticos.RazonSocial as cliente',
                        'CIEV_V_EstadoOP.ordnum_14 as NumOrdProduct',
                        'CIEV_V_EstadoOP.rlsdte_14 as fechaliberacion',
                        'CIEV_V_EstadoOP.pmdes1_01 as producto',
                        'CIEV_V_EstadoOP.prtnum_14 as numproducto',
                        'CIEV_V_EstadoOP.oprdes_14 as operacion',
                        'CIEV_V_EstadoOP.wrkctr_14 as proceso',
                        'CIEV_V_EstadoOP.qtyrem_14 as cantProceso',
                        'CIEV_V_EstadoOP.qtycom_14 as cantCompletada',
                        'CIEV_V_EstadoOP.movday_14 as cantDesechada',
                        'CIEV_V_EstadoOP.movdte_14 as salida',
                        'CIEV_V_EstadoOP.curcom_14 as entrega',
                        'CIEV_V_EstadoOP.ctactual as estado'
                    )->get();
            }
            return response()->json($var);
        }
    }
}
