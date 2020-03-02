<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class InformeOrdenProduccionController extends Controller
{
    public function index(Request $request){

        if (request()->ajax()) {
            if (!empty($request->start)) {
                $data = DB::connection('MAX')
                    ->table('CIEV_V_OP')
                    ->whereBetween('ORDNUM_10', array($request->start, $request->end))
                    ->select('ORDNUM_10')
                    ->orderBy('ORDNUM_10','desc')
                    ->get();
            }else{
                $data = DB::connection('MAX')
                    ->table('CIEV_V_OP')
                    ->select('ORDNUM_10')
                    ->take(3000)
                    ->orderBy('ORDNUM_10','desc')
                    ->get();
            }
            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-right">'.'<button class="btn btn-sm ImprimirOrden" id="'.$row->ORDNUM_10.'"><i class="fas fa-file-pdf" style="color: #3085d6"></i> PDF</button></div>';
                    return $btn;
                })
                ->addColumn('selectAll', function($row){
                    $btn = '<input type="checkbox" class="checkboxes test" id="'.$row->ORDNUM_10.'" name="'.$row->ORDNUM_10.'">';
                    return $btn;
                })
                ->rawColumns(['opciones','selectAll'])
                ->make(true);
        }
        return view('Informes.OrdenProduccion.index');
    }

    public function Barcode(Request $request)
    {

        $Orders[] = $request->selected;

        $orders_data = [];


        foreach ($Orders[0] as $order){
            $Query = DB::connection('MAX')
                ->table('CIEV_V_OP')
                ->where('ORDNUM_10','=',$order)->get();


            array_push($orders_data,$Query[0]);
        }



        return view('Informes.OrdenProduccion.barcode')->with('Orders',$orders_data);
    }
}
