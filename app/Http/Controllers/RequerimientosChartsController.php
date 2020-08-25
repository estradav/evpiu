<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequerimientosChartsController extends Controller
{
    public function index(){
        return view('Requerimientos.dashboard');
    }


    public function RequerimientosxDiseñador(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $UsersArray = array();
                $users = User::get()->where('cod_designer', '<>', '');
                $users = json_decode($users);
                if (!empty($users)) {
                    foreach ($users as $usr) {
                        $req = DB::table('encabezado_requerimientos')->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();
                        $UsersArray[] = ['name' => $usr->name, 'd_id' => $usr->cod_designer, 'req' => $req];

                    }
                }
                return ['Diseñadores' => $UsersArray];
            } else {
                $UsersArray = array();
                $users = User::get()->where('cod_designer', '<>', '');
                $users = json_decode($users);
                if (!empty($users)) {
                    foreach ($users as $usr) {
                        $req = DB::table('encabezado_requerimientos')->where('diseñador_id', '=', $usr->cod_designer)->get()->count();
                        $UsersArray[] = ['name' => $usr->name, 'd_id' => $usr->cod_designer, 'req' => $req];

                    }
                }
                return ['Diseñadores' => $UsersArray];
            }
        }
    }


    public function Est_Propuestas(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $UsersArray = array();
                $users = User::get()->where('cod_designer', '<>', '');
                $users = json_decode($users);
                if (!empty($users)) {
                    foreach ($users as $usr) {
                        $est_iniciado = DB::table('propuestas_requerimientos')
                            ->where('estado','=','1')
                            ->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();

                        $est_porAprobar = DB::table('propuestas_requerimientos')
                            ->where('estado','=','2')
                            ->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();

                        $est_rechazadoVend = DB::table('propuestas_requerimientos')
                            ->where('estado','=','3')
                            ->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();

                        $est_aprobado = DB::table('propuestas_requerimientos')
                            ->where('estado','=','4')
                            ->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();

                        $est_plano = DB::table('propuestas_requerimientos')
                            ->where('estado','=','5')
                            ->where('diseñador_id', '=', $usr->cod_designer)
                            ->whereBetween('created_at', array($request->from_date, $request->to_date))->get()->count();

                        $UsersArray[] = [
                            'name'              => $usr->name,
                            'd_id'              => $usr->cod_designer,
                            'est_iniciado'      => $est_iniciado,
                            'est_porAprobar'    => $est_porAprobar,
                            'est_rechazadoVend' => $est_rechazadoVend,
                            'est_aprobado'      => $est_aprobado,
                            'est_plano'         => $est_plano
                        ];
                    }
                }
                return ['Diseñadores' => $UsersArray];
            } else {
                $UsersArray = array();
                $users = User::get()->where('cod_designer', '<>', '');
                $users = json_decode($users);
                if (!empty($users)) {
                    foreach ($users as $usr) {
                        $est_iniciado = DB::table('propuestas_requerimientos')
                            ->where('estado','=','1')
                            ->where('diseñador_id', '=', $usr->cod_designer)->get()->count();

                        $est_porAprobar = DB::table('propuestas_requerimientos')
                            ->where('estado','=','2')
                            ->where('diseñador_id', '=', $usr->cod_designer)->get()->count();

                        $est_rechazadoVend = DB::table('propuestas_requerimientos')
                            ->where('estado','=','3')
                            ->where('diseñador_id', '=', $usr->cod_designer)->get()->count();

                        $est_aprobado = DB::table('propuestas_requerimientos')
                            ->where('estado','=','4')
                            ->where('diseñador_id', '=', $usr->cod_designer)->get()->count();

                        $est_plano = DB::table('propuestas_requerimientos')
                            ->where('estado','=','5')
                            ->where('diseñador_id', '=', $usr->cod_designer)->get()->count();

                        $UsersArray[] = [
                            'name'              => $usr->name,
                            'd_id'              => $usr->cod_designer,
                            'est_iniciado'      => $est_iniciado,
                            'est_porAprobar'    => $est_porAprobar,
                            'est_rechazadoVend' => $est_rechazadoVend,
                            'est_aprobado'      => $est_aprobado,
                            'est_plano'         => $est_plano
                        ];
                    }
                }
                return ['Diseñadores' => $UsersArray];
            }
        }
    }


    public function All_req_est(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $ReqSolicitados = DB::table('encabezado_requerimientos')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                $ReqFinalizados = DB::table('encabezado_requerimientos')
                    ->where('estado','=','8')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                $ReqAnulados =  DB::table('encabezado_requerimientos')
                    ->where('estado','=','6')
                    ->whereBetween('created_at', array($request->from_date, $request->to_date))
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                return [
                    'ReqSolicitados' => $ReqSolicitados,
                    'ReqFinalizados' => $ReqFinalizados,
                    'ReqAnulados'    => $ReqAnulados
                ];

            } else {
                $ReqSolicitados = DB::table('encabezado_requerimientos')
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                $ReqFinalizados = DB::table('encabezado_requerimientos')
                    ->where('estado','=','5')
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                $ReqAnulados = DB::table('encabezado_requerimientos')
                    ->where('estado','=','6')
                    ->select(DB::raw('count(id) as `cantidad`'),
                        DB::raw("DATE_FORMAT(created_at, '%Y-%m') fecha"),
                        DB::raw('YEAR(created_at) año, MONTH(created_at) mes'))
                    ->groupby('año','mes')
                    ->get();

                return [
                    'ReqSolicitados' => $ReqSolicitados,
                    'ReqFinalizados' => $ReqFinalizados,
                    'ReqAnulados'    => $ReqAnulados
                ];
            }
        }
    }
}
