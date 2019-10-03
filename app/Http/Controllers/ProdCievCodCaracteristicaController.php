<?php

namespace App\Http\Controllers;

use App\CodCaracteristica;
use App\CodSublinea;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdCievCodCaracteristicaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CodCaracteristica::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editcaracteristica" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletecaracteristica">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Maestros.caracteristicas_show');
    }

    public function store(Request $request)
    {
        CodCaracteristica::updateOrCreate(['id' => $request->caracteristica_id],
            [   'cod'               => $request->cod,
                'name'              => $request->name,
                'mat_lineas_id'     => $request->mat_lineas_id,
                'mat_sublineas_id'  => $request->mat_sublineas_id,
                'abreviatura'       => $request->abreviatura,
                'coments'           => $request->coments,
            ]);

        return response()->json(['success'=>'Linea Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codcaracteristica = CodCaracteristica::find($id);
        return response()->json($codcaracteristica);
    }

    public function destroy($id)
    {
        CodCaracteristica::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }


    public function getSublineas(Request $request)
    {
        if ($request->ajax()){
            $getsublineas = CodSublinea::where('lineas_id', $request->lineas_id)->get();
            foreach ($getsublineas as $sblinea){
                $getsublineasArray[$sblinea->id] = $sblinea->name;
            }
            return response()->json($getsublineasArray);
        }
    }
}
