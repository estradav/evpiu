<?php

namespace App\Http\Controllers;

use App\CodTipoProducto;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdCodTipoProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CodTipoProducto::latest()->get();
            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editLinea" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deleteLinea">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }

        return view('ProductosCIEV.Maestros.tiposproductos_show');
    }

    public function store(Request $request)
    {
        CodTipoProducto::updateOrCreate(
            ['id' => $request->tipoproducto_id],
            [   'cod'           => $request->cod,
                'name'          => $request->name,
                'coments'       => $request->coments,
            ]);

        return response()->json(['success'=>'Linea Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codlinea = CodTipoProducto::find($id);
        return response()->json($codlinea);
    }

    public function destroy($id)
    {
        CodTipoProducto::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }

}
