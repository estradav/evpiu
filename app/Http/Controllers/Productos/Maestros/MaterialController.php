<?php

namespace App\Http\Controllers\Productos\Maestros;

use App\CodLinea;
use App\CodMaterial;
use App\Http\Controllers\Controller;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class MaterialController extends Controller
{
    public function index(){
        $data = CodMaterial::with('Codlineas')
            ->with('CodSublineas')
            ->with('materiales')
            ->get();

        $lineas = CodLinea::all();
        $materiales = Material::orderBy('name', 'asc')->get();

        return view('aplicaciones.productos.maestros.material.index', compact('data', 'lineas', 'materiales'));
    }


    public function edit($id){
        try {
            $data = CodMaterial::with('Codlineas')
                ->with('CodSublineas')
                ->with('materiales')
                ->where('id', $id)
                ->first();

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
            CodMaterial::updateOrCreate(['id' => $request->id], [
                'mat_lineas_id'     => $request->linea,
                'mat_sublineas_id'  => $request->sublinea,
                'id_material'       => $request->material,
                'coments'           => $request->coments,
                'usuario'           => Auth::user()->id,
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
                    ->where('id_material','=',$request->material)
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
