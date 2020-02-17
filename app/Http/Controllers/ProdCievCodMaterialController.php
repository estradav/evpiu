<?php

namespace App\Http\Controllers;

use App\CodMaterial;
use App\CodSublinea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCievCodMaterialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('cod_materials')
                ->leftJoin('cod_lineas','cod_materials.mat_lineas_id','=','cod_lineas.id')
                ->leftJoin('cod_sublineas','cod_materials.mat_sublineas_id','=','cod_sublineas.id')
                ->select('cod_materials.cod as cod','cod_materials.name as name','cod_materials.abreviatura as abrev','cod_materials.updated_at as upt',
                    'cod_materials.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_materials.id as id')->get();
            return DataTables::of($data)
                ->addColumn('Opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editmaterial" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletematerial"><i class="fas fa-trash"></i></a>'.'</div>';
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

    public function UniqueCod(Request $request)
    {
        $UniqueCod = DB::table('cod_materials')
            ->where('mat_lineas_id','=',$request->linea)
            ->where('mat_sublineas_id','=',$request->sublinea)
            ->where('cod','=',$request->cod)
            ->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }
}
