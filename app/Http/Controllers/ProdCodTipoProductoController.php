<?php

namespace App\Http\Controllers;

use App\CodTipoProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ProdCodTipoProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CodTipoProducto::latest()->get();
            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn =  '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editTipoProducto" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deleteTipoProducto"><i class="fas fa-trash"></i></a>'.'</div>';
                    return $btn;
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
            [   'cod'           => $request->cod,
                'name'          => $request->name,
                'coments'       => $request->coments,
                'usuario'       => $request->NameUser,

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

}
