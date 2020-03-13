<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SoapClient;
use Yajra\DataTables\DataTables;

class GestionClientesController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_ClientesMAXDMS')
                ->select('CodigoMAX',
                    'CodigoDMS',
                    'NITMAX',
                    'NombreMAX',
                    'EstadoMAX'
                )
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="/GestionClientes/'.trim($row->CodigoMAX).'/show" class="btn btn-sm btn-outline-light" id="view-customer"><i class="fas fa-eye"></i> Ver Cliente</a>';
                    return $btn;
                })
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('GestionClientes.index');
    }

    public function FormaEnvio(Request $request)
    {
        if ($request->ajax()){
            $FormaEnvio =  DB::connection('MAX')->table('Code_Master')
                ->where('Code_Master.CDEKEY_36','=','SHIP')
                ->get();
        }
        return response()->json($FormaEnvio);
    }

    public function Plazo(Request $request)
    {
        if ($request->ajax()){
            $Condicion =  DB::connection('MAX')->table('Code_Master')
                ->where('CDEKEY_36','=','TERM')
                ->where('DAYS_36','<>','')
                ->get();
        }
        return response()->json($Condicion);
    }

    public function Paises(Request $request)
    {
        if ($request->ajax()){
            $Paises =  DB::connection('DMS')->table('y_paises')
                ->get();
        }
        return response()->json($Paises);
    }

    public function Departamentos(Request $request)
    {
        if ($request->ajax()){
            $Departamentos =  DB::connection('DMS')->table('y_departamentos')
                ->where('pais','=', $request->id_pais)
                ->get();
        }
        return response()->json($Departamentos);
    }

    public function Ciudades(Request $request)
    {
        if ($request->ajax()){
            $Ciudades =  DB::connection('DMS')->table('y_ciudades')
                ->where('pais','=', $request->id_pais)
                ->where('departamento', '=',$request->id_departamento)
                ->get();
        }
        return response()->json($Ciudades);
    }

    public function TipoCliente(Request $request)
    {
        if ($request->ajax()){
            $Tipo_cliente =  DB::connection('MAX')->table('Customer_Types')
                ->get();
        }
        return response()->json($Tipo_cliente);
    }

    public function GetSellerList(Request $request)
    {
        if ($request->ajax()){
            $User =  DB::connection('MAX')
                ->table('Sales_Rep_Master')
                ->where('UDFKEY_26','<>','RETIRADO')
                ->orderBy('SLSNME_26','asc')
                ->get();
        }
        return response()->json($User);
    }

    public function show($numero)
    {
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
            ->get();

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


        return view('GestionClientes.show')->with([
            'facturas'          => $facturas,
            'notas_credito'     => $notas_credito,
            'cliente'           => $cliente,
            'productos_tend'    => $productos_tendencia,
        ]);


    }

    public function ProductosEnTendenciaPorMes(Request $request)
    {
        $current_year = Carbon::now();
        $current_year = $current_year->year;

        $values_peer_months = [];

        if (request()->ajax()){
            if (!empty($request->Year)) {
                for ($i = 1; $i <= 12; $i++){
                    $tendencia_mes = DB::connection('MAX')
                        ->table('CIEV_V_FacturasDetalladas')
                        ->where('CodigoCliente','=',$request->cliente)
                        ->where('Año','=',$request->Year)
                        ->where('Mes','=',$i)
                        ->select(DB::raw('sum(TotalItem) as Base'))
                        ->groupBy( 'Mes')
                        ->pluck('Base');


                    if ($i == 1 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 1){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 2 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 2){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 3 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 3){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 4 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 4){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 5 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 5){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 6 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 6){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 7 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 7){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 8 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 8){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 9 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 9){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 10 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 10){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 11 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 11){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 12 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 12){
                        array_push($values_peer_months, 0);
                    }
                }
            }else{
                for ($i = 1; $i <= 12; $i++){
                    $tendencia_mes = DB::connection('MAX')
                        ->table('CIEV_V_FacturasDetalladas')
                        ->where('CodigoCliente','=',$request->cliente)
                        ->where('Año','=',$current_year)
                        ->where('Mes','=',$i)
                        ->select(DB::raw('sum(TotalItem) as Base'))
                        ->groupBy( 'Mes')
                        ->pluck('Base');

                    if ($i == 1 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 1){
                       array_push($values_peer_months, 0);
                    }

                    if ($i == 2 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 2){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 3 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 3){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 4 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 4){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 5 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 5){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 6 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 6){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 7 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 7){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 8 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 8){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 9 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 9){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 10 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 10){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 11 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 11){
                        array_push($values_peer_months, 0);
                    }

                    if ($i == 12 && 1 <= count($tendencia_mes)){
                        array_push($values_peer_months, $tendencia_mes[0]);
                    }else if ($i == 12){
                        array_push($values_peer_months, 0);
                    }
                }
            }

            return response()->json([
                $values_peer_months
            ]);
        }
    }

    public function ClientesFaltantesDMS(Request $request)
    {
        if (request()->ajax()) {
            $data = DB::connection('MAX')
                ->table('CIEV_V_ClientesMAX_DMS')
                ->where('CodigoDMS','=',null)
                ->select('CodigoMAX',
                    'CodigoDMS',
                    'NITMAX',
                    'NombreMAX',
                    'EstadoMAX'
                )
                ->get();

            return datatables::of($data)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group ml-auto float-center">'.'<a href="javascript:void(0)" class="btn btn-sm btn-outline-light Sync-DMS" id="'.trim($row->CodigoMAX).'"><i class="fas fa-sync fa-spin"></i> Sincronizar</a>';
                    return $btn;
                })

                ->rawColumns(['opciones'])
                ->make(true);
        }
    }

    public function FacturacionElectronica(Request $request)
    {
        if (request()->ajax()) {
            $login1 = 'dcorreah';
            $password = "FE2020ev*";
            $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
            $client = new SoapClient($wsdl_url);
            $client->__setLocation($wsdl_url);

            $params = array(
                'login' => $login1,
                'password' => $password
            );

            $auth = $client->autenticar($params);
            $respuesta = json_decode($auth->return);
            $token = $respuesta->data->salida;

            $params = array(
                'token' => $token,
                'idEmpresa' => '',
                'idUsuario' => '',
                'idEstadoEnvioCliente' => '',
                'idEstadoEnvioDian' => '',
                'fechaInicial' => '',
                'fechaFinal' => '',
                'fechaInicialReg' => '',
                'fechaFinalReg' => '',
                'idEstadoGeneracion' => '',
                'idTipoDocElectronico' => '',
                'numeroInicial' => '',
                'numeroFinal' => '',
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => trim($request->nombre_cliente),
                'mulCodEstDian' => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );


            $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
            $return = json_decode($return->return);
            $values = $return->data;


            return datatables::of($values)
                ->addColumn('opciones', function($row){
                    $btn = '<button class="btn btn-sm btn-outline-light download_ws" id="'.$row->DT_RowId.'"><i class="far fa-file-pdf"></i> Descargar</button>';
                    return $btn;})
                ->rawColumns(['opciones'])
                ->make(true);
        }
    }

    public function UpdateAddress1(Request $request)
    {
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

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Direccion 1',
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    public function UpdateAddress2(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    public function UpdateMoneda(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    //Esta pendiente el cambio de tipo de cliente, por que martin debe validar los equivalentes para DMS
    public function UpdateTypeClient(Request $request)
    {
        dd($request);
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    public function UpdateContact(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    public function UpdatePhone1(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'code2' =>$e->getLine(),
                ),
            ));
        }
    }

    public function UpdatePhone2(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateCellphone(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateContactEmail(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateInvoiceEmail(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdatePaymentTerm(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateDiscount(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateSeller(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateMailsCopy(Request $request)
    {
        $Array = $request->correos_copia;

        $correos_string = '';

         foreach ($Array as $Ar){

             $correos_string = $correos_string.';'.$Ar;
         }

        $correos_string = substr($correos_string,1);


        DB::beginTransaction();
        try {
            DB::connection('MAX')
                ->table('customer_master_ext')
                ->where('CUSTID_23','=', $request->cliente)
                ->update([
                    'CorreosCopia'  =>  $correos_string
                ]);

            DB::table('log_modifications_clients')->insert([
                'codigo_cliente'    =>  $request->cliente,
                'campo_cambiado'    =>  'Correos Copia',
                'usuario'           =>  $request->username,
                'justificacion'     =>  'Correcccion correos copia',
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateRut(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateGreatContributor(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateResponsableIva(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateResponsableFe(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdatePhoneFe(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateCodeCityExt(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function UpdateGroupEconomic(Request $request)
    {
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
                'usuario'           =>  $request->username,
                'justificacion'     =>  $request->result['value'][0]['justify'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            DB::commit();

            return response()->json(['Success' => 'Guardado con exito!'],200);

        }catch (\Exception $e){
            DB::rollback();
            echo json_encode(array(
                'error' => array(
                    'msg'   => $e->getMessage(),
                    'code'  => $e->getCode(),
                    'code2' => $e->getLine(),
                ),
            ));
        }
    }

    public function GetTransactionsData(Request $request)
    {
        $data = DB::table('log_modifications_clients')
            ->where('codigo_cliente','=',$request->cod_cliente)
            ->get();

        return datatables::of($data)
            ->make(true);
    }

    public function SaveNewCustomer(Request $request)
    {
        $tax_code = '';
        $gran_contri = '0';
        $rut_entrega = '0';
        $termino_dms = '';

        // campos que deben de ir con espacios en blanco
        $direccion2 = '';
        $codigo_postal = '';
        $telefono_2 = '';
        $celular = '';

        if ($request->M_direccion2 == null){
            $direccion2 = ' ';
        }else{
            $direccion2 = $request->M_direccion2;
        }

        if ($request->M_Codigo_postal == null){
            $codigo_postal = ' ';
        }else{
            $codigo_postal = $request->M_Codigo_postal;
        }

        if ($request->M_Telefono2 == null){
            $telefono_2 = ' ';
        }else{
            $telefono_2 = $request->M_Telefono2;
        }

        if ($request->M_Celular == null){
            $celular = ' ';
        }else{
            $celular = $request->M_Celular;
        }


        if ($request->M_Gravado == 'Y'){
            $tax_code = 'IVA-V19';
        }

        if ($request->M_gran_contribuyente == 'on'){
            $gran_contri = '1';
        }

        if ($request->M_rut_entregado == 'on'){
            $rut_entrega = '1';
        }


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


        $apellidos_lenght = $request->M_primer_apellido.' '.$request->M_segundo_apellido;
        $apellidos_lenght = strlen($apellidos_lenght ) +1;

        $nombre_max = '';
        if ($request->M_primer_apellido != ''){
            $nombre_max = $request->M_primer_apellido.' '.$request->M_segundo_apellido.' '.$request->M_primer_nombre.' '.$request->M_segundo_nombre;
        }else{
            $nombre_max = $request->M_primer_nombre;
        }

        DB::beginTransaction();
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
                     'ADDR2_23'     =>  $direccion2,
                     'CITY_23'      =>  $request->ciudad,
                     'STATE_23'     =>  $request->departamento,
                     'ZIPCD_23'     =>  $codigo_postal,
                     'CNTRY_23'     =>  $request->pais,
                     'SLSTER_23'    =>  $territorio_cliente[0],
                     'CNTCT_23'     =>  $request->M_Contacto,
                     'PHONE_23'     =>  $request->M_Telefono,
                     'EMAIL1_23'    =>  $request->M_Email_contacto,
                     'EMAIL2_23'    =>  $request->M_Email_facturacion,
                     'TELEX_23'     =>  $telefono_2,
                     'FAXNO_23'     =>  $celular,
                     'TAXABL_23'    =>  $request->M_Gravado,
                     'TXCDE1_23'    =>  $tax_code,
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
                     'CreatedBy'    =>  $request->username,
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
                     'GRUPOECON'            =>  $request->M_grupo_economico,
                     'TipoIdent'            =>  $request->M_tipo_doc,
                     'GranContr'            =>  $gran_contri,
                     'ActividadPrincipal'   =>  $request->M_actividad_principal,
                     'RUT'                  =>  $rut_entrega,
                     'ResponsableFE'        =>  $request->M_responsable_fe,
                     'telFE'                =>  $request->M_telefono_fe,
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
                     'usuario'                          =>  $request->username,
                     'sincronizado'                     =>  'N',
                     'id_definicion_tributaria_tipo'    =>  $dms_id_def_trib_tipo[0],
                     'tieneRUT'                         =>  $rut_entrega,
                     'codigoPostal'                     =>  $request->M_Codigo_postal,
                 ]);


             DB::connection('DMS')
                 ->table('terceros_nombres')
                 ->insert([
                     'nit'                  =>  $request->M_Nit_cc,
                     'primer_apellido'      =>  $request->M_primer_apellido,
                     'segundo_apellido'     =>  $request->M_segundo_apellido,
                     'primer_nombre'        =>  $request->M_primer_nombre,
                     'segundo_nombre'       =>  $request->M_segundo_nombre
                 ]);

             DB::commit();
             return response()->json(['Success' => 'Guardado con exito!'],200);

         }catch (\Exception $e){
             DB::rollback();
             return response()->json([
                 'success' => 'false',
                 'errors'  => $e->getMessage(),
             ], 400);
         }
    }

}
