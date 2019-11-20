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
                ->addColumn('Opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editmedida" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletemedida"><i class="fas fa-trash"></i></a>'.'</div>';
                    return $btn;
                })
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
}
