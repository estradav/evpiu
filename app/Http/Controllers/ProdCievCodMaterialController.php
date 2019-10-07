<?php

namespace App\Http\Controllers;

use App\CodMaterial;
use App\CodSublinea;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProdCievCodMaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = CodMaterial::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editmaterial" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletematerial">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Maestros.materiales_show');
    }

    public function store(Request $request)
    {
        CodMaterial::updateOrCreate(['id' => $request->material_id],
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
        $codmaterial = CodMaterial::find($id);
        return response()->json($codmaterial);
    }

    public function destroy($id)
    {
        CodMaterial::find($id)->delete();
        return response()->json(['success'=>'deleted successfully.']);
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
