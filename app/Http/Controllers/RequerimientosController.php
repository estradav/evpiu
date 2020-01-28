<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;


class RequerimientosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->estado != null) {
                $data = DB::table('encabezado_requerimientos')
                    ->leftJoin('users','encabezado_requerimientos.diseñador_id','=','users.id')
                    ->select('users.name as diseñador_id',
                        'encabezado_requerimientos.id',
                        'encabezado_requerimientos.producto',
                        'encabezado_requerimientos.informacion',
                        'encabezado_requerimientos.usuario_id',
                        'encabezado_requerimientos.marca',
                        'encabezado_requerimientos.estado',
                        'encabezado_requerimientos.created_at',
                        'encabezado_requerimientos.updated_at')
                    ->where('estado', '=', $request->estado)
                    ->orderBy('estado', 'desc')
                    ->get();
                return Datatables::of($data)
                    ->addColumn('opciones', function ($row) {
                        $btn = '<div class="btn-group ml-auto">'.'<a href="/Requerimientoss/'.$row->id.'/edit" class="btn btn-sm btn-outline-light" id="ver"><i class="fas fa-file-signature"></i> Ver</a>'.'</div>';
                        return $btn;
                    })
                    ->rawColumns(['opciones'])
                    ->make(true);
            }
        }
        return view('Requerimientos.Requerimiento');
    }

    public function SearchMarcas(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::table('marcas')
            ->where('name', 'LIKE', '%'.$query.'%')
            ->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value' =>  $q->name,
                'id'    => $q->id
            ];
        }
        return response()->json($results);
    }

    public function SearchProductsMax(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::table('cod_codigos')
            ->where('descripcion', 'LIKE', '%'.$query.'%')
            ->orWhere('codigo', 'LIKE', '%'.$query.'0000')->take(10)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value'     => trim($q->descripcion),
                'Cod_Art'   => substr($q->codigo,0, 6),
                'id'        => $q->id
            ];
        }
        return response()->json($results);
    }

    public function getlineas(Request $request)
    {
        if ($request->ajax()){
            $getlineas = DB::table('cod_lineas')->get();
            foreach ($getlineas as $linea){
                $getlineasArray[$linea->id] = $linea->name;
            }
            return response()->json($getlineasArray);
        }
    }

    public function getsublineas(Request $request)
    {
        if ($request->ajax()){
            $getsublineas = DB::table('cod_sublineas')
                ->where('lineas_id','=',$request->lineas_id)
                ->get();
            foreach ($getsublineas as $sblinea){
                $getsublineasArray[$sblinea->id] = $sblinea->name;
            }
            return response()->json($getsublineasArray);
        }
    }

    public function GetDescription(Request $request){
        $linea = DB::table('cod_lineas')->where('id','=',$request->linea)->select('abreviatura')->get();
        $sublinea = DB::table('cod_sublineas')->where('id','=',$request->sublinea)->select('abreviatura')->get();
        $caracteristica = DB::table('cod_caracteristicas')->where('id','=',$request->caracteristica)->select('abreviatura')->get();
        $material = DB::table('cod_materials')->where('id','=',$request->material)->select('abreviatura')->get();
        $medida = DB::table('cod_medidas')->where('id','=',$request->medida)->select('denominacion')->get();

        $data = $linea[0]->abreviatura.' '.$sublinea[0]->abreviatura.' '.$caracteristica[0]->abreviatura.' '.$material[0]->abreviatura.' '.$medida[0]->denominacion;

        return response()->json($data);
    }

    public function NewRequerimiento(Request $request)
    {
        $requerimiento = DB::table('encabezado_requerimientos')->insertGetId([
            'producto'      => $request->Producto,
            'informacion'   => $request->Informacion,
            'vendedor_id'   => $request->Vendedor,
            'cliente'       => $request->Cliente,
            'marca'         => $request->Marca,
            'medida'        => $request->Medida,
            'render'        => $request->Render,
            'usuario_id'    => $request->Creado,
            'estado'        => '2',
            'created_at'    => Carbon::now(),
            'Updated_at'    => Carbon::now(),
        ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $requerimiento,
            'tipo'          => 'Nuevo Requerimiento',
            'descripcion'   => 'Creo un nuevo requerimiento',
            'usuario_id'    => $request->Creado,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $requerimiento,
            'tipo'          =>  'Cambio de estado',
            'descripcion'   =>  'Requerimiento enviado para revision.',
            'usuario_id'    =>  $request->Creado,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);

        return response()->json(['ok' => 'ok']);
    }

    public function MisRequerimientos(Request $request)
    {
        if ($request->ajax()){
            $data =  DB::table('encabezado_requerimientos')
                ->leftJoin('users','encabezado_requerimientos.diseñador_id','=','users.id')
                ->leftJoin('users as usr','encabezado_requerimientos.vendedor_id','=','usr.id')
                ->leftJoin('cod_codigos','encabezado_requerimientos.producto','=','cod_codigos.id')
                ->where('usuario_id','=',$request->Username)
                ->select('encabezado_requerimientos.id',
                    'cod_codigos.descripcion as producto',
                    'encabezado_requerimientos.informacion',
                    'encabezado_requerimientos.marca',
                    'encabezado_requerimientos.estado',
                    'encabezado_requerimientos.created_at',
                    'encabezado_requerimientos.updated_at',
                    'users.name','usr.name as usuario_id')
                ->orderBy('estado', 'desc')
                ->get();
            return Datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto">'.'<a href="/Requerimientoss/' . $row->id . '/edit" class="btn btn-sm btn-outline-light" id="ver"><i class="fas fa-file-signature"></i> Ver</a>' . '</div>';
                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('Requerimientos.mis_requerimientos');
    }

    public function MisRequerimientosAddComent(Request $request)
    {
        DB::table('transacciones_requerimientos')->insert([
            'idReq'         => $request->idReq,
            'tipo'          => 'Comentario',
            'descripcion'   => $request->coments,
            'usuario_id'    => $request->user,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }

    public function MisRequerimientosAnular(Request $request)
    {
        DB::table('encabezado_requerimientos')->where('id','=',$request->id)->update([
            'estado'        => '0'
        ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         => $request->id,
            'tipo'          => 'Anular',
            'descripcion'   => 'El Usuario '.$request->Username.' anulo el requerimiento.',
            'usuario_id'    => $request->Username_id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }

    public function RequerimientosComentariosDetalles(Request $request)
    {
        $encabezado = DB::table('encabezado_requerimientos')
            ->leftJoin('users','encabezado_requerimientos.diseñador_id','=','users.id')
            ->leftJoin('users as vendor','encabezado_requerimientos.vendedor_id','=','users.id')
            ->leftJoin('marcas','encabezado_requerimientos.marca','=','marcas.id')
            ->leftJoin('cod_codigos','encabezado_requerimientos.producto','=','cod_codigos.id')


            ->select('marcas.name as marca',
                'encabezado_requerimientos.usuario_id as usuario',
                'encabezado_requerimientos.estado as estado',
                'vendor.name as vendedor_id',
                'encabezado_requerimientos.informacion as informacion',
                'users.name as diseñador_id',
                'encabezado_requerimientos.created_at as created_at',
                'cod_codigos.descripcion as producto',
                'encabezado_requerimientos.cliente as cliente')
            ->where('encabezado_requerimientos.id','=',$request->id)
            ->get();

        $idDiseñador = DB::table('encabezado_requerimientos')
            ->where('encabezado_requerimientos.id','=',$request->id)
            ->select('diseñador_id','vendedor_id')
            ->get();

        $disenador_id = null;
        if ($idDiseñador[0]->diseñador_id == null){
            $disenador_id = null;
        }else{
            $disenador_id = DB::table('users')->where('id','=',$idDiseñador[0]->diseñador_id)->get();
        }

        $vendedor_id  = DB::table('users')->where('id','=',$idDiseñador[0]->vendedor_id)->get();

        $datos = DB::table('transacciones_requerimientos')
            ->leftJoin('users','transacciones_requerimientos.usuario_id','=','users.id')
            ->where('idReq','=',$request->id)
            ->get();

        $propuestasReq = DB::table('propuestas_requerimientos')->where('idRequerimiento','=',$request->id)->get();

        return response()->json([
            'Datos'         => $datos,
            'encabezado'    => $encabezado,
            'propuestas'    => $propuestasReq,
            'vendedor_id'   => $vendedor_id,
            'diseñador_id'  => $disenador_id
        ]);
    }

    public function VerRequerimiento($numero)
    {
        $var = $numero;
        return view('Requerimientos.ficha_tecnica', ["var" => $var] );
    }

    public function CambiarEstadoRequeEd(Request $request)
    {
        DB::table('encabezado_requerimientos')->where('id','=',$request->id)->update([
            'estado' => $request->result['value'][0]['state']
        ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         => $request->id,
            'tipo'          => 'Cambio de estado',
            'descripcion'   => 'Cambio el estado del requerimiento, Justificacion: '.$request->result['value'][0]['justify'],
            'usuario_id'    => $request->Username_id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }

    public function ObtenerDiseñadores(Request $request)
    {
        $valores = DB::table('users')
            ->where('app_roll','=', 'diseñador')
            ->select('name','id')->get();

        $Array = [];
        foreach ($valores as $val){
            $Array[$val->id] = $val->name;
        }

        return response()->json($Array);
    }

    public function CambiarDiseñadorRequeEd(Request $request)
    {
        $Estado = DB::table('encabezado_requerimientos')->where('id','=',$request->id)->select('estado')->get();

        if ($Estado[0]->estado == 2) {
            DB::table('encabezado_requerimientos')->where('id', '=', $request->id)->update([
                'diseñador_id' => $request->result['value'],
                'estado' => '3'
            ]);
        }else{
            DB::table('encabezado_requerimientos')->where('id', '=', $request->id)->update([
                'diseñador_id' => $request->result['value'],
            ]);
        }

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         => $request->id,
            'tipo'          => 'Cambio de diseñador',
            'descripcion'   => 'Cambio el diseñador asignado al requerimiento.',
            'usuario_id'       => $request->Username_id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }

    public function GuardarPropuestaReq(Request $request)
    {
        $Dis_id = DB::table('encabezado_requerimientos')->where('id','=',$request->id)->select('diseñador_id')->get();
        DB::table('propuestas_requerimientos')->insert([
            'idRequerimiento'   =>  $request->id,
            'articulo'          =>  $request->New_reque_Producto,
            'codigo_base'       =>  $request->result['value'][0]['Cod_Art'],
            'relieve'           =>  $request->result['value'][0]['Relieve'],
            'medida'            =>  $request->medida,
            'usuario_id'        =>  $request->Username_id,
            'diseñador_id'      =>  $Dis_id[0]->diseñador_id,
            'estado'            =>  '1',
            'created_at'        =>  Carbon::now(),
            'updated_at'        =>  Carbon::now()
        ]);

        $Estado = DB::table('encabezado_requerimientos')->where('id','=',$request->id)->select('estado')->get();

        if ($Estado[0]->estado == 3) {
            DB::table('encabezado_requerimientos')->where('id', '=', $request->id)->update([
                'estado' => '4'
            ]);
        }


        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $request->id,
            'tipo'          =>  'Nueva propuesta',
            'descripcion'   =>  'Creo una nueva propuesta.',
            'usuario_id'    =>  $request->Username_id,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);
        /*$mail_vendedor =  DB::table('users')->where('name','=',$request->Nombre_vendedor)->select('name','email')->get();

        if ($mail_vendedor != null){
            $subject = "SE HA CREADO UNA NUEVA PROPUESTA";
            $for = $mail_vendedor[0]->email;
            Mail::send('mails.NewRequerimentMail',$request->all(), function($msj) use($subject,$for){
                $msj->from("dcorrea@estradavelasquez.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to($for);
                $msj->cc("dcorrea@estradavelasquez.com");
            });
        }else{
            return true;
        }*/

    }

    public function ListaPropuestaReq(Request $request)
    {
        $data = DB::table('propuestas_requerimientos')
            ->leftJoin('cod_codigos','propuestas_requerimientos.articulo','=','cod_codigos.id')
            ->select('propuestas_requerimientos.estado','propuestas_requerimientos.id','cod_codigos.descripcion',
                'propuestas_requerimientos.created_at','propuestas_requerimientos.relieve')
            ->where('idRequerimiento','=',$request->id)
            ->get();

        return DataTables::of($data)
        ->addColumn('opciones', function($row){
            $btn = '<div class="btn-group ml-auto" style="text-align: center !important;">'.'<button class="btn btn-light btn-sm VerPropuest" name="VerPropuest" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
            return $btn;
        })
        ->rawColumns(['opciones'])
        ->make(true);
    }

    public function Upload2DReq(Request $request)
    {
        if ($request->hasFile('fileToUpload')) {
            $files = $request->file('fileToUpload');
            $destinationPath = 'requerimientos/'.'RQ-'.$request->Numero.'/propuestas/'.'PP-'.$request->Prop.'/2D/';
            $profilefile = $request->Prop.'.'.$files->getClientOriginalExtension(); /*$files->getClientOriginalName()*/;
            $files->move($destinationPath, $profilefile);
            $insert['fileToUpload'] = "$profilefile";

            DB::table('adjuntos_propuestas_requerimientos')->updateOrInsert(['url'  =>  $destinationPath],[
                'idRequerimiento'   =>  $request->Numero,
                'idPropuesta'       =>  $request->Prop,
                'archivo'           =>  $profilefile,
                'url'               =>  $destinationPath,
                'usuario_id'        =>  $request->Usuario,
                'tipo'              =>  '2D',
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);
            DB::table('transacciones_requerimientos')->Insert([
                'idReq'         =>  $request->Numero,
                'tipo'          =>  'Adjuntos',
                'descripcion'   =>  'Adjunto un archivo 2D a la propuesta '.$request->Prop.' del requerimiento '.$request->Numero,
                'usuario_id'    =>  $request->Usuario,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);


        }


        return response()->json(['url' => $destinationPath , 'archivo' => $profilefile], 200);
    }

    public function Upload3DReq(Request $request)
    {
        if ($request->hasFile('fileToUpload')) {
            $files = $request->file('fileToUpload');
            $destinationPath = 'requerimientos/'.'RQ-'.$request->Numero.'/propuestas/'.'PP-'.$request->Prop.'/3D/';
            $profilefile = $request->Prop.'.'.$files->getClientOriginalExtension(); /*$files->getClientOriginalName()*/;
            $files->move($destinationPath, $profilefile);
            $insert['fileToUpload'] = "$profilefile";

            DB::table('adjuntos_propuestas_requerimientos')->updateOrInsert(['url'  =>  $destinationPath], [
                'idRequerimiento'   =>  $request->Numero,
                'idPropuesta'       =>  $request->Prop,
                'archivo'           =>  $profilefile,
                'url'               =>  $destinationPath,
                'usuario_id'        =>  $request->Usuario,
                'tipo'              =>  '3D',
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);
            DB::table('transacciones_requerimientos')->insert([
                'idReq'         =>  $request->Numero,
                'tipo'          =>  'Adjuntos',
                'descripcion'   =>  'Adjunto un archivo 3D a la propuesta '.$request->Prop.' del requerimiento '.$request->Numero,
                'usuario_id'    =>  $request->Usuario,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);
        }
        return response()->json(['url' => $destinationPath , 'archivo' => $profilefile], 200);

    }

    public function UploadPlanoReq(Request $request)
    {
        if ($request->hasFile('fileToUpload')) {
            $files = $request->file('fileToUpload');
            $destinationPath = 'requerimientos/'.'RQ-'.$request->Numero.'/propuestas/'.'PP-'.$request->Prop.'/Plano/';
            $profilefile = $request->Prop.'.'.$files->getClientOriginalExtension(); /*$files->getClientOriginalName()*/;
            $files->move($destinationPath, $profilefile);
            $insert['fileToUpload'] = "$profilefile";

            DB::table('adjuntos_propuestas_requerimientos')->updateOrInsert(['url' => $destinationPath],[
                'idRequerimiento'   =>  $request->Numero,
                'idPropuesta'       =>  $request->Prop,
                'archivo'           =>  $profilefile,
                'url'               =>  $destinationPath,
                'usuario_id'        =>  $request->Usuario,
                'tipo'              =>  'plano',
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);
            DB::table('transacciones_requerimientos')->insert([
                'idReq'         =>  $request->Numero,
                'tipo'          =>  'Adjuntos',
                'descripcion'   =>  'Adjunto un archivo de plano a la propuesta '.$request->Prop.' del requerimiento '.$request->Numero,
                'usuario_id'    =>  $request->Usuario,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);
        }
        return response()->json(['url' => $destinationPath , 'archivo' => $profilefile], 200);
    }

    public function UploadfilesSupport(Request $request)
    {
        if ($request->hasFile('fileToUpload')) {
            $files = $request->file('fileToUpload');

            foreach ($files as $file){
                $destinationPath = 'requerimientos/'.'RQ-'.$request->Numero.'/soportes/';
                $profilefile = 'SP-'.rand(100,999).'.'.$file->getClientOriginalExtension(); /*$files->getClientOriginalName()*/;
                $file->move($destinationPath, $profilefile);
                $insert['fileToUpload'] = "$profilefile";

                DB::table('adjuntos_requerimientos')->insert([
                    'idRequerimiento'   =>  $request->Numero,
                    'archivo'           =>  $profilefile,
                    'url'               =>  $destinationPath,
                    'usuario_id'        =>  $request->Usuario,
                    'created_at'        =>  Carbon::now(),
                    'updated_at'        =>  Carbon::now()
                ]);
            }
            DB::table('transacciones_requerimientos')->insert([
                'idReq'         =>  $request->Numero,
                'tipo'          =>  'Adjuntos',
                'descripcion'   =>  'Adjunto archivos al requerimiento # '.$request->Numero,
                'usuario_id'    =>  $request->Usuario,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now()
            ]);
        }
        return response()->json(['result' => true], 200);
    }

    public function ImagesRequerimiento(Request $request)
    {
        $Archivos = DB::table('adjuntos_requerimientos')->where('idRequerimiento','=',$request->id)->get();

        return response()->json($Archivos);
    }

    public function DatosPropuestaPDF(Request $request)
    {
        $encabezado = DB::table('encabezado_requerimientos')
            ->leftJoin('users','encabezado_requerimientos.diseñador_id','=','users.id')
            ->leftJoin('users as vendor','encabezado_requerimientos.vendedor_id','=','users.id')
            ->leftJoin('cod_codigos','encabezado_requerimientos.producto','=','cod_codigos.id')
            ->leftJoin('marcas','encabezado_requerimientos.marca','=','marcas.id')
            ->select('marcas.name as marca',
                'encabezado_requerimientos.usuario_id as usuario',
                'encabezado_requerimientos.estado as estado',
                'vendor.name as vendedor_id',
                'encabezado_requerimientos.informacion as informacion',
                'users.name as diseñador_id',
                'encabezado_requerimientos.created_at as created_at',
                'cod_codigos.descripcion as producto',
                'encabezado_requerimientos.cliente as cliente')
            ->where('encabezado_requerimientos.id','=',$request->Req)
            ->get();


        $propuestasReq = DB::table('propuestas_requerimientos')
            ->leftJoin('cod_codigos','propuestas_requerimientos.articulo','=','cod_codigos.id')
            ->where('idRequerimiento','=',$request->Req)
            ->select('propuestas_requerimientos.id','propuestas_requerimientos.medida','propuestas_requerimientos.relieve',
                'cod_codigos.descripcion as articulo','propuestas_requerimientos.caracteristicas')
            ->where('propuestas_requerimientos.id','=',$request->Prop)
            ->get();


        $archivos = DB::table('adjuntos_propuestas_requerimientos')
            ->where('idPropuesta','=',$request->Prop)
            ->get();


        $idDiseñador = DB::table('encabezado_requerimientos')
            ->where('encabezado_requerimientos.id','=',$request->Req)
            ->select('diseñador_id','vendedor_id')->get();


        $diseñador_id = DB::table('users')->where('id','=',$idDiseñador[0]->diseñador_id)->get();


        $vendedor_id  = DB::table('users')->where('id','=',$idDiseñador[0]->vendedor_id)->get();


        return response()->json([
            'encabezado'    => $encabezado,
            'propuesta'     => $propuestasReq,
            'archivos'      => $archivos,
            'diseñador_id'  => $diseñador_id,
            'vendedor_id'   => $vendedor_id
        ]);
    }

    public function DeleteFileFromPropuesta(Request $request)
    {
        $destinationPath = 'requerimientos/'.'RQ-'.$request->idReq.'/soportes/';
        $profilefile = $request->file;
        File::delete($destinationPath.$profilefile);

        DB::table('adjuntos_requerimientos')
            ->where('idRequerimiento','=',$request->idReq)
            ->where('archivo','=',$request->file)->delete();

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $request->idReq,
            'tipo'          =>  'Adjuntos',
            'descripcion'   =>  'Elimino un archivo del requerimiento # '.$request->idReq.' - Detalles:'.$request->coments,
            'usuario'       =>  $request->user,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);

        return response()->json(['ok' => 'ok']);



        /*$subject = "SE LE HA ASIGNADO UN REQUERIMIENTO";
        $for = "dcorrea@estradavelasquez.com";
        Mail::send('mails.NewRequerimentMail',$request->all(), function($msj) use($subject,$for){
            $msj->from("dcorrea@estradavelasquez.com","Test EV-PIU");
            $msj->subject($subject);
            $msj->to($for);
        });*/
    }

    public function RechazarPropuesta(Request $request)
    {
        DB::table('propuestas_requerimientos')
            ->where('idRequerimiento','=', $request->id)
            ->where('id','=',$request->Prop)
            ->update([
                'estado' => '3'
        ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $request->id,
            'tipo'          =>  'Propuesta',
            'descripcion'   =>  'Rechazo la propuesta #'.$request->Prop.' del requerimiento #'. $request->id,
            'usuario'       =>  $request->Username,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);
    }

    public function AprobarPropuesta(Request $request)
    {
        DB::table('propuestas_requerimientos')
            ->where('idRequerimiento','=', $request->id)
            ->where('id','=',$request->Prop)
            ->update([
                'estado' => '4'
            ]);

        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $request->id,
            'tipo'          =>  'Propuesta',
            'descripcion'   =>  'Aprobo la propuesta #'.$request->Prop.' del requerimiento #'. $request->id,
            'usuario_id'    =>  $request->Username_id,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);
    }

    public function ValidarEstadoPropuestasFR(Request $request)
    {
        $count = DB::table('propuestas_requerimientos')
            ->where('idRequerimiento','=',$request->id)
            ->get()->count();

        $var = DB::table('propuestas_requerimientos')
            ->where('idRequerimiento','=',$request->id)
            ->where('estado','<>','3')
            ->where('estado','<>', '6')
            ->get()->count();

        return response()->json(['cant_prop' => $count, 'cant_prop_rec_apr' => $var]);
    }

    public function SaveMarca(Request $request)
    {
        DB::table('marcas')->insert([
           'name'           => $request->name,
           'comments'       => $request->comment,
           'type'           => $request->type,
           'created_by'     => $request->createdby,
            'created_at'    => Carbon::now(),
           'updated_at'     => Carbon::now(),
        ]);
        return response()->json(true);
    }

    public function UniqueMarca(Request $request)
    {
        $UniqueCod = DB::table('marcas')->where('name','=',$request->NewRequirementNewMarcaName)->count();
        if($UniqueCod == 0)
        {echo "true";}
        else
        {echo "false";}
    }

    public function EnviarRender(Request $request)
    {
        DB::table('encabezado_requerimientos')->where('id','=',$request->id)->update([
            'estado'    =>  '1'
        ]);
    }

    public function ComprobarRender(Request $request)
    {
        $var = DB::table('encabezado_requerimientos')
            ->where('id','=',$request->id)
            ->select('render','estado')->get();

        return response()->json($var);
    }

    public function ComprobarEstadoPropuesta(Request $request)
    {
        $var =  DB::table('propuestas_requerimientos')
            ->where('id','=', $request->Prop)
            ->select('estado')->get();

        return response()->json($var);
    }

    public function ObtenerMediasPorCodigoBase(Request $request)
    {
        $Codigo_Base = $request->Codigo_base_propuesta;

        $Linea = substr($Codigo_Base,1,2);
        $Sublinea = substr($Codigo_Base,3,2);

        $Linea = DB::table('cod_lineas')->where('cod','=',$Linea)->select('id')->get();
        $Sublinea = DB::table('cod_sublineas')->where('cod','=',$Sublinea)->select('id')->get();

        $Medidas =  DB::table('cod_medidas')
           ->where('med_lineas_id','=',$Linea[0]->id)
           ->where('med_sublineas_id','=',$Sublinea[0]->id)
           ->select('denominacion')
           ->get();

        $Array = [];
        foreach ($Medidas as $val){
            $Array[$val->denominacion] = $val->denominacion;
        }
        return response()->json($Array);
    }

    public function CambiarMedidaPropuesta(Request $request)
    {
        $Descripcion_Producto = $request->Descripcion_Producto;
        $Descripcion_Producto = explode(" ",$Descripcion_Producto);
        $indice = array_key_last($Descripcion_Producto);
        $Descripcion_Producto[$indice] = $request->result['value'];
        $Descripcion_Producto_String = implode(" ",$Descripcion_Producto);


        DB::table('propuestas_requerimientos')->where('id','=',$request->Prop)->update([
            'articulo'  => $Descripcion_Producto_String,
            'medida'    => $request->result['value']
        ]);

        $value = $request->result['value'];

        return response()->json(['medida' => $value, 'producto' =>  $Descripcion_Producto_String]);
    }

    public function EnviarAprobarPropuesta(Request $request)
    {

        DB::table('propuestas_requerimientos')
            ->where('id','=',$request->Prop)
            ->update([
                'estado' => '2'
            ]);



        /*$subject = "TIENE UNA PROPUESTA PENDIENTE POR APROBAR";
        $for = "dcorrea@estradavelasquez.com";
        Mail::send('mails.NewPropuestaMail',$request->all(), function($msj) use($subject,$for){
            $msj->from("dcorrea@estradavelasquez.com","Test EV-PIU");
            $msj->subject($subject);
            $msj->to($for);
        });*/
    }

    public function ObtenerUltimoArte(Request $request)
    {
        $value1 = DB::table('artes')->max('id');

        $value = DB::table('artes')->where('id','=',$value1)->select('codigo')->get();
        $Array =[];
        foreach ($value as $v) {
            $Array[] = $v->codigo;
        }

        return response()->json($Array);
    }

    public function ObtenerArtes(Request $request)
    {
        if ($request->ajax()) {
            $var = DB::table('artes')
                ->where('codigo','like',$request->Value_Marca.'%')
                ->select('codigo')
                ->get();
            $Array =[];
            foreach ($var as $v) {
                $Array[] = $v->codigo;
            }
            return response()->json($Array);
        }
    }

    public function FinalizaPropuesta(Request $request)
    {
        $Req = DB::table('encabezado_requerimientos')
            ->where('id','=',$request->id)
            ->get();

        $Prop = DB::table('propuestas_requerimientos')
            ->where('id','=', $request->Prop)
            ->get();

        $Arch_Plano = [];
        $Arch_3D = [];
        $Arch_2D = [];

        $Arch = DB::table('adjuntos_propuestas_requerimientos')
            ->where('idPropuesta','=',$request->Prop)
            ->get();

        foreach ($Arch as $Arc){
            if ($Arc->tipo == 'plano'){
                $Arch_Plano[] = $Arc;
            }
            if ($Arc->tipo == '3D'){
                $Arch_3D[] = $Arc;
            }
            if ($Arc->tipo == '2D'){
                $Arch_2D[] = $Arc;
            }
        }



        $descripcion_new_producto = DB::table('cod_codigos')
            ->where('id','=',$Prop[0]->articulo)
            ->pluck('descripcion');
        $descripcion_new_producto = explode(" ",$descripcion_new_producto);
        $i = array_key_last($descripcion_new_producto);
        $descripcion_new_producto[$i] = $Prop[0]->medida;
        $Descripcion_Producto_String = implode(" ",$descripcion_new_producto);


        $id_medida = DB::table('cod_medidas')
            ->where('denominacion','=',$Prop[0]->medida)
            ->get();


        ///esto que ?
        dd($id_medida[0]->id);

        $id_Arte = DB::table('artes')->insertGetId([
            'codigo'                => $request->CodigoArte,
            'marca_id'              => $Req[0]->marca,
            'producto_id'           => $Prop[0]->articulo,
            'caracteristicas'       => $Prop[0]->caracteristicas,
            '2d'                    => $Arch_2D[0]->url.$Arch_2D[0]->archivo,
            '3d'                    => $Arch_3D[0]->url.$Arch_3D[0]->archivo,
            'plano'                 => $Arch_Plano[0]->url.$Arch_Plano[0]->archivo,
            'diseñador_id'          => $Req[0]->diseñador_id,
            'vendedor_id'           => $Req[0]->vendedor_id,
            'propuesta_id'          => $request->Prop,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        $valores_producto_base = DB::table('cod_codigos')
            ->where('id','=',$Prop[0]->articulo)
            ->get();

        $mayor_codigo = DB::table('cod_codigos')
            ->where('codigo','like', substr($valores_producto_base[0]->codigo,0,6).'%')
            ->pluck('codigo');

        $mayor_codigo_Array = [];
        foreach ($mayor_codigo as $may_cod){
            $mayor_codigo_Array [] = substr($may_cod,6,5);
        }
        $mayor_codigo = max($mayor_codigo_Array);
        $mayor_codigo = $mayor_codigo+1;
        $mayor_codigo = str_pad($mayor_codigo,4,"0",STR_PAD_LEFT);
        $mayor_codigo = substr($valores_producto_base[0]->codigo,0,6).$mayor_codigo;


        DB::table('cod_codigos')->insert([
            'codigo'                    =>  $mayor_codigo,
            'comments'                  =>  '',
            'descripcion'               =>  $Descripcion_Producto_String,
            'usuario'                   =>  $Req[0]->diseñador_id,
            'usuario_aprobo'            =>  $Req[0]->vendedor_id,
            'arte'                      =>  $id_Arte,
            'estado'                    =>  '1',
            'area'                      =>  '',
            'costo_base'                =>  '',
            'generico'                  =>  '1',
            'created_at'                =>  Carbon::now(),
            'updated_at'                =>  Carbon::now(),
            'cod_tipo_producto_id'      =>  $valores_producto_base[0]->cod_tipo_producto_id,
            'cod_lineas_id'             =>  $valores_producto_base[0]->cod_lineas_id,
            'cod_sublineas_id'          =>  $valores_producto_base[0]->cod_sublineas_id,
            'cod_medidas_id'            =>  $id_medida[0]->id,
            'cod_caracteristicas_id'    =>  $valores_producto_base[0]->cod_caracteristicas_id,
            'cod_materials_id'          =>  $valores_producto_base[0]->cod_materials_id
        ]);
    }

    public function AgregarCaracteristicaPropuesta(Request $request)
    {
        DB::table('propuestas_requerimientos')->where('id','=',$request->prop)->update([
           'caracteristicas'    => $request->coments
        ]);

        $var = $request->coments;

        return response()->json($var);

    }

    public function EnviaraDiseño(Request $request)
    {

        DB::table('encabezado_requerimientos')->where('id', '=', $request->id)->update([
            'estado' => '3'
        ]);


        DB::table('transacciones_requerimientos')->insert([
            'idReq'         =>  $request->id,
            'tipo'          =>  'Propuesta',
            'descripcion'   =>  'Envio el requerimiento #'. $request->id.' al area de diseño',
            'usuario'       =>  $request->Username,
            'created_at'    =>  Carbon::now(),
            'updated_at'    =>  Carbon::now()
        ]);
    }



}
