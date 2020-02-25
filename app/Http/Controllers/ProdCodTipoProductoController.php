<?php

namespace App\Http\Controllers;

use App\CodTipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCodTipoProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CodTipoProducto::latest()->get();

            return Datatables::of($data)
                ->addColumn('opciones',
                    '<div class="btn-group ml-auto">
                        @can("tipos_producto.editar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Editar" class="btn btn-sm editTipoProducto" id="edit-btn"><i class="far fa-edit" style="color: #3085d6;"></i></a>
                        @endcan
                        @can("tipos_producto.eliminar")
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="{{$id}}" data-original-title="Eliminar" class="btn btn-sm deleteTipoProducto"><i class="fas fa-trash" style="color: #db4437"></i></a>
                        @endcan
                        </div>'
                )
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->diffForHumans();
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->diffForHumans();
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }

        return view('ProductosCIEV.Maestros.tiposproductos_show');
    }

    public function store(Request $request)
    {
        CodTipoProducto::updateOrCreate(
            ['id' => $request->tipoproducto_id],
            [
                'usuario'       => $request->usuario,
                'cod'           => $request->cod,
                'name'          => $request->name,
                'coments'       => $request->coments,
            ]);

        return response()->json(['success'=>'Linea Guardada Correctamente.']);
    }

    public function edit($id)
    {
        $codlinea = CodTipoProducto::find($id);
        return response()->json($codlinea);
    }

    public function destroy($id)
    {
        CodTipoProducto::find($id)->delete();

        return response()->json(['success'=>'Product deleted successfully.']);
    }

    public function UniqueCod(Request $request)
    {
        $UniqueCod = DB::table('cod_tipo_productos')->where('cod','=',$request->cod)->count();

        if($UniqueCod == 0)
        {
            echo "true";  //good to register
        }
        else
        {
            echo "false"; //already registered
        }

    }

    public function TypesProductUpdate(Request $request)
    {
        CodTipoProducto::where('id',$request->id)
            ->update([
                'name'          => $request->edit_name,
                'coments'       => $request->edit_coments,
            ]);

        return response()->json(['true'],200);
    }

}
