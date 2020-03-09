<?php

namespace App\Http\Controllers;

use App\CodMedida;
use App\CodSublinea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCievCodMedidaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('cod_medidas')
                ->leftJoin('cod_lineas','cod_medidas.med_lineas_id','=','cod_lineas.id')
                ->leftJoin('cod_sublineas','cod_medidas.med_sublineas_id','=','cod_sublineas.id')
                ->select('cod_medidas.cod as cod','cod_medidas.denominacion as denm','cod_medidas.updated_at as upt',
                    'cod_medidas.diametro as diametro','cod_medidas.largo as largo','cod_medidas.espesor as espesor',
                    'cod_medidas.base as base','cod_medidas.mm2 as mm2','cod_medidas.perforacion as perforacion','cod_medidas.altura as altura',
                    'cod_medidas.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_medidas.id as id')->get();

            return DataTables::of($data)
                ->addColumn('Opciones',
                    '<div class="btn-group ml-auto">
                        @can("medida.editar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Editar" class="btn btn-sm editmedida" id="edit-btn"><i class="fas fa-edit" style="color: #3085d6"></i></a>
                        @endcan
                        @can("medida.eliminar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Eliminar" class="btn btn-sm deletemedida"><i class="fas fa-trash" style="color: #db4437"></i></a>
                        @endcan
                        </div>'
                )
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Maestros.medidas_show');
    }

    public function store(Request $request)
    {
        CodMedida::updateOrCreate(['id' => $request->medida_id],
            [   'cod'               => $request->cod,
                'denominacion'      => $request->denominacion,
                'diametro'          => $request->Diametro,
                'largo'             => $request->Largo,
                'espesor'           => $request->Espesor,
                'base'              => $request->Base,
                'altura'            => $request->Altura,
                'perforacion'       => $request->Perforacion,
                'coments'           => $request->coments,
                'med_lineas_id'     => $request->med_lineas_id,
                'med_sublineas_id'  => $request->med_sublineas_id,
                'mm2'               => $request->mm2
            ]);

        return response()->json(['success'=>'Medida Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codmedida = CodMedida::find($id);
        return response()->json($codmedida);
    }

    public function destroy($id)
    {
        CodMedida::find($id)->delete();
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
        $UniqueCod = DB::table('cod_medidas')->where('cod','=',$request->cod)->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }

    public function getCaractUnidadMedidas(Request $request)
    {
        if ($request->ajax()){
            $sub = CodSublinea::find($request->sublineas_id);
            $CarUnidadesMedidaArray = [];

            foreach ($sub->CaracteristicasUnidadesMedida as $CarUnidadesMedida) {
                $CarUnidadesMedidaArray[] = $CarUnidadesMedida->descripcion;
            }
            return response()->json($CarUnidadesMedidaArray);
        }
    }

    public function getUnidadMedidasMed (Request $request)
    {
        if ($request->ajax()){
            $sub = CodSublinea::find($request->Sub_id);
            $UnidadesMedidaArray = [];

            foreach ($sub->UnidadesMedida as $UnidadesMedid) {
                $UnidadesMedidaArray[$UnidadesMedid->name] = $UnidadesMedid->descripcion;
            }
            return response()->json($UnidadesMedidaArray);
        }
    }

    public function ultimoId( Request $request)
    {
        if ($request->ajax()) {
            $var = DB::table('cod_medidas')->select('cod')->get();
            $Array =[];
            foreach ($var as $v) {
                $Array[] = $v->cod;
            }
            return response()->json($Array);
        }
    }

    public function UltimoCodId(Request $request)
    {
        $value1 = DB::table('cod_medidas')->max('id');

        $value = DB::table('cod_medidas')->where('id','=',$value1)->select('cod')->get();
        $Array =[];
        foreach ($value as $v) {
            $Array[] = $v->cod;
        }

        return response()->json($Array);
    }


    public function UniqueDenominacion(Request $request)
    {
        $UniqueCod = DB::table('cod_medidas')
            ->where('med_lineas_id','=',$request->lineas_id)
            ->where('med_lineas_id','=',$request->sublineas_id)
            ->where('cod','=',$request->cod)
            ->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }
}
