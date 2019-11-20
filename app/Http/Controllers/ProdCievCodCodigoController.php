<?php

namespace App\Http\Controllers;

use App\CodCaracteristica;
use App\CodCodigo;
use App\CodLinea;
use App\CodMaterial;
use App\CodMedida;
use App\CodSublinea;
use App\CodTipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;
use Yajra\DataTables\DataTables;

class ProdCievCodCodigoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('cod_codigos')
                ->leftJoin('cod_tipo_productos','cod_codigos.cod_tipo_producto_id','=','cod_tipo_productos.id')
                ->leftJoin('cod_lineas','cod_codigos.cod_lineas_id','=','cod_lineas.id')
                ->leftJoin('cod_sublineas','cod_codigos.cod_sublineas_id','=','cod_sublineas.id')
                ->leftJoin('cod_medidas','cod_codigos.cod_medidas_id','=','cod_medidas.id')
                ->leftJoin('cod_materials','cod_codigos.cod_materials_id','=','cod_materials.id')
                ->leftJoin('cod_caracteristicas','cod_codigos.cod_caracteristicas_id','=','cod_caracteristicas.id')
                ->select('cod_codigos.codigo as codigo','cod_codigos.coments as coment','cod_codigos.descripcion as desc','cod_codigos.usuario','cod_codigos.usuario_aprobo',
                    'cod_codigos.arte','cod_codigos.estado','cod_codigos.area','cod_codigos.costo_base','cod_codigos.generico','cod_codigos.created_at',
                    'cod_codigos.updated_at','cod_tipo_productos.name as tp','cod_lineas.name as lin','cod_sublineas.name as subl','cod_medidas.denominacion as med','cod_materials.name as mat',
                    'cod_caracteristicas.name as car','cod_codigos.id as id')
                ->get();

            return DataTables::of($data)
                ->addColumn('Opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editCodigo" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deleteCodigo"><i class="fas fa-trash"></i></a>'.'</div>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Codificador.codificador');
    }

    public function store(Request $request)
    {
        CodCodigo::updateOrCreate(['id'     => $request->codigo],
            [   'codigo'                    => $request->codigo,
                'coments'                   => $request->coments,
                'cod_tipo_producto_id'      => $request->tipoproducto_id,
                'cod_lineas_id'             => $request->lineas_id,
                'cod_sublineas_id'          => $request->sublineas_id,
                'cod_medidas_id'            => $request->medida_id,
                'cod_caracteristicas_id'    => $request->caracteristica_id,
                'cod_materials_id'          => $request->material_id,
                'descripcion'               => $request->descripcion
            ]);
        return response()->json(['success'=>'Medida Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codmedida = CodCodigo::find($id);
        return response()->json($codmedida);
    }

    public function destroy($id)
    {
        CodCodigo::find($id)->delete();
        return response()->json(['success'=>'deleted successfully.']);
    }

    public function getlineas(Request $request)
    {
        if ($request->ajax()){
            $getlineas = CodLinea::where('tipoproducto_id', $request->tipoproducto_id)->get();
            foreach ($getlineas as $linea){
                $getlineasArray[$linea->id] = $linea->name;
            }
            return response()->json($getlineasArray);
        }
    }

    public function getsublineas(Request $request)
    {
        if ($request->ajax()){
            $getsublineas = CodSublinea::where('lineas_id', $request->lineas_id)->get();
            foreach ($getsublineas as $sblinea){
                $getsublineasArray[$sblinea->id] = $sblinea->name;
            }
            return response()->json($getsublineasArray);
        }
    }

    public function getcaracteristica(Request $request)
    {
        if ($request->ajax()){
            $getcaracteristicas = CodCaracteristica::where('car_sublineas_id', $request->car_sublineas_id)->get();
            $getCaracteristicaArray = [];
            foreach ($getcaracteristicas as $caracteristica){
                $getCaracteristicaArray[$caracteristica->id] = $caracteristica->name;
            }
            return response()->json($getCaracteristicaArray);
        }
    }

    public function getmaterial(Request $request)
    {
        if ($request->ajax()){
            $getmaterial= CodMaterial::where('mat_sublineas_id', $request->mat_sublineas_id)->get();
            $getMaterialArray = [];
            foreach ($getmaterial as $material){
                $getMaterialArray[$material->id] = $material->name;
            }
            return response()->json($getMaterialArray);
        }
    }

    public function getmedida(Request $request)
    {
        if ($request->ajax()){
            $getmedida= CodMedida::where('med_sublineas_id', $request->med_sublineas_id)->get();
            $getMedidaArray = [];
            foreach ($getmedida as $medida){
                $getMedidaArray[$medida->id] = $medida->denominacion;
            }
            return response()->json($getMedidaArray);
        }
    }

    public function ctp(Request $request)
    {
        if($request->ajax()){
            $var = CodTipoProducto::where('id', $request->tipoproducto_id)->get();
            foreach ($var as $v){
                $Array[$v->cod] = $v->abreviatura;
            }
            return response()->json($Array);
        }
    }

    public function lns (Request $request)
    {
        if ($request->ajax()){
            $var1 = CodLinea::where('id', $request->lineas_id)->get();
            foreach ($var1 as $v1){
                $Array1[$v1->cod] = $v1->abreviatura;
            }
            return response()->json($Array1);
        }
    }

    public function sln (Request $request)
    {
        if ($request->ajax()){
            $var1 = CodSublinea::where('id', $request->sublineas_id)->get();
            foreach ($var1 as $v1){
                $Array[$v1->cod] = $v1->abreviatura;
            }
            return response()->json($Array);
        }
    }

    public function mat (Request $request)
    {
        if ($request->ajax()){
            $var1 = CodMaterial::where('id', $request->material_id)->get();
            $Array=[];
            foreach ($var1 as $v1){
                $Array[$v1->cod] = $v1->abreviatura;
            }
            return response()->json($Array);
        }
    }

    public function car (Request $request)
    {
        if ($request->ajax()){
            $var1 = CodCaracteristica::where('id', $request->caracteristica_id)->get();
            $Array=[];
            foreach ($var1 as $v1){
                $Array[$v1->cod] = $v1->abreviatura;
            }
            return response()->json($Array);
        }
    }

    public function med (Request $request)
    {
        if ($request->ajax()){
            $var1 = CodMedida::where('id', $request->medida_id)->get();
            $Array=[];
            foreach ($var1 as $v1){
                $Array[$v1->id] = $v1->denominacion;
            }
            return response()->json($Array);
        }
    }

    public function GetCodigos (Request $request)
    {
        if ($request->ajax()) {
            $var = DB::table('cod_codigos')->select('codigo')->get();
            $Array =[];
            foreach ($var as $v) {
                $Array[] = $v->codigo;
            }
            return response()->json($Array);
        }
    }

    public function UniqueCod(Request $request)
    {
        $UniqueCod = DB::table('cod_codigos')->where('codigo','=',$request->codigo)->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }

    public function UniqueDescription(Request $request)
    {
        $UniqueCod = DB::table('cod_codigos')->where('descripcion','=',$request->descripcion)->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }
}
