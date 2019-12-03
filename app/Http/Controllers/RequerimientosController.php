<?php

namespace App\Http\Controllers;

use App\CodLinea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;
use XMLWriter;


class RequerimientosController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->estado == 1) {
                if ($request->perfil == 1 || $request->perfil == 3 || $request->perfil == 4){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();
                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Asignar " name="Asignar" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 ||$request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();
                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Asignar" name="Asignar" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);

                }
            }

            /* Ojo falta el estado 2 para los vendedores */
            if ($request->estado == 3) {
                if ($request->perfil == 3 || $request->perfil == 2 || $request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_PorPlano" name="Ver_PorPlano" id="'.$row->id.'" ><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_PorPlano" name="Ver_PorPlano" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }

            if ($request->estado == 4) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=', $request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Asignado" name="Ver_Asignado" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Asignado" name="Ver_Asignado" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Asignado" name="Ver_Asignado" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }

            if ($request->estado == 5) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=', $request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_iniciado" name="Ver_iniciado" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999)
                {
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_iniciado" name="Ver_iniciado" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4)
                {
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_iniciado" name="Ver_iniciado" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }

            if ($request->estado == 6) {
                if ($request->perfil == 4 || $request->perfil == 2 || $request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Renderizando" name="Ver_Renderizando" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 1 || $request->perfil == 3){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Renderizando" name="Ver_Renderizando" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }

            /* Ojo falta el estado 7 para los vendedores */
            /*if ($request->estado == 7) {
                $data =  DB::table('maestro_requerimientos')
                    ->where('estado','=',$request->estado)
                    ->orderBy('estado', 'desc')
                    ->get();

                return Datatables::of($data)
                    ->addColumn('opciones', function($row){
                        $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_PorAprobar" name="Ver_PorAprobar" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                        return $btn;
                    })
                    ->rawColumns(['opciones'])
                    ->make(true);
            }*/

            if ($request->estado == 8) {
                if ($request->perfil == 1 || $request->perfil == 2 || $request->perfil == 999 ){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_PorCorregir" name="Ver_PorCorregir" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_PorCorregir" name="Ver_PorCorregir" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }

            }

            if ($request->estado == 9) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Aprobados" name="Ver_Aprobados" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4 ){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Aprobados" name="Ver_Aprobados" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999 ){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Aprobados" name="Ver_Aprobados" id="'.$row->id.'" ><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }

            if ($request->estado == 10) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Cerrados" name="Ver_Cerrados" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4 ){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Cerrados" name="Ver_Cerrados" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999 ){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Cerrados" name="Ver_Cerrados" id="'.$row->id.'" ><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }

            }

            if ($request->estado == 11) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Anulados" name="Ver_Anulados" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Anulados" name="Ver_Anulados" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_Anulados" name="Ver_Anulados" id="'.$row->id.'" ><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }

            }

            if ($request->estado == 12) {
                if ($request->perfil == 1){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->where('diseñador','=',$request->asignado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_SinAprobar" name="Ver_SinAprobar" id="'.$row->id.'"><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 3 || $request->perfil == 4){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_SinAprobar" name="Ver_SinAprobar" id="'.$row->id.'" disabled><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
                if ($request->perfil == 2 || $request->perfil == 999){
                    $data =  DB::table('maestro_requerimientos')
                        ->where('estado','=',$request->estado)
                        ->orderBy('estado', 'desc')
                        ->get();

                    return Datatables::of($data)
                        ->addColumn('opciones', function($row){
                            $btn = '<div class="btn-group ml-auto">'.'<button class="edit btn btn-light btn-sm Ver_SinAprobar" name="Ver_SinAprobar" id="'.$row->id.'" ><i class="fas fa-eye"></i> Ver</button>'.'</div>';
                            return $btn;
                        })
                        ->rawColumns(['opciones'])
                        ->make(true);
                }
            }
        }
        return view('Requerimientos.Requerimiento');

    }

    public function SearchMarcas(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('EVPIUM')->table('Marcas')
            ->where('NombreMarca', 'LIKE', '%'.$query.'%')
            ->take(20)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value' =>  trim($q->NombreMarca),
            ];
        }
        return response()->json($results);
    }

    public function SearchProductsMax(Request $request)
    {
        $query = $request->get('query');
        $results = array();

        $queries = DB::connection('MAX')->table('CIEV_V_Inventario')
            ->where('Descripcion', 'LIKE', '%'.$query.'%')
            ->orWhere('Pieza', 'LIKE', '%'.$query.'%')->take(10)
            ->get();

        foreach ($queries as $q) {
            $results[] = [
                'value' => trim($q->Descripcion),
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
        dd($request);
        DB::table('maestro_requerimientos')->insertGetId([
            'descripcion'   => $request->Producto,
            'informacion'   => $request->Informacion,
            'vendedor'      => $request->Vendedor,
            'diseñador'     => $request->Diseñador,
            'marca'         => $request->Marca,
            'render'        => $request->Render
        ]);
    }

    public function RequerimientoSaveFile(Request $request)
    {
        dd($request);
        /*File::makeDirectory('/path/to/directory');*/
        $imageName = $request->file->getClientOriginalName();
        $request->file->move(public_path('upload'), $imageName);

        return response()->json(['uploaded' => '/upload/'.$imageName]);
    }
}
