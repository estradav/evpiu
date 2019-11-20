<?php

namespace App\Http\Controllers;

use App\CodLinea;
use App\CodSublinea;
use App\Services\Sublineas;
use App\UnidadesMedida;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProdCodSublineasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('cod_sublineas')
                ->leftJoin('cod_lineas','cod_sublineas.lineas_id','=','cod_lineas.id')
                ->select('cod_sublineas.cod as cod','cod_sublineas.name as name','cod_sublineas.abreviatura as abrev',
                    'cod_sublineas.coments as coment', 'cod_lineas.name as linea','cod_sublineas.id as id','cod_sublineas.usuario as usr',
                    'cod_sublineas.created_at as created','cod_sublineas.updated_at as update','cod_sublineas.id as DT_Row_Index' );


            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('Medidas', function($row){
                    $btn1 = '<div class="btn-group" style="text-align: center">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="showMed" class="btn btn-light btn-sm showMed" id="'.$row->id.'">Mostrar</a>'.'</div>';
                    return $btn1;
                })

                ->addColumn('Car_Medidas', function($row){
                    $btn1 = '<div class="btn-group" style="text-align: center">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="showCarMed" class="btn btn-light btn-sm showCarMed" id="'.$row->id.'">Mostrar</a>'.'</div>';
                    return $btn1;
                })

                ->addColumn('Opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Editar" class="edit btn btn-primary btn-sm editsublinea" id="edit-btn"><i class="far fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Eliminar" class="btn btn-danger btn-sm deletesubLinea"><i class="fas fa-trash"></i></a>'.'</div>';
                    return $btn;
                })
                ->rawColumns(['Opciones','Medidas','Car_Medidas'])
                ->make(true);

        }
       /* 625-500469-50
        008-000284-69*/

        return view('ProductosCIEV.Maestros.sublineas_show');
    }

    public function edit($id)
    {
        $codsublinea = CodSublinea::find($id);
        return response()->json($codsublinea);
    }

    public function destroy($id)
    {
        DB::table('medidas_to_sublineas')->where('sub_id','=',$id)->delete();
        DB::table('caracteristicasmedidas_to_sublineas')->where('sub_id','=',$id)->delete();
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

    public function getUnidadMedidas(Request $request)
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

    public function getCarUnidadMedidas(Request $request)
    {
        if ($request->ajax()){
            $sub = CodSublinea::find($request->Sub_id);
            $CarUnidadesMedidaArray = [];

            foreach ($sub->CaracteristicasUnidadesMedida as $CarUnidadesMedida) {
                $CarUnidadesMedidaArray[] = $CarUnidadesMedida->descripcion;
            }
            return response()->json($CarUnidadesMedidaArray);
        }
    }

    public function getALLUnidadMedidas(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            $tags = DB::table('unidades_medidas')->get();
            $formatted_tags = [];
            foreach ($tags as $tag) {
                $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->descripcion];
            }
            return response()->json($formatted_tags);
        }

        $tags = DB::table('unidades_medidas')->where('descripcion','like',$term)
            ->orWhere('name','like',$term)->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->descripcion];
        }
        return response()->json($formatted_tags);
    }

    public function getALLCaracteristicasUnidadMedidas(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            $tags = DB::table('caracteristicas_unidades_medidas')->get();
            $formatted_tags = [];
            foreach ($tags as $tag) {
                $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->descripcion];
            }
            return response()->json($formatted_tags);
        }

        $tags = DB::table('caracteristicas_unidades_medidas')->where('descripcion','like',$term)
            ->orWhere('name','like',$term)->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->descripcion];
        }
        return response()->json($formatted_tags);
    }

    public function SaveSublinea(Request $request)
    {
        if ($request->encabezado[0]['id'] == null) {

            DB::beginTransaction();
            try {
                $sb = DB::table('cod_sublineas')->insertGetId([
                    'cod' => $request->encabezado[0]['cod'],
                    'name' => $request->encabezado[0]['name'],
                    'hijo' => $request->encabezado[0]['hijo'],
                    'lineas_id' => $request->encabezado[0]['linea'],
                    'abreviatura' => $request->encabezado[0]['abre'],
                    'coments' => $request->encabezado[0]['coments'],
                ]);

                $umedidas = $request->umedidas;
                foreach ($umedidas as $d) {
                    DB::table('medidas_to_sublineas')->insert([
                        'sub_id' => $sb,
                        'med_id' => $d,
                    ]);
                }

                $carmedidas = $request->carmedidas;
                foreach ($carmedidas as $d) {
                    DB::table('caracteristicasmedidas_to_sublineas')->insert([
                        'sub_id' => $sb,
                        'car_med_id' => $d,
                    ]);
                }
                DB::commit();
                return response()->json(['Success' => 'Todo Ok']);

            } catch (\Exception $e) {
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                    ),
                ));
                return response()->json(['Error' => 'Fallo']);
            }
        }
        else
            {
            DB::beginTransaction();
            try {
                DB::table('cod_sublineas')
                    ->where('id', $request->encabezado[0]['id'])
                    ->update([
                        'cod'               => $request->encabezado[0]['cod'],
                        'name'              => $request->encabezado[0]['name'],
                        'hijo'              => $request->encabezado[0]['hijo'],
                        'lineas_id'         => $request->encabezado[0]['linea'],
                        'abreviatura'       => $request->encabezado[0]['abre'],
                        'coments'           => $request->encabezado[0]['coments'],
                    ]);

                DB::table('medidas_to_sublineas')->where('sub_id','=',$request->encabezado[0]['id'])->delete();
                DB::table('caracteristicasmedidas_to_sublineas')->where('sub_id','=',$request->encabezado[0]['id'])->delete();

                $umedidas = $request->umedidas;
                foreach ($umedidas as $d) {
                    DB::table('medidas_to_sublineas')->insert([
                        'sub_id' => $request->encabezado[0]['id'],
                        'med_id' => $d,
                    ]);
                }

                $carmedidas = $request->carmedidas;
                foreach ($carmedidas as $d) {
                    DB::table('caracteristicasmedidas_to_sublineas')->insert([
                        'sub_id' => $request->encabezado[0]['id'],
                        'car_med_id' => $d,
                    ]);
                }

                DB::commit();

                return response()->json(['Success' => 'Todo Okey']);
            }
            catch (\Exception $e){
                DB::rollback();
                echo json_encode(array(
                    'error' => array(
                        'msg' => $e->getMessage(),
                        'code' => $e->getCode(),
                    ),
                ));

                return response()->json(['Error' => 'Fallo']);
            }
        }
    }
}
