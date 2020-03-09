<?php

namespace App\Http\Controllers;

use App\CodLinea;
use App\CodTipoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCodLineasController extends Controller
{
    public function index(Request $request)
    {
    if ($request->ajax()) {
        $data = DB::table('cod_lineas')
            ->leftJoin('cod_tipo_productos','cod_lineas.tipoproducto_id','=','cod_tipo_productos.id')
            ->select('cod_lineas.cod as cod','cod_lineas.name as name','cod_lineas.abreviatura as abrev','cod_lineas.coments as coment',
                'cod_tipo_productos.name as tp','cod_lineas.id as id','cod_lineas.usuario as usr','cod_lineas.created_at as created','cod_lineas.updated_at as update')
            ->get();
        return Datatables::of($data)
            ->addColumn('opciones',
                '<div class="btn-group ml-auto">
                        @can("linea.editar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Editar" class="btn btn-sm editLinea" id="edit-btn"><i class="fas fa-edit" style="color: #3085d6"></i></a>
                        @endcan
                        @can("linea.eliminar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Eliminar" class="btn btn-sm deleteLinea"><i class="fas fa-trash" style="color: #db4437"></i></a>
                        @endcan
                        </div>'
            )
            ->editColumn('update', function ($data) {
                return Carbon::parse($data->update)->diffForHumans();
            })
            ->rawColumns(['opciones'])
            ->make(true);
    }
        return view('ProductosCIEV.Maestros.lineas_show');
    }

    public function store(Request $request)
    {
        CodLinea::updateOrCreate(
            ['id' => $request->linea_id],
            [   'cod'               => $request->codigo,
                'tipoproducto_id'   => $request->tipoproducto_id,
                'name'              => $request->name,
                'abreviatura'       => $request->abreviatura,
                'coments'           => $request->coments,
            ]);
        return response()->json(['success'=>'Linea Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codlinea = CodLinea::find($id);
        return response()->json($codlinea);
    }

    public function destroy($id)
    {
        CodLinea::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function UniqueCod(Request $request)
    {
        $UniqueCod = DB::table('cod_lineas')->where('cod','=',$request->codigo)->count();

        if($UniqueCod == 0)
        {
            return response()->json(true);
        }
        else {
            return response()->json(false);
        }
    }

    public function LinesUpdate(Request $request)
    {
        CodLinea::where('id',$request->id)
            ->update([
                'tipoproducto_id'   => $request->edit_tipoproducto_id,
                'name'              => $request->edit_name,
                'abreviatura'       => $request->edit_abreviatura,
                'coments'           => $request->edit_coments,
            ]);

        return response()->json(['true'],200);
    }
}
