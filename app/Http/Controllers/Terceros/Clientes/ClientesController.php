<?php

namespace App\Http\Controllers\Terceros\Clientes;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ClientesController extends Controller
{
    /**
     * Envia un conjunto de facturas al WebService de fenalco
     *
     * @param Request $request
     * @return Factory|View
     * @throws \Exception
     */
    public function index(Request $request){
        if(request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_ClientesMAXDMS')
                ->select('CodigoMAX', 'CodigoDMS', 'NITMAX', 'NombreMAX', 'EstadoMAX')
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->CodigoMAX).'/show" class="btn btn-sm btn-outline-light" id="view-customer"><i class="fas fa-eye"></i> Ver Cliente</a>';
                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('aplicaciones.gestion_terceros.clientes.index');
    }


    /**
     * Vista para crear un nuevo cliente
     *
     * @return Factory|View
     */
    public function nuevo(){
        $plazos = DB::connection('MAX')
            ->table('Code_Master')
            ->where('CDEKEY_36','=','TERM')
            ->where('DAYS_36','<>','')
            ->get();

        $forma_envio = DB::connection('MAX')
            ->table('Code_Master')
            ->where('Code_Master.CDEKEY_36','=','SHIP')
            ->get();

        $vendedores = DB::connection('MAX')
            ->table('Sales_Rep_Master')
            ->where('UDFKEY_26','<>','RETIRADO')
            ->orderBy('SLSNME_26','asc')
            ->get();

        $tipo_cliente = DB::connection('MAX')
            ->table('Customer_Types')
            ->get();

        $paises =  DB::connection('DMS')
            ->table('y_paises')
            ->get();



        return view('aplicaciones.gestion_terceros.clientes.create',
            compact('plazos','forma_envio', 'vendedores', 'tipo_cliente', 'paises'));
    }


    /**
     * Buscar cliente para comprobar si exite en las bases de datos de max y dms
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function buscar_cliente(Request $request){
        $query = $request->get('query');

        try {
            $max = DB::connection('MAX')
                ->table('Customer_Master')
                ->where('NAME_23','like',$query.'%')
                ->orWhere('CUSTID_23','like',$query.'%')
                ->count();

            $dms = DB::connection('DMS')
                ->table('terceros')
                ->where('nombres','like',$query.'%')
                ->orWhere('nit_real','like',$query.'%')
                ->count();
            return response()->json(['max' => $max,'dms' => $dms],200);
        }catch (\Exception $e){
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Lista de departamentos filtrados por ciudad
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listar_departamentos(Request $request){
        if ($request->ajax()){
            try {
                $departamentos =  DB::connection('DMS')
                    ->table('y_departamentos')
                    ->where('pais','=', $request->id_pais)
                    ->get();
                return response()->json($departamentos, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    /**
     * Lista de ciudades filtradas por departamento
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function listar_ciudades(Request $request){
        if ($request->ajax()){
            try {
                $ciudades =  DB::connection('DMS')
                    ->table('y_ciudades')
                    ->where('pais','=', $request->id_pais)
                    ->where('departamento', '=',$request->id_departamento)
                    ->get();
                return response()->json($ciudades, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }

    }
}
