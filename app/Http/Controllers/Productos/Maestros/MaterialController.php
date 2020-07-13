<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodLinea;
use App\CodMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MaterialController extends Controller
{
    public function index(){
        $data = DB::table('cod_materials')
            ->leftJoin('cod_lineas','cod_materials.mat_lineas_id','=','cod_lineas.id')
            ->leftJoin('cod_sublineas','cod_materials.mat_sublineas_id','=','cod_sublineas.id')
            ->select('cod_materials.cod as cod','cod_materials.name as name','cod_materials.abreviatura as abrev','cod_materials.updated_at as updated',
                'cod_materials.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_materials.id as id')->get();

        $lineas = CodLinea::all();

        return view('aplicaciones.productos.maestros.material.index', compact('data', 'lineas'));
    }


    public function edit($id){
        try {
            $data = CodMaterial::find($id);
            return response()->json($data, 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }


    public function destroy($id){
        try {
            CodMaterial::find($id)->delete();
            return response()->json('registro eliminado', 200);

        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }


    public function store(Request $request){
        try {
            CodMaterial::updateOrCreate(['id' => $request->id],
                [   'cod'               => $request->cod ?? $request->code,
                    'name'              => $request->name,
                    'mat_lineas_id'     => $request->linea,
                    'mat_sublineas_id'  => $request->sublinea,
                    'abreviatura'       => $request->abrev,
                    'coments'           => $request->coments,
                ]);
            return response()->json('registro guardado', 200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(), 500);
        }
    }


    public function validar_codigo(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('cod_materials')
                    ->where('mat_lineas_id','=',$request->linea)
                    ->where('mat_sublineas_id','=',$request->sublinea)
                    ->where('cod','=',$request->cod)
                    ->count();
                if ($data == 0){
                    return response()->json(true, 200);
                }else{
                    return response()->json(false, 200);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}
