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
use Yajra\DataTables\DataTables;

class ProdCievCodCodigoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = CodCodigo::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('Opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editCodigo" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deleteCodigo">Eliminar</a>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Codificador.codificador');
    }

    public function store(Request $request)
    {
        CodCodigo::updateOrCreate(['id'     => $request->medida_id],
            [   'codigo'                    => $request->codigo,
                'coments'                   => $request->coments,
                'cod_tipo_producto_id'      => $request->ctipoproducto_id,
                'cod_lineas_id'             => $request->clineas_id,
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
            foreach ($getmedida as $medida){
                $getMedidaArray[$medida->id] = $medida->name;
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
            foreach ($var1 as $v1){
                $Array[$v1->id] = $v1->denominacion;
            }
            return response()->json($Array);

        }
    }

}
