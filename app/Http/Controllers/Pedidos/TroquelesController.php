<?php

namespace App\Http\Controllers\Pedidos;

use App\EncabezadoPedido;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TroquelesController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()){
            $data = EncabezadoPedido::with('cliente', 'info_area')
                ->where('Estado', '11')
                ->get();

            return Datatables::of($data)
                ->editColumn('created_at', function ($row){
                    Carbon::setLocale('es');
                    return  $row->created_at->format('d M Y h:i a');
                })
                ->addColumn('opciones', function($row){
                    return '
                        <div class="btn-group btn-sm" role="group">
                            <button class="btn btn-light opciones" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Opciones"><i class="fas fa-cogs"></i></button>
                            <button class="btn btn-light ver_pdf" id="'.$row->id.'" data-toggle="tooltip" data-placement="top" title="Ver"><i class="fas fa-file-pdf"></i></button>
                        </div>';
                })
                ->rawColumns(['opciones'])
                ->make(true);

        }
        return view('aplicaciones.pedidos.troqueles.index');
    }
}
