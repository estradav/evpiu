<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\Node\Stmt\Foreach_;
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

    public function Inventory(Request $request)
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

    Public function CantCompro(Request $request)
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

    Public function DetailsLots(Request $request)
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

    public function Pronostics(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->Numero)) {
                $var = DB::connection('MAX')
                    ->table('CIEV_V_OP_Pronosticos_v1')
                    ->where('CIEV_V_OP_Pronosticos_v1.pronostico', '=', $request->Numero)
                    ->select('CIEV_V_OP_Pronosticos_v1.OP as NumOrdProduct',
                        'CIEV_V_OP_Pronosticos_v1.fechaOP as fechaliberacion',
                        'CIEV_V_OP_Pronosticos_v1.Referencia as producto',
                        'CIEV_V_OP_Pronosticos_v1.TipoOP as TipoOP',
                        'CIEV_V_OP_Pronosticos_v1.CantActual as cantProceso',
                        'CIEV_V_OP_Pronosticos_v1.Arte as arte',
                        'CIEV_V_OP_Pronosticos_v1.DiasOP as dias',
                        'CIEV_V_OP_Pronosticos_v1.EstadoOP as estado')
                    ->get();

                $Orden = [];
                foreach($var as $v){
                    $Orden [] = DB::connection('MAX')
                        ->table('CIEV_V_EstadoOP')
                        ->where('Expr1','=',$v->NumOrdProduct)
                        ->get();
                }
            }
            return response()->json(['pronostico' => $var, 'ordenes' => $Orden]);
        }
    }

    public function Pronostico_para_cerrar(Request $request)
    {
        $Pronosticos = DB::connection('MAX')
            ->table('CIEV_V_Pronosticos')
            ->where('Estado','=','3')->pluck('NumeroPronostico');

        $EstadoOp =[];
        foreach($Pronosticos as $pronostico){
            $EstadoOp[$pronostico] = DB::connection('MAX')
                ->table('CIEV_V_OP_Pronosticos_v1')
                ->where('Pronostico','=',$pronostico)
                ->select('Pronostico','EstadoOP')->get();
        }

        $recuento = [];
        foreach ($EstadoOp as $OP){
            if (count($OP) != 0){
                $bandera = 1;

                foreach ($OP as $p){
                    if (trim($p->EstadoOP) == 3 ){
                        $bandera = 0;
                    }

                }
                if ($bandera == 1){
                    $recuento[] = $OP[0]->Pronostico;
                }
            }
        }
        return response()->json(['Cantidad' => count($recuento), 'Pronosticos' => $recuento]);
    }

    public function cerrar_pronosticos(Request $request)
    {
        foreach ($request->pronosticos as $pronostico){
            DB:: beginTransaction();

            try{
                DB::connection('MAX')->table('Order_Master')->where('ORDNUM_10','=',$pronostico)->update([
                    'STATUS_10' => '4'
                ]);

                DB::connection('MAX')->table('Requirement_Detail')->where('ORDNUM_11','=',$pronostico)->update([
                    'STATUS_11' => '4'
                ]);
            }
            catch (\Exception $e){
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'code2' =>$e->getLine(),
                    ),
                ));
            }
        }
    }
}
