<?php

namespace App\Http\Controllers\Terceros\Clientes;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
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
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/aplicaciones/terceros/cliente/editar/'.trim($row->CodigoMAX).'/show" class="btn btn-sm btn-outline-light" id="view-customer"><i class="fas fa-eye"></i> Ver Cliente</a>';
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

        $razones_comerciales = DB::connection('DMS')
            ->table('Terceros_actividad_economica')
            ->orderBy('descripcion', 'asc')
            ->get();

        return view('aplicaciones.gestion_terceros.clientes.create',
            compact('plazos','forma_envio', 'vendedores', 'tipo_cliente', 'paises', 'razones_comerciales'));
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


    /**
     * Guardar cliente en las plataformas de max y dms
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function guardar_cliente(Request $request){

        if ($request->file('archivo_rut')){
            $file = $request->file('archivo_rut');

            $nombre = $request->M_Nit_cc;
            $ext = $file->getClientOriginalExtension();

            Storage::disk('rut_clientes')->put($nombre.'.'.$ext,  \File::get($file));
        }

        $termino_dms = '';

        if ($request->M_Plazo == '00'){
            //180 dias
            $termino_dms = '10';
        }elseif ($request->M_Plazo == '01'){
            //contado
            $termino_dms = '01';
        }elseif ($request->M_Plazo == '02'){
            //30 dias
            $termino_dms = '02';
        }elseif ($request->M_Plazo == '03'){
            //60 dias
            $termino_dms = '03';
        }elseif ($request->M_Plazo == '04'){
            //45 dias
            $termino_dms = '04';
        }elseif ($request->M_Plazo == '05'){
            //90 dias
            $termino_dms = '05';
        }elseif ($request->M_Plazo == '06'){
            //15 dias
            $termino_dms = '06';
        }elseif ($request->M_Plazo == '07'){
            //120 dias
            $termino_dms = '07';
        }elseif ($request->M_Plazo == '08'){
            //75 dias
            $termino_dms = '08';
        }elseif ($request->M_Plazo == '09'){
            //150 dias
            $termino_dms = '09';
        }elseif ($request->M_Plazo == '15'){
            //8 dias
            $termino_dms = '15';
        }elseif ($request->M_Plazo == '16'){
            //360 dias
            $termino_dms = '16';
        }elseif ($request->M_Plazo == '18'){
            //70 dias
            $termino_dms = '18';
        }

        $correos_copia = $request->Correos_copia;
        $correos_copia = str_replace(",",";",$correos_copia);


        $dms_id_def_trib_tipo = DB::connection('MAX')
            ->table('Customer_Types')
            ->where('CUSTYP_62','=',$request->M_Tipo_cliente)
            ->pluck('UDFREF_62');


        $territorio_cliente = DB::connection('MAX')
            ->table('Sales_Rep_Master')
            ->where('SLSREP_26','=',$request->M_vendedor)
            ->pluck('SLSTER_26');




        $nombre_max = '';
        if (trim($request->M_primer_apellido) != ''){
            $nombre_max = $request->M_primer_apellido.' '.$request->M_segundo_apellido.' '.$request->M_primer_nombre.' '.$request->M_segundo_nombre;

            $apellidos_lenght = $request->M_primer_apellido.' '.$request->M_segundo_apellido;
            $apellidos_lenght = strlen($apellidos_lenght);
        }else{
            $nombre_max = $request->M_primer_nombre;
            $apellidos_lenght = 0;
        }


        DB::connection('MAX')->beginTransaction();
        DB::connection('DMS')->beginTransaction();
        try {
            DB::connection('MAX')
                ->table('Customer_Master')
                ->insert([
                    'CUSTID_23'    =>  $request->M_Nit_cc,
                    'SLSREP_23'    =>  $request->M_vendedor,
                    'STATUS_23'    =>  'R',
                    'CUSTYP_23'    =>  $request->M_Tipo_cliente,
                    'NAME_23'      =>  $nombre_max,
                    'ADDR1_23'     =>  $request->M_direccion1,
                    'ADDR2_23'     =>  $request->M_direccion2 ?? ' ',
                    'CITY_23'      =>  $request->ciudad,
                    'STATE_23'     =>  $request->departamento,
                    'ZIPCD_23'     =>  $request->M_Codigo_postal ?? ' ',
                    'CNTRY_23'     =>  $request->pais,
                    'SLSTER_23'    =>  $territorio_cliente[0],
                    'CNTCT_23'     =>  $request->M_Contacto,
                    'PHONE_23'     =>  $request->M_Telefono,
                    'EMAIL1_23'    =>  $request->M_Email_contacto,
                    'EMAIL2_23'    =>  $request->M_Email_facturacion,
                    'TELEX_23'     =>  $request->M_Telefono2 ?? ' ',
                    'FAXNO_23'     =>  $request->M_Celular ?? ' ',
                    'TAXABL_23'    =>  $request->M_Gravado,
                    'TXCDE1_23'    =>  $request->M_Gravado == 'Y' ? 'IVA-V19' : ' ',
                    'TERMS_23'     =>  $request->M_Plazo,
                    'DSCRTE_23'    =>  $request->M_Porcentaje_descuento,
                    'SHPVIA_23'    =>  $request->M_Forma_envio,
                    'SLSMTD_23'    =>  '0',
                    'COGMTD_23'    =>  '0',
                    'SLSYTD_23'    =>  '0',
                    'COGYTD_23'    =>  '0',
                    'COGLYR_23'    =>  '0',
                    'UNPORD_23'    =>  '0',
                    'NEWDTE_23'    =>  Carbon::now(),
                    'DISCPF_23'    =>  'B',
                    'ALWBCK_23'    =>  'N',
                    'CHGDTE_23'    =>  Carbon::now(),
                    'CURR_23'      =>  $request->M_Moneda,
                    'COMMIS_23'    =>  '0',
                    'UDFKEY_23'    =>  $request->M_Nit_cc.'-'.$request->M_Nit_cc_dg,
                    'CreatedBy'    =>  Auth::user()->username,
                    'CreationDate' =>  Carbon::now(),
                    'VATSUSP_23'   =>  'N',
                    'COMNT1_23'    =>  ' ',
                    'COMNT2_23'    =>  ' ',
                    'TAXNUM_23'    =>  ' ',
                    'TXCDE2_23'    =>  ' ',
                    'TXCDE3_23'    =>  ' ',
                    'CLIMIT_23'    =>  ' ',
                    'STMNTS_23'    =>  ' ',
                    'FINCHG_23'    =>  ' ',
                    'XURR_23'      =>  ' ',
                    'FOB_23'       =>  ' ',
                    'SLSLYR_23'    =>  ' ',
                    'TAXPRV_23'    =>  ' ',
                    'ADDR3_23'     =>  ' ',
                    'ADDR4_23'     =>  ' ',
                    'ADDR5_23'     =>  ' ',
                    'ADDR6_23'     =>  ' ',
                    'MCOMP_23'     =>  ' ',
                    'MSITE_23'     =>  ' ',
                    'UDFREF_23'    =>  ' ',
                    'SHPCDE_23'    =>  ' ',
                    'SHPTHRU_23'   =>  ' '
                ]);

                DB::connection('MAX')
                    ->table('Customer_Master_Ext')
                    ->insert([
                        'CUSTID_23'            =>  $request->M_Nit_cc,
                        'GRUPOECON'            =>  $request->M_grupo_economico ?? '',
                        'TipoIdent'            =>  $request->M_tipo_doc,
                        'GranContr'            =>  $request->M_gran_contribuyente == 'on' ? '1': '0',
                        'ActividadPrincipal'   =>  $request->M_actividad_principal,
                        'RUT'                  =>  $request->M_rut_entregado == 'on' ? '1' : '0',
                        'ResponsableFE'        =>  strtoupper($request->M_responsable_fe ?? ''),
                        'telFE'                =>  $request->M_telefono_fe ?? '',
                        'CorreosCopia'         =>  $correos_copia,
                        'ResponsableIVA'       =>  '',
                        'CiudadExterior'       =>  ''
                    ]);

                DB::connection('DMS')
                    ->table('terceros')
                    ->insert([
                        'nit'                              =>  $request->M_Nit_cc,
                        'digito'                           =>  $request->M_Nit_cc_dg,
                        'nombres'                          =>  $nombre_max,
                        'direccion'                        =>  $request->M_direccion1,
                        'ciudad'                           =>  $request->ciudad,
                        'telefono_1'                       =>  $request->M_Telefono,
                        'telefono_2'                       =>  $request->M_Telefono2,
                        'tipo_identificacion'              =>  $request->M_tipo_doc, // pendiente por que los valores deben ser equivalentes en max
                        'pais'                             =>  $request->pais,
                        'gran_contribuyente'               =>  '0',
                        'autoretenedor'                    =>  '0',
                        'bloqueo'                          =>  '0',
                        'concepto_1'                       =>  $request->M_tipo_tercero_dms,
                        'concepto_2'                       =>  '1', // territorio del vendedor
                        'concepto_3'                       =>  '15',
                        'concepto_4'                       =>  $request->M_tipo_client_dms,
                        'mail'                             =>  $request->M_Email_contacto,
                        'pos_num'                          =>  $apellidos_lenght,
                        'regimen'                          =>  'S', // validar con martin
                        'cupo_credito'                     =>  '0',
                        'nit_real'                         =>  intval($request->M_Nit_cc),
                        'condicion'                        =>  $termino_dms,
                        'vendedor'                         =>  intval($request->M_vendedor),
                        'contacto_1'                       =>  $request->M_Contacto,
                        'fecha_creacion'                   =>  Carbon::now(),
                        'descuento_fijo'                   =>  $request->M_Porcentaje_descuento,
                        'centro_fijo'                      =>  '0',
                        'y_dpto'                           =>  $request->M_Departamento,
                        'y_ciudad'                         =>  $request->M_Ciudad,
                        'celular'                          =>  $request->M_Celular,
                        'razon_comercial'                  =>  $request->M_Razon_comercial,
                        'y_pais'                           =>  $request->M_Pais,
                        'codigo_alterno'                   =>  $request->M_Nit_cc,
                        'usuario'                          =>  Auth::user()->username,
                        'sincronizado'                     =>  'N',
                        'id_definicion_tributaria_tipo'    =>  $dms_id_def_trib_tipo[0],
                        'tieneRUT'                         =>  $request->M_rut_entregado == 'on' ? '1' : '0',
                        'codigoPostal'                     =>  $request->M_Codigo_postal,
                    ]);

                if (trim($request->M_primer_apellido) != ''){
                    DB::connection('DMS')
                        ->table('terceros_nombres')
                        ->insert([
                            'nit'                  =>  $request->M_Nit_cc,
                            'primer_apellido'      =>  $request->M_primer_apellido,
                            'segundo_apellido'     =>  $request->M_segundo_apellido,
                            'primer_nombre'        =>  $request->M_primer_nombre,
                            'segundo_nombre'       =>  $request->M_segundo_nombre
                        ]);
                }

            DB::connection('MAX')->commit();
            DB::connection('DMS')->commit();
            return response()->json('Guardado con exito!',200);
        } catch (\Exception $e) {
            DB::connection('MAX')->rollback();
            DB::connection('DMS')->rollback();
            return  response()->json($e->getMessage(),500);
        }

    }


    /**
     * Muestra un cliente
     *
     * @param $numero
     * @return Factory|View
     */
    public function show($numero){
        $facturas = DB::connection('MAX')
            ->table('invoice_master')
            ->where('CUSTID_31','=',$numero)
            ->where('STYPE_31','=','CU')
            ->count();

        $notas_credito = DB::connection('MAX')
            ->table('invoice_master')
            ->where('CUSTID_31','=',$numero)
            ->where('STYPE_31','=','CR')
            ->count();

        $cliente = DB::connection('MAX')
            ->table('CIEV_V_Clientes')
            ->where('CODIGO_CLIENTE','=',$numero)
            ->first();

        $productos_tendencia = DB::connection('MAX')
            ->table('CIEV_V_FacturasDetalladas')
            ->where('CodigoCliente','=',$numero)
            ->select('CodigoProducto',
                DB::raw('count(*) as Total'),
                DB::raw('sum(Cantidad) as Comprado'))
            ->groupBy('CodigoProducto')
            ->orderBy('Comprado','desc')
            ->take(5)
            ->get()
            ->toArray();

        return view('aplicaciones.gestion_terceros.clientes.show',
            compact('facturas','notas_credito','cliente','productos_tendencia'));

    }


    /**
     * Actualiza la direccion principal del cliente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_direccion1(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'ADDR1_23'  =>  $request->result['value'][0]['addr1']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'direccion' =>  $request->result['value'][0]['addr1']
                ]);

            DB::table('log_modifications_clients')
                ->insert([
                    'codigo_cliente'    =>  $request->cliente,
                    'campo_cambiado'    =>  'Direccion 1',
                    'usuario'           =>  Auth::user()->username,
                    'justificacion'     =>  $request->result['value'][0]['justify'],
                    'created_at'        =>  Carbon::now(),
                    'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * Actualiza la direccion 2 del cliente
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_direccion2(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'ADDR2_23'  =>  $request->result['value'][0]['addr2']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Direccion 2',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json('Datos actualizados',500);
        }
    }


    /**
     * Cambiar tipo de moneda
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_moneda(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'CURR_23'  =>  $request->result['value'][0]['moneda']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Moneda',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * Cambia el tipo de cliente, nota: verificar esta funcion
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function cambiar_tipo_cliente(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'CURR_23'  =>  $request->result['value'][0]['moneda']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Moneda',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualizar nombre de contacto
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_contacto(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'CNTCT_23'  =>  $request->result['value'][0]['contact']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'contacto_1' =>  $request->result['value'][0]['contact']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Contacto',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * actualizar el telefono 1
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_telefono1(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'PHONE_23'  =>  $request->result['value'][0]['tel1']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'telefono_1' =>  $request->result['value'][0]['tel1']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Telefono 1',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * actualizar el telefono 2
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_telefono2(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'TELEX_23'  =>  $request->result['value'][0]['tel2']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'telefono_2' =>  $request->result['value'][0]['tel2']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Telefono 2',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * actualizar celular
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_celular(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'FAXNO_23'  =>  $request->result['value'][0]['cel']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'celular' =>  $request->result['value'][0]['cel']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Celular',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * actualiza email de contacto
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_email_contacto(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'EMAIL1_23'  =>  $request->result['value'][0]['email_contact']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'mail' =>  $request->result['value'][0]['email_contact']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Email Contacto',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);

        }
    }


    /**
     * actualiza email de entrega de facturacion electronica
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_email_facturacion_electronica(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'EMAIL2_23'  =>  $request->result['value'][0]['email_fact']
                ]);


            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Email Facturacion',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza los terminos de pago
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_termino_pago(Request $request){
        $termino_dms = '';

        if ($request->result['value'][0]['plazo_pago'] == '00'){
            //180 dias
            $termino_dms = '10';
        }elseif ($request->result['value'][0]['plazo_pago'] == '01'){
            //contado
            $termino_dms = '01';
        }elseif ($request->result['value'][0]['plazo_pago'] == '02'){
            //30 dias
            $termino_dms = '02';
        }elseif ($request->result['value'][0]['plazo_pago'] == '03'){
            //60 dias
            $termino_dms = '03';
        }elseif ($request->result['value'][0]['plazo_pago'] == '04'){
            //45 dias
            $termino_dms = '04';
        }elseif ($request->result['value'][0]['plazo_pago'] == '05'){
            //90 dias
            $termino_dms = '05';
        }elseif ($request->result['value'][0]['plazo_pago'] == '06'){
            //15 dias
            $termino_dms = '06';
        }elseif ($request->result['value'][0]['plazo_pago'] == '07'){
            //120 dias
            $termino_dms = '07';
        }elseif ($request->result['value'][0]['plazo_pago'] == '08'){
            //75 dias
            $termino_dms = '08';
        }elseif ($request->result['value'][0]['plazo_pago'] == '09'){
            //150 dias
            $termino_dms = '09';
        }elseif ($request->result['value'][0]['plazo_pago'] == '15'){
            //8 dias
            $termino_dms = '15';
        }elseif ($request->result['value'][0]['plazo_pago'] == '16'){
            //360 dias
            $termino_dms = '16';
        }elseif ($request->result['value'][0]['plazo_pago'] == '18'){
            //70 dias
            $termino_dms = '18';
        }


        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'TERMS_23'  =>  $request->result['value'][0]['plazo_pago']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'condicion' =>  $termino_dms
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Condicion de pago',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza el descuento
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_descuento(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'DSCRTE_23'  =>  $request->result['value'][0]['descuento']
                ]);


            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Descuento',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza el vendedor
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_vendedor(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'SLSREP_23'  =>  $request->result['value'][0]['vendedor']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'vendedor' =>  intval($request->result['value'][0]['vendedor'])
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Vendedor',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza los correos copia a los cuales se envia copia de facturacion electrronica
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_correos_copia(Request $request){
        $Array = $request->correos_copia;

        $correos_string = '';

        foreach ($Array as $Ar){
            $correos_string = $correos_string.';'.$Ar;
        }

        $correos_string = substr($correos_string, 1);


        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->updateOrInsert([
                    'CUSTID_23'     =>  $request->cliente
                ],[
                    'CorreosCopia'  =>  $correos_string
                ]);

            DB::table('log_modifications_clients')
                ->insert([
                    'codigo_cliente'    =>  $request->cliente,
                    'campo_cambiado'    =>  'Correos Copia',
                    'usuario'           =>  Auth::user()->username,
                    'justificacion'     =>  'Correcccion correos copia',
                    'created_at'        =>  Carbon::now(),
                    'updated_at'        =>  Carbon::now()
                ]);
            DB::commit();
            return response()->json('Datos actualizados', 200);
        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(), 500);
        }
    }


    /**
     * actualiza el rut.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_rut(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'RUT'  =>  $request->result['value'][0]['rut']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'tieneRUT' =>  $request->result['value'][0]['rut']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Rut',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza gran contribuyente.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_gran_contribuyente(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'GranContr'  =>  $request->result['value'][0]['gran_contribuyente']
                ]);

            DB::connection('DMS')
                ->table('terceros')
                ->where('codigo_alterno','=',$request->cliente)
                ->update([
                    'gran_contribuyente' =>  $request->result['value'][0]['gran_contribuyente']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Gran contribuyente',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza responsable iva.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_responsable_iva(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'ResponsableIVA'  =>  $request->result['value'][0]['resp_iva']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Responsable IVA',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();
            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza responsable facturacion electronica.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_responsable_facturacion_electronica(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'ResponsableIVA'  =>  $request->result['value'][0]['resp_fe']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Responsable FE',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza telefono de contacto para facturacion electronica.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_telefono_facturacion_electronica(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'telFE'  =>  $request->result['value'][0]['tel_fe']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Telefono FE',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();
            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza codigo de ciudad exterior
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_codigo_ciudad_ext(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'CiudadExterior'  =>  $request->result['value'][0]['cod_city_ext']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Codigo Ciudad Exterior',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * actualiza grupo economico
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actualizar_grupo_economico(Request $request){
        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'GRUPOECON'  =>  $request->result['value'][0]['grupo_economico']
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Grupo Economico',
                'usuario'           =>  Auth::user()->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json('Datos actualizados',200);

        }catch (\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }
    }


    /**
     * obtiene una lista con los cambios realizados en la aplicacion
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function obtener_log_cambios(Request $request){
        $data = DB::table('log_modifications_clients')
            ->where('codigo_cliente','=',$request->cod_cliente)
            ->get();

        return datatables::of($data)
            ->make(true);
    }


    /**
     * obtiene una lista con los plazos
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function listar_plazos(Request $request){
        if ($request->ajax()){
            try {
                $condicion =  DB::connection('MAX')->table('Code_Master')
                    ->where('CDEKEY_36','=','TERM')
                    ->where('DAYS_36','<>','')
                    ->get();
                return response()->json($condicion,200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }

        }
    }


    /**
     * obtiene una lista con los plazos
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function listar_vendedores(Request $request){
        if ($request->ajax()){
            try {
                $user =  DB::connection('MAX')
                    ->table('Sales_Rep_Master')
                    ->where('UDFKEY_26','<>','RETIRADO')
                    ->orderBy('SLSNME_26','asc')
                    ->get();
                return response()->json($user,200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * obtiene una lista con los tipo de clientes disponibles
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function listar_tipo_cliente(Request $request){
        if ($request->ajax()){
            try {
                $tipo_cliente =  DB::connection('MAX')
                    ->table('Customer_Types')
                    ->get();
                return response()->json($tipo_cliente, 200);

            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * obtiene una lista con las actividades economicas
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function listar_actividad_economica(Request $request){
        if ($request->ajax()){
            try {
                $actividad_economica = DB::connection('DMS')
                    ->table('terceros_actidad_economica')
                    ->get();
                return response()->json($actividad_economica, 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }


    /**
     * permite subir el rut / el nombre del archivo es el nit del cliente
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function subir_rut(Request $request){
        if ($request->hasFile('fileToUpload')) {
            try {
                $file = $request->file('fileToUpload')[0];

                $nombre = $request->numero;
                $ext = $file->getClientOriginalExtension();

                \Storage::disk('rut_clientes')->put($nombre.'.'.$ext,  \File::get($file));

                return response()->json('Archivo subido',200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(),500);
            }
        }
    }

    /**
     * permite subir el rut / el nombre del archivo es el nit del cliente
     *
     * @param $file
     * @return RedirectResponse
     */
    public function descargar_rut($file){
        $file_name = explode('-',$file);
        if (file_exists(storage_path('app/public/rut_clientes/'.$file_name[0].'.pdf'))){
            return response()->download(storage_path('app/public/rut_clientes/'.$file_name[0].'.pdf'));
        }else{
            return redirect()
                ->back()
                ->with([
                    'message'    => 'El archivo solicitado no existe.',
                    'alert-type' => 'error'
                ]);
        }
    }


    public function crear_actividad_economica(Request  $request){
        if ($request->ajax()){
            try {
                DB::table('Terceros_actividad_economica')->insert([
                   'codigo'         => $request->codigo,
                   'descripcion'    => $request->descripcion
                ]);

                return response()->json('Actividad guardada con exito', 200);
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


}
