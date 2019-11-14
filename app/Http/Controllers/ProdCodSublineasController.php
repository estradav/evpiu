<?php

namespace App\Http\Controllers;

use App\CodLinea;
use App\CodSublinea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCodSublineasController extends Controller 
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =DB::table('cod_sublineas')
                ->leftJoin('cod_lineas','cod_sublineas.lineas_id','=','cod_lineas.id')
                ->leftJoinSub('select `unidades_medidas`.`name ,unidades_medidas.descripcion, medidas_to_sublineas.sub_id','pivot_sub_id','unidades_medidas.id','=','medidas_to_sublineas.med_id')
                ->select('cod_sublineas.cod as cod','cod_sublineas.name as name','cod_sublineas.abreviatura as abrev','cod_sublineas.coments as coment',
                    'cod_lineas.name as linea','cod_sublineas.id as id','cod_sublineas.usuario as usr','cod_sublineas.created_at as created','cod_sublineas.updated_at as update');

            return Datatables::of($data)
                ->addColumn('Opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editsublinea" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletesubLinea"><i class="fas fa-trash"></i></a>'.'</div>';
                    return $btn;
                })
                ->rawColumns(['Opciones'])
                ->make(true);
        }

        $sub = CodSublinea::find(1);

       foreach ($sub->UnidadesMedida as $UnidadesMedid) {
           //obteniendo los datos de un menu específico
           echo $UnidadesMedid->name.'text- '.$UnidadesMedid->descripcion;
           echo $UnidadesMedid->pivot->sub_id;
           //obteniendo datos de la tabla pivot por menu
       }

        return view('ProductosCIEV.Maestros.sublineas_show');
    }

    public function store(Request $request)
    {
        CodSublinea::updateOrCreate(['id' => $request->sublinea_id],
            [   'cod'               => $request->cod,
                'name'              => $request->name,
/*              'tipoproductos_id'  => $request->tipoproductos_id,*/
                'lineas_id'         => $request->lineas_id,
                'abreviatura'       => $request->abreviatura,
                'coments'           => $request->coments,
            ]);
        return response()->json();
    }

    public function edit($id)
    {
        $codsublinea = CodSublinea::find($id);
        return response()->json($codsublinea);
    }

    public function destroy($id)
    {
        CodSublinea::find($id)->delete();
        return response()->json();
    }

    public function getlineasp(Request $request)
    {
        if ($request->ajax()){
            $getlineas = CodLinea::where('tipoproducto_id', '!=', $request->tipoproductos_id)->get();
            foreach ($getlineas as $linea){
                $getlineasArray[$linea->id] = $linea->name;
            }
            return response()->json($getlineasArray);
        }
    }

    public function UniqueCod(Request $request)
    {
        $UniqueCod = DB::table('cod_sublineas')->where('cod','=',$request->cod)->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }
}
