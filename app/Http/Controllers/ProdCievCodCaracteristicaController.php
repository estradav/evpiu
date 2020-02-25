<?php

namespace App\Http\Controllers;

use App\CodCaracteristica;
use App\CodSublinea;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCievCodCaracteristicaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('cod_caracteristicas')
                ->leftJoin('cod_lineas','cod_caracteristicas.car_lineas_id','=','cod_lineas.id')
                ->leftJoin('cod_sublineas','cod_caracteristicas.car_sublineas_id','=','cod_sublineas.id')
                ->select('cod_caracteristicas.cod as cod','cod_caracteristicas.name as name','cod_caracteristicas.abreviatura as abrev','cod_caracteristicas.updated_at as upt',
                    'cod_caracteristicas.coments as coment','cod_lineas.name as linea','cod_sublineas.name as sublinea','cod_caracteristicas.id as id')->get();
            return DataTables::of($data)
                ->addColumn('Opciones',
                    '<div class="btn-group ml-auto">
                        @can("caracteristicas.editar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Editar" class="btn btn-sm editcaracteristica" id="edit-btn"><i class="far fa-edit" style="color: #3085d6"></i></a>
                        @endcan
                        @can("caracteristicas.eliminar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Eliminar" class="btn btn-sm deletecaracteristica"><i class="fas fa-trash" style="color: #db4437"></i></a>
                        @endcan
                        </div>'
                )
                ->editColumn('upt', function ($data) {
                    return Carbon::parse($data->upt)->diffForHumans();
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }
        return view('ProductosCIEV.Maestros.caracteristicas_show')->with('getsublineas');
    }

    public function store(Request $request)
    {
        CodCaracteristica::updateOrCreate(['id' => $request->caracteristica_id],
            [   'cod'               => $request->cod,
                'name'              => $request->name,
                'car_lineas_id'     => $request->car_lineas_id,
                'car_sublineas_id'  => $request->car_sublineas_id,
                'abreviatura'       => $request->abreviatura,
                'coments'           => $request->coments,
            ]);
        return response()->json();
    }

    public function edit($id)
    {
        $codcaracteristica = CodCaracteristica::find($id);
        return response()->json($codcaracteristica);
    }

    public function destroy($id)
    {
        CodCaracteristica::find($id)->delete();
        return response()->json();
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
        $UniqueCod = DB::table('cod_caracteristicas')
            ->where('car_lineas_id','=',$request->linea)
            ->where('car_sublineas_id','=',$request->sublinea)
            ->where('cod','=',$request->cod)
            ->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }
}
