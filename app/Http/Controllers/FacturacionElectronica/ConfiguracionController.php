<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ConfiguracionController extends Controller
{
    /**
     * Vista de cofiguracion de facturacion electronica.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(Request $request){
        try {
            $data = DB::table('fe_configs')
                ->first();

            return view('aplicaciones.facturacion_electronica.configuracion.index', compact('data'));

        }catch (\Exception $e){
            return redirect()
                ->back()
                ->with([
                    'message'    => $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }


    /**
     * Guarda configuracion para facturas
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_config_facturas(Request $request){
        if ($request->ajax()){
            try {
                DB::table('fe_configs')
                    ->where('id','=','1')
                    ->update([
                        'fac_idnumeracion'  => $request->fac_idnumeracion,
                        'fac_idambiente'    => $request->fac_idambiente,
                        'fac_idreporte'     => $request->fac_idreporte
                    ]);
                return response()->json('Datos guardados correctamente',200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * Guarda configuracion para notas credito
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_config_notas_credito(Request $request){
        if ($request->ajax()) {
            try {
                DB::table('fe_configs')
                    ->where('id', '=', '1')
                    ->update([
                        'nc_idnumeracion' => $request->nc_idnumeracion,
                        'nc_idambiente' => $request->nc_idambiente,
                        'nc_idreporte' => $request->nc_idreporte
                    ]);
                return response()->json('Datos guardados correctamente', 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function guardar_config_facturas_exportacion(Request $request){
        if ($request->ajax()) {
            try {
                DB::table('fe_configs')
                    ->where('id', '=', '1')
                    ->update([
                        'fac_exp_id_numeracion' => $request->fac_ext_idnumeracion,
                        'fac_exp_id_ambiente'   => $request->fac_ext_idambiente,
                        'fac_exp_id_reporte'    => $request->fac_ext_idreporte
                    ]);
                return response()->json('Datos guardados correctamente', 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    public function guardar_config_notas_exportacion(Request $request){
        if ($request->ajax()){
            try {
                DB::table('fe_configs')
                    ->where('id', '=', '1')
                    ->update([
                        'nc_exp_id_numeracion'   => $request->nc_ext_idnumeracion,
                        'nc_exp_id_ambiente'     => $request->nc_ext_idambiente,
                        'nc_exp_id_reporte'      => $request->nc_ext_idreporte
                    ]);
                return response()->json('Datos guardados correctamente', 200);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), 500);
            }
        }
    }
}


