<?php

namespace App\Http\Controllers\Requerimientos;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TransactionController extends Controller
{
    public function eliminar_archivo(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                File::delete('requerimientos/'.'RQ-'.$request->req_id.'/soportes/'.$request->file);

                DB::table('adjuntos_requerimientos')
                    ->where('idRequerimiento','=',$request->req_id)
                    ->where('archivo','=',$request->file)
                    ->delete();

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $request->req_id,
                        'tipo'          =>  'Adjuntos',
                        'descripcion'   =>  'Elimino un archivo del requerimiento # '.$request->req_id.' - Detalles:'.$request->coments,
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::commit();
                return response()->json('Archivo eliminado con exito!', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function subir_archivos_soporte(Request $request){
        if ($request->hasFile('fileToUpload')) {
            if (Auth::user()->can('requerimientos.supervisor_diseno') || Auth::user()->can('aplicaciones.requerimientos.vendedor')){
                DB::beginTransaction();
                try {
                    $files = $request->file('fileToUpload');
                    foreach ($files as $file){
                        $destinationPath = 'requerimientos/'.'RQ-'.$request->req_id.'/soportes/';
                        $profilefile = 'RQ-'.$request->req_id.'_SP-'.rand(100,999).'.'.$file->getClientOriginalExtension(); /*$files->getClientOriginalName()*/;
                        $file->move($destinationPath, $profilefile);
                        $insert['fileToUpload'] = "$profilefile";


                        DB::table('adjuntos_requerimientos')
                            ->insert([
                                'idRequerimiento'   =>  $request->req_id,
                                'archivo'           =>  $profilefile,
                                'url'               =>  $destinationPath,
                                'usuario_id'        =>  Auth::user()->id,
                                'created_at'        =>  Carbon::now(),
                                'updated_at'        =>  Carbon::now()
                            ]);

                    }
                    DB::table('transacciones_requerimientos')
                        ->insert([
                            'idReq'         =>  $request->req_id,
                            'tipo'          =>  'Adjuntos',
                            'descripcion'   =>  'Se agregaron archivos de soporte',
                            'usuario_id'    =>  Auth::user()->id,
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);

                    DB::commit();

                    return response()->json('Archivo(s) guardado(s) con exito!', 200);
                }catch (\Exception $e){
                    DB::rollBack();
                    return response()->json($e->getMessage(), 500);
                }
            }else{
                return response()->json('No tiene permisos suficientes para realizar esta accion', 500);
            }
        }
    }


    public  function enviar_render(Request $request){
        if ($request->ajax()){
            try {
                $estado = DB::table('propuestas_requerimientos')
                    ->where('id','=',$request->prop_id)
                    ->pluck('estado')->first();

                if ($estado == 4){
                    return response()
                        ->json('Esta propuesta ya se encuentra en renderizado!',
                            500);
                }
                elseif ($estado == 2){
                    DB::table('propuestas_requerimientos')
                        ->where('id','=',$request->prop_id)
                        ->update([
                            'estado'    =>  4
                        ]);


                    DB::table('transacciones_requerimientos')
                        ->insert([
                            'idReq'         =>  $request->req_id,
                            'tipo'          =>  'Transaccion',
                            'descripcion'   =>  'Se envia la propuesta '.$request->prop_id.' a renderizar',
                            'usuario_id'    =>  Auth::user()->id,
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);

                    return response()->json('Propuesta enviada a render', 200);
                }
                else{
                    return response()
                        ->json('Solo se pueden enviar a render propuestas iniciadas',
                            500);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function solicitar_plano(Request $request){
        if($request->ajax()){
            try{
                $estado = DB::table('propuestas_requerimientos')
                    ->where('id','=',$request->prop_id)
                    ->pluck('estado')->first();

                if ($estado == 3){
                    return response()
                        ->json('Esta propuesta ya se encuentra en solicitud de planos!',
                            500);
                }
                elseif ($estado == 2) {
                    DB::table('propuestas_requerimientos')
                        ->where('id', '=', $request->prop_id)
                        ->update([
                            'estado' => 3
                        ]);


                    DB::table('transacciones_requerimientos')
                        ->insert([
                            'idReq' => $request->req_id,
                            'tipo' => 'Transaccion',
                            'descripcion' => 'Se envia la propuesta ' . $request->prop_id . ' a planos',
                            'usuario_id' => Auth::user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]);
                    return response()->json('Propuesta enviada a planos', 200);
                }else{
                    return response()
                        ->json('No puedes solicitar plano en este momento, intenta de nuevo mas tarde!',
                            500);
                }

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function cambiar_estado(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('encabezado_requerimientos')
                    ->where('id','=',$request->req_id)
                    ->update([
                        'estado' => $request->result['value'][0]['estado_req']
                ]);

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         => $request->req_id,
                        'tipo'          => 'Cambio de estado',
                        'descripcion'   => 'Cambio el estado del requerimiento, Justificacion: '.$request->result['value'][0]['justificacion'],
                        'usuario_id'    => Auth::user()->id,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                ]);
                DB::commit();
                return response()->json('Requerimiento actualizado', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function anular(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $req = DB::table('encabezado_requerimientos')
                    ->where('id','=', $request->req_id)
                    ->pluck('estado')->first();

                if ($req == 3){
                    return response()
                        ->json('No se puede anular un requerimiento si ya fue iniciado, por favor comuniquese con el area de diseño', 500);

                }else if ($req == 0){
                    return response()
                        ->json('Este requerimiento ya fue anulado', 500);

                }else{
                    DB::table('encabezado_requerimientos')
                        ->where('id','=', $request->req_id)
                        ->update([
                            'estado' => 0
                        ]);

                    DB::table('transacciones_requerimientos')
                        ->insert([
                            'idReq'         => $request->req_id,
                            'tipo'          => 'Anular',
                            'descripcion'   => 'Anulo el requerimiento.',
                            'usuario_id'    => Auth::user()->id,
                            'created_at'    => Carbon::now(),
                            'updated_at'    => Carbon::now()
                        ]);
                    DB::commit();
                    return response()->json('Requerimiento anulado', 200);
                }
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function finalizar(Request $request){
        /*tengo que hacer esta logica , funcion para crear arte y enviar a cnc*/
    }


    public function listar_disenadores(Request $request){
        if ($request->ajax()){
            try {
                $values = DB::table('users')
                    ->whereIn('app_roll', ['diseñador','super_diseno'])
                    ->select('name','id')
                    ->get();

                $Array = [];

                foreach ($values as $value){
                    $Array[$value->id] = $value->name;
                }
                return response()->json($Array, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function cambiar_disenador(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $estado = DB::table('encabezado_requerimientos')
                    ->where('id','=',$request->req_id)
                    ->pluck('estado')
                    ->first();

                if ($estado == 1) {
                    DB::table('encabezado_requerimientos')
                        ->where('id', '=', $request->req_id)
                        ->update([
                            'diseñador_id' => $request->result['value'],
                            'estado' => '2'
                    ]);
                }else{
                    DB::table('encabezado_requerimientos')
                        ->where('id', '=', $request->req_id)
                        ->update([
                            'diseñador_id' => $request->result['value'],
                    ]);
                }

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         => $request->req_id,
                        'tipo'          => 'Cambio de diseñador',
                        'descripcion'   => 'Cambio/Asigno el diseñador',
                        'usuario_id'    => Auth::user()->id,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                ]);

                DB::commit();
                return response()->json('Diseñador cambiado', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function enviar_diseno(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('propuestas_requerimientos')
                    ->where('id', '=', $request->prop_id)
                    ->update([
                        'estado' => 2
                    ]);


                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq' => $request->req_id,
                        'tipo' => 'Transaccion',
                        'descripcion' => 'Se envia la propuesta ' . $request->prop_id . ' a diseño',
                        'usuario_id' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                DB::commit();
                return response()->json('Propuesta enviada a diseño', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public  function agregar_comentario(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         => $request->req_id,
                        'tipo'          => 'Comentario',
                        'descripcion'   => $request->coments,
                        'usuario_id'    => Auth::user()->id,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                ]);

                DB::commit();
                return response()->json('comentario agregado con exito', 200);
            }catch (\Exception $e){
                DB::rollBack();
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
                        'codigo'    => substr($q->codigo,0, 6),
                        'id'        => $q->id
                    ];
                }
                return response()->json($results, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function agregar_propuesta(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $encabezado = DB::table('encabezado_requerimientos')
                    ->where('id','=', $request->req_id)
                    ->select('diseñador_id','estado')
                    ->first();


                DB::table('propuestas_requerimientos')
                    ->insert([
                        'idRequerimiento'   =>  $request->req_id,
                        'articulo'          =>  $request->result['value'][0]['producto_id'],
                        'codigo_base'       =>  $request->result['value'][0]['producto_cod'],
                        'relieve'           =>  $request->result['value'][0]['relieve'],
                        'medida'            =>  $request->medida,
                        'usuario_id'        =>  Auth::user()->id,
                        'diseñador_id'      =>  Auth::user()->id,
                        'estado'            =>  1,
                        'created_at'        =>  Carbon::now(),
                        'updated_at'        =>  Carbon::now()
                ]);


                if ($encabezado->estado == 2) {
                    DB::table('encabezado_requerimientos')
                        ->where('id', '=', $request->req_id)
                        ->update([
                            'estado' => 3
                        ]);
                }


                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $request->req_id,
                        'tipo'          =>  'Nueva propuesta',
                        'descripcion'   =>  'Creo una propuesta',
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::commit();
                return response()->json('propuesta creada con exito!', 200);
            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function descargar_archivo_soporte($id, $file){
        $file_path = public_path()."/requerimientos/RQ-".$id."/soportes/".$file;
        $headers = array(
            'Content-Disposition: attachment; filename='.$file,
        );
        if ( file_exists( $file_path ) ) {
            DB::table('transacciones_requerimientos')
                ->insert([
                    'idReq'         =>  $id,
                    'tipo'          =>  'Descarga',
                    'descripcion'   =>  'Descargo el archivo '.$file,
                    'usuario_id'    =>  Auth::user()->id,
                    'created_at'    =>  Carbon::now(),
                    'updated_at'    =>  Carbon::now()
                ]);

            return response()->download($file_path, $file, $headers);
        } else {
            return redirect()
                ->route('ventas.show', $id)
                ->with([
                    'message'    => 'El archivo solicitado no existe en el servidor.',
                    'alert-type' => 'error'
                ]);
        }
    }


    public function obtener_datos_propuesta(Request $request){
        if ($request->ajax()){
            try {
                $propuesta = DB::table('propuestas_requerimientos')
                    ->leftJoin('cod_codigos','propuestas_requerimientos.articulo','=','cod_codigos.id')
                    ->select('propuestas_requerimientos.id','propuestas_requerimientos.medida','propuestas_requerimientos.relieve',
                        'cod_codigos.descripcion as articulo','propuestas_requerimientos.caracteristicas', 'propuestas_requerimientos.created_at as fecha')
                    ->where('propuestas_requerimientos.id','=', $request->id)
                    ->first();

                $archivos = DB::table('adjuntos_propuestas_requerimientos')
                    ->where('idPropuesta','=', $request->id)
                    ->get();

                return response()->json([
                    'propuesta'     => $propuesta,
                    'archivos'      => $archivos,
                ], 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function subir_archivo_2d(Request $request){
        if ($request->ajax()){
            if ($request->hasFile('fileToUpload')) {
                DB::beginTransaction();
                try {
                    $files = $request->file('fileToUpload');
                    $destinationPath = public_path().'/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/2D/';
                    $profilefile = $request->prop_id.'.'.$files->getClientOriginalExtension();
                    $files->move($destinationPath, $profilefile);
                    $insert['fileToUpload'] = "$profilefile";

                    DB::table('adjuntos_propuestas_requerimientos')
                        ->updateOrInsert(['url'  =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/2D/'], [
                            'idRequerimiento'   =>  $request->req_id,
                            'idPropuesta'       =>  $request->prop_id,
                            'archivo'           =>  $profilefile,
                            'url'               =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/2D/',
                            'usuario_id'        =>  Auth::user()->id,
                            'tipo'              =>  '2D',
                            'created_at'        =>  Carbon::now(),
                            'updated_at'        =>  Carbon::now()
                        ]);

                    DB::table('transacciones_requerimientos')
                        ->Insert([
                            'idReq'         =>  $request->req_id,
                            'tipo'          =>  'Adjuntos',
                            'descripcion'   =>  'Adjunto un archivo 2D a la propuesta '.$request->prop_id,
                            'usuario_id'    =>  Auth::user()->id,
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);

                    DB::table('propuestas_requerimientos')
                        ->where('id', '=', $request->prop_id)
                        ->update([
                           'estado' => 2
                        ]);

                    DB::commit();
                    return response()
                        ->json([
                            'url' => '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/2D/',
                            'archivo' => $profilefile],
                            200);

                }catch (\Exception $e){
                    DB::rollBack();
                    return response()->json($e->getMessage(), 500);
                }
            }
        }
    }


    public function subir_archivo_3d(Request $request){
        if ($request->ajax()){
            if ($request->hasFile('fileToUpload')) {
                DB::beginTransaction();
                try {
                    $files = $request->file('fileToUpload');
                    $destinationPath = public_path().'/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/3D/';
                    $profilefile = $request->prop_id.'.'.$files->getClientOriginalExtension();
                    $files->move($destinationPath, $profilefile);
                    $insert['fileToUpload'] = "$profilefile";

                    DB::table('adjuntos_propuestas_requerimientos')
                        ->updateOrInsert(['url'  =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/3D/'], [
                            'idRequerimiento'   =>  $request->req_id,
                            'idPropuesta'       =>  $request->prop_id,
                            'archivo'           =>  $profilefile,
                            'url'               =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/3D/',
                            'usuario_id'        =>  Auth::user()->id,
                            'tipo'              =>  '3D',
                            'created_at'        =>  Carbon::now(),
                            'updated_at'        =>  Carbon::now()
                        ]);

                    DB::table('transacciones_requerimientos')
                        ->Insert([
                            'idReq'         =>  $request->req_id,
                            'tipo'          =>  'Adjuntos',
                            'descripcion'   =>  'Adjunto un archivo 3D a la propuesta '.$request->prop_id,
                            'usuario_id'    =>  Auth::user()->id,
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);

                    DB::commit();
                    return response()
                        ->json([
                            'url' => '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/3D/',
                            'archivo' => $profilefile],
                            200);

                }catch (\Exception $e){
                    DB::rollBack();
                    return response()->json($e->getMessage(), 500);
                }
            }
        }
    }


    public function subir_archivo_plano(Request $request){
        if ($request->ajax()){
            if ($request->hasFile('fileToUpload')) {
                DB::beginTransaction();
                try {
                    $files = $request->file('fileToUpload');
                    $destinationPath = public_path().'/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/plano/';
                    $profilefile = $request->prop_id.'.'.$files->getClientOriginalExtension();
                    $files->move($destinationPath, $profilefile);
                    $insert['fileToUpload'] = "$profilefile";

                    DB::table('adjuntos_propuestas_requerimientos')
                        ->updateOrInsert(['url'  =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/plano/'], [
                            'idRequerimiento'   =>  $request->req_id,
                            'idPropuesta'       =>  $request->prop_id,
                            'archivo'           =>  $profilefile,
                            'url'               =>  '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/plano/',
                            'usuario_id'        =>  Auth::user()->id,
                            'tipo'              =>  'plano',
                            'created_at'        =>  Carbon::now(),
                            'updated_at'        =>  Carbon::now()
                        ]);

                    DB::table('transacciones_requerimientos')
                        ->Insert([
                            'idReq'         =>  $request->req_id,
                            'tipo'          =>  'Adjuntos',
                            'descripcion'   =>  'agrego un archivo plano a la propuesta '.$request->prop_id,
                            'usuario_id'    =>  Auth::user()->id,
                            'created_at'    =>  Carbon::now(),
                            'updated_at'    =>  Carbon::now()
                        ]);

                    DB::commit();
                    return response()
                        ->json([
                            'url' => '/requerimientos/'.'RQ-'.$request->req_id.'/propuestas/'.'PP-'.$request->prop_id.'/plano/',
                            'archivo' => $profilefile],
                            200);

                }catch (\Exception $e){
                    DB::rollBack();
                    return response()->json($e->getMessage(), 500);
                }
            }
        }
    }


    public function agregar_comentario_propuesta(Request $request){
        if ($request->ajax()){
            try {
                DB::table('propuestas_requerimientos')
                    ->where('id','=',$request->prop_id)
                    ->update([
                        'caracteristicas'   =>  $request->coments
                ]);
                return response()->json($request->coments, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function aprobar_propuesta(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('propuestas_requerimientos')
                    ->where('idRequerimiento','=', $request->req_id)
                    ->where('id','=',$request->prop_id)
                    ->update([
                        'estado' => 6
                    ]);

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $request->req_id,
                        'tipo'          =>  'Propuesta',
                        'descripcion'   =>  'Aprobo la propuesta '.$request->prop_id,
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::commit();
                return response()->json('Propuesta aprobada con exito!', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function rechazar_propuesta(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                DB::table('propuestas_requerimientos')
                    ->where('idRequerimiento','=', $request->req_id)
                    ->where('id','=',$request->prop_id)
                    ->update([
                        'estado' => 7
                    ]);

                DB::table('transacciones_requerimientos')
                    ->insert([
                        'idReq'         =>  $request->req_id,
                        'tipo'          =>  'Propuesta',
                        'descripcion'   =>  'Rechazo la propuesta '.$request->prop_id.' MOTIVO: '. $request->coments,
                        'usuario_id'    =>  Auth::user()->id,
                        'created_at'    =>  Carbon::now(),
                        'updated_at'    =>  Carbon::now()
                ]);

                DB::commit();
                return response()->json('propuesta rechazada', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function enviar_aprobar_propuesta(Request $request){
        if ($request->ajax()){
            try {
                $estado = DB::table('propuestas_requerimientos')
                    ->where('id','=',$request->prop_id)
                    ->pluck('estado')->first();

                if ($estado != 2){
                    return response()->json('Esta propuesta no puede ser enviada al vendedor', 500);
                }else{
                    DB::table('propuestas_requerimientos')
                        ->where('id', '=', $request->prop_id)
                        ->update([
                            'estado' => 5
                        ]);

                    return response()->json('Propuesta enviada con exito!', 200);
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function comprobar_estado_propuesta(Request $request){
        if ($request->ajax()){
            try {
                $result =  DB::table('propuestas_requerimientos')
                    ->where('id','=', $request->prop_id)
                    ->pluck('estado')->first();


                $requerimiento = DB::table('encabezado_requerimientos')
                    ->where('id','=',$request->req_id)
                    ->first();


                $lista_artes = DB::table('artes')
                    ->where('marca_id','=',$requerimiento->marca_id)
                    ->pluck('codigo');


                $letra_marca = DB::table('marcas')
                    ->where('id', '=', $requerimiento->marca_id)
                    ->pluck('name')
                    ->first();

                $letra_marca = substr($letra_marca, 0,1);


                return response()
                    ->json([
                        'estado'        => $result,
                        'lista_artes'   => $lista_artes,
                        'ultimo_arte'   => $lista_artes[(sizeof($lista_artes)-1)] ?? '',
                        'letra_marca'   => $letra_marca
                        ], 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function finalizar_propuesta(Request $request){
        if ($request->ajax()){
            DB::beginTransaction();
            try {
                $requerimiento = DB::table('encabezado_requerimientos')
                    ->where('id','=',$request->req_id)
                    ->first();

                $propuesta = DB::table('propuestas_requerimientos')
                    ->where('id','=', $request->prop_id)
                    ->first();

                $archivo_2d = DB::table('adjuntos_propuestas_requerimientos')
                    ->where('idPropuesta','=',$request->prop_id)
                    ->where('tipo', '=', '2D')
                    ->get(['url','archivo'])
                    ->first();

                $archivo_3d = DB::table('adjuntos_propuestas_requerimientos')
                    ->where('idPropuesta','=',$request->prop_id)
                    ->where('tipo', '=', '3D')
                    ->get(['url','archivo'])
                    ->first();

                $archivo_plano = DB::table('adjuntos_propuestas_requerimientos')
                    ->where('idPropuesta','=',$request->prop_id)
                    ->where('tipo', '=', 'plano')
                    ->get(['url','archivo'])
                    ->first();


                $id_arte = DB::table('artes')
                    ->insertGetId([
                        'codigo'                => $request->codigo_arte,
                        'marca_id'              => $requerimiento->marca_id,
                        'producto_id'           => $propuesta->articulo,
                        'caracteristicas'       => $propuesta->caracteristicas,
                        '2d'                    => ($archivo_2d->url ?? '').($archivo_2d->archivo ?? ''),
                        '3d'                    => ($archivo_3d->url ?? '').($archivo_3d->archivo ?? ''),
                        'plano'                 => ($archivo_plano->url ?? '').($archivo_plano->archivo ?? ''),
                        'diseñador_id'          => $requerimiento->diseñador_id,
                        'vendedor_id'           => $requerimiento->vendedor_id,
                        'propuesta_id'          => $request->prop_id,
                        'created_at'            => Carbon::now(),
                        'updated_at'            => Carbon::now(),
                ]);


                /*Guardar producto*/

                $descripcion_producto = DB::table('cod_codigos')
                    ->where('id','=',$propuesta->articulo)
                    ->pluck('descripcion')
                    ->first();


                $descripcion_producto = explode(' ',$descripcion_producto);
                $idx = array_key_last($descripcion_producto);
                $descripcion_producto[$idx] = $propuesta->medida;
                $descripcion_producto_string = implode(" ",$descripcion_producto);


                $medida_id = DB::table('cod_medidas')
                    ->where('denominacion','=',$propuesta->medida)
                    ->pluck('id')
                    ->first();

                $producto_base = DB::table('cod_codigos')
                    ->where('id','=',$propuesta->articulo)
                    ->first();

                $codigos = DB::table('cod_codigos')
                    ->where('codigo','like', substr($producto_base->codigo,0,6).'%')
                    ->pluck('codigo');


                $array = [];
                foreach ($codigos as $codigo){
                    $array [] = substr($codigo,6,5);
                }
                $result = max($array);
                $result = $result+1;
                $result = str_pad($result,4,"0",STR_PAD_LEFT);
                $result = substr($producto_base->codigo,0,6).$result;


                DB::table('cod_codigos')->insert([
                    'codigo'                    =>  $result,
                    'coments'                   =>  '',
                    'descripcion'               =>  $descripcion_producto_string.' '.$request->codigo_arte,
                    'usuario'                   =>  Auth::user()->id,
                    'usuario_aprobo'            =>  $requerimiento->vendedor_id,
                    'arte'                      =>  $id_arte,
                    'estado'                    =>  '1',
                    'area'                      =>  '',
                    'costo_base'                =>  '',
                    'generico'                  =>  '1',
                    'created_at'                =>  Carbon::now(),
                    'updated_at'                =>  Carbon::now(),
                    'cod_tipo_producto_id'      =>  $producto_base->cod_tipo_producto_id,
                    'cod_lineas_id'             =>  $producto_base->cod_lineas_id,
                    'cod_sublineas_id'          =>  $producto_base->cod_sublineas_id,
                    'cod_medidas_id'            =>  $medida_id,
                    'cod_caracteristicas_id'    =>  $producto_base->cod_caracteristicas_id,
                    'cod_materials_id'          =>  $producto_base->cod_materials_id
                ]);



                DB::table('propuestas_requerimientos')
                    ->where('id', '=', $request->prop_id)
                    ->update([
                        'estado' => 9
                    ]);


                DB::commit();
                return  response()->json('Propuesta finalizada con exito!', 200);

            }catch (\Exception $e){
                DB::rollBack();
                return response()->json($e->getMessage(), 500);
            }
        }
    }


}
