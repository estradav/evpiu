<?php

namespace App\Http\Controllers;

use App\CodSublinea;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdCodSublineasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CodSublinea::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('Opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editsublinea" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletesubLinea">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Maestros.sublineas_show');
    }

    public function store(Request $request)
    {
        CodSublinea::updateOrCreate(['id' => $request->sublinea_id],
            [   'cod'           => $request->cod,
                'name'          => $request->name,
                'lineas_id'     => $request->lineas_id,
                'abreviatura'   => $request->abreviatura,
                'coments'       => $request->coments,
            ]);

        return response()->json(['success'=>'Linea Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codsublinea = CodSublinea::find($id);
        return response()->json($codsublinea);
    }

    public function destroy($id)
    {
        CodSublinea::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }


}
