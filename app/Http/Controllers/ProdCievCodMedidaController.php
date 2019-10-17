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
                ->select('cod_medidas.cod as cod','cod_medidas.name as name','cod_medidas.denominacion as denm','cod_medidas.updated_at as upt',
                    'cod_medidas.exterior as ext','cod_medidas.interior as int','cod_medidas.largo as larg','cod_medidas.lado_1 as ld1','cod_medidas.lado_2 as ld2',
                    'cod_medidas.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_medidas.id as id')->get();
            return DataTables::of($data)
                ->addColumn('Opciones', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editmedida" id="edit-btn">Editar</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletemedida">Eliminar</a>';
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
                'name'              => $request->name,
                'denominacion'      => $request->denominacion,
                'interior'          => $request->interior,
                'exterior'          => $request->exterior,
                'largo'             => $request->largo,
                'lado_1'            => $request->lado_1,
                'lado_2'            => $request->lado_2,
                'coments'           => $request->coments,
                'med_lineas_id'     => $request->med_lineas_id,
                'med_sublineas_id'  => $request->med_sublineas_id,
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
}
