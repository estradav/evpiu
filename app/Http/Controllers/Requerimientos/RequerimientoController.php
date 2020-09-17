<?php

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequerimientoController extends Controller
{
    public function index(){
        try {
            if (Auth::user()->hasRole('super-admin')){
                $data = DB::table('encabezado_requerimientos')
                    ->leftJoin('cod_codigos','encabezado_requerimientos.producto_id','=','cod_codigos.id')
                    ->select('encabezado_requerimientos.id as id',
                        'cod_codigos.descripcion as producto',
                        'encabezado_requerimientos.informacion',
                        'encabezado_requerimientos.marca_id',
                        'encabezado_requerimientos.estado',
                        'encabezado_requerimientos.created_at',
                        'encabezado_requerimientos.updated_at',
                        'encabezado_requerimientos.vendedor_id',
                        'encabezado_requerimientos.diseñador_id')
                    ->orderBy('estado', 'desc')
                    ->get();
            }else{
                $data = DB::table('encabezado_requerimientos')
                    ->leftJoin('cod_codigos','encabezado_requerimientos.producto_id','=','cod_codigos.id')
                    ->where('vendedor_id','=', Auth::user()->id)
                    ->select('encabezado_requerimientos.id as id',
                        'cod_codigos.descripcion as producto',
                        'encabezado_requerimientos.informacion',
                        'encabezado_requerimientos.marca_id',
                        'encabezado_requerimientos.estado',
                        'encabezado_requerimientos.created_at',
                        'encabezado_requerimientos.updated_at',
                        'encabezado_requerimientos.vendedor_id',
                        'encabezado_requerimientos.diseñador_id')
                    ->orderBy('estado', 'desc')
                    ->get();
            }

            $vendedores =  DB::table('users')
                ->where('app_roll','=','vendedor')
                ->orderBy('name','asc')
                ->get();

            return view('aplicaciones.requerimientos.ventas.index', compact('data', 'vendedores'));

        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }



    public function listar_clientes(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::connection('MAX')
                    ->table('CIEV_V_Clientes')
                    ->where('RAZON_SOCIAL', 'LIKE', '%'.$query.'%')
                    ->orWhere('CODIGO_CLIENTE', 'LIKE', '%'.$query.'%')
                    ->take(20)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value' => trim($q->RAZON_SOCIAL),
                        'cod'   => trim($q->CODIGO_CLIENTE),
                        'nit'   => trim($q->NIT)
                    ];
                }
                return response()->json($results, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    public function listar_marcas(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::table('marcas')
                    ->where('name', 'LIKE', '%'.$query.'%')
                    ->take(20)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value' =>  $q->name,
                        'id'    =>  $q->id
                    ];
                }
                return response()->json($results, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    public function listar_productos(Request $request){
        if ($request->ajax()){
            try {
                $query = $request->get('query');
                $results = array();

                $queries = DB::table('cod_codigos')
                    ->where('descripcion', 'LIKE', '%'.$query.'%')
                    ->orWhere('codigo', 'LIKE', '%'.$query.'0000')
                    ->take(10)
                    ->get();

                foreach ($queries as $q) {
                    $results[] = [
                        'value'     => trim($q->descripcion),
                        'id'        => $q->id
                    ];
                }
                return response()->json($results, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    public function validar_marca(Request $request){
        if ($request->ajax()){
            try {
                $data = DB::table('marcas')
                    ->where('name','=',$request->nombre_marca)
                    ->count();


                if ($data == 0){
                    return  response()->json(true, 200);
                }else{
                    return  response()->json(false, 200);
                }

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }



    public function guardar_marca(Request $request){
        if ($request->ajax()){
            try {
                DB::table('marcas')
                    ->insert([
                        'name'          => $request->nombre_marca,
                        'comments'      => $request->comentario_marca,
                        'type'          => $request->tipo_marca,
                        'created_by'    => Auth::user()->id,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now(),
                ]);
                return  response()->json('Marca guardada con exito', 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function store(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {

                $id_req = DB::table('encabezado_requerimientos')
                    ->insertGetId([
                        'producto_id'   => $request->producto_id,
                        'informacion'   => $request->info,
                        'cliente'       => $request->cliente,
                        'nit'           => $request->nit,
                        'marca_id'      => $request->marca_id,
                        'vendedor_id'   => $request->vendedor_id,
                        'render'        => $request->render ? '1' : '0',
                        'usuario_id'    => Auth::user()->id,
                        'estado'        => '1',
                        'created_at'    => Carbon::now(),
                        'Updated_at'    => Carbon::now(),
                ]);

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $id_req,
                        'tipo'          =>  'Nuevo Requerimiento',
                        'descripcion'   =>  'Creo un nuevo requerimiento',
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $id_req,
                        'tipo'          =>  'Cambio de estado',
                        'descripcion'   =>  'Requerimiento enviado para revision.',
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::commit();
                return response()->json('Requerimiento guardado con exito', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function edit($id){
        $enc =  DB::table('encabezado_requerimientos')
            ->where('id', '=', $id)
            ->first();

        if ($enc->vendedor_id == Auth::user()->id || Auth::user()->hasRole('super-admin') || $enc->diseñador_id == Auth::user()->id || Auth::user()->hasPermissionTo('aplicaciones.requerimientos.plano')){
            try {
                $data =  DB::table('encabezado_requerimientos')
                    ->where('id', '=', $id)
                    ->first();

                $transacciones =  DB::table('transacciones_requerimientos')
                    ->where('idReq','=', $id)
                    ->get();

                $archivos = DB::table('adjuntos_requerimientos')
                    ->where('idRequerimiento','=', $id)
                    ->get();


                if (Auth::user()->hasPermissionTo('aplicaciones.requerimientos.vendedor')){
                    $propuestas = DB::table('propuestas_requerimientos')
                        ->where('idRequerimiento','=', $id)
                        ->where('estado', '=', 5)
                        ->get();
                }
                else if (Auth::user()->hasPermissionTo('aplicaciones.requerimientos.disenador')){
                    $propuestas = DB::table('propuestas_requerimientos')
                        ->where('idRequerimiento','=', $id)
                        ->where('estado', '!=', 5)
                        ->get();
                }
                else if(Auth::user()->hasPermissionTo('aplicaciones.requerimientos.render')){
                    $propuestas = DB::table('propuestas_requerimientos')
                        ->where('idRequerimiento','=', $id)
                        ->where('estado', '=', 4)
                        ->get();
                }
                else if(Auth::user()->hasPermissionTo('aplicaciones.requerimientos.plano')){
                    $propuestas = DB::table('propuestas_requerimientos')
                        ->where('idRequerimiento','=', $id)
                        ->where('estado', '=', 3)
                        ->get();
                }
                else if (Auth::user()->hasRole('super-admin')){
                    $propuestas = DB::table('propuestas_requerimientos')
                        ->where('idRequerimiento','=', $id)
                        ->get();
                }

                return view('aplicaciones.requerimientos.dashboard.show',
                    compact('data', 'transacciones', 'archivos', 'propuestas'));

            }catch (\Exception $e){
                return redirect()
                    ->back()
                    ->with([
                        'message'    => $e->getMessage(),
                        'alert-type' => 'error'
                    ]);
            }
        }else{
            return redirect()
                ->back()
                ->with([
                    'message'    => 'Solo puedes ver la informacion de tus requerimientos!',
                    'alert-type' => 'error'
                ]);
        }

    }
}

