<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use SoapClient;
use Yajra\DataTables\DataTables;

class GestionController extends Controller
{
    /**
     * Muestra una lista de faturas subidas a la dian.
     *
     * @param Request $request
     * @return Factory|View
     * @throws \Exception
     */
    public function index(Request $request){
        $fromdate = Carbon::now()->format('Y-m-d');
        $todate = Carbon::now()->format('Y-m-d');

        if (request()->ajax()) {
            if (!empty($request->from_date) || !empty($request->fe_start)) {
                $login1 = 'dcorreah';
                $password = "FE2020ev*";
                $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
                try {
                    $client = new SoapClient($wsdl_url);
                } catch (\SoapFault $e) {
                    return response($e->getMessage(),500);
                }
                $client->__setLocation($wsdl_url);

                $params = array(
                    'login' => $login1,
                    'password' => $password
                );

                $auth = $client->autenticar($params);

                $respuesta = json_decode($auth->return);
                $token = $respuesta->data->salida;

                $params = array(
                    'token'                 => $token,
                    'idEmpresa'             => '',
                    'idUsuario'             => '',
                    'idEstadoEnvioCliente'  => '',
                    'idEstadoEnvioDian'     => '',
                    'fechaInicial'          => strval($request->from_date),
                    'fechaFinal'            => strval($request->to_date),
                    'fechaInicialReg'       => '',
                    'fechaFinalReg'         => '',
                    'idEstadoGeneracion'    => '',
                    'idTipoDocElectronico'  => $request->type_doc,
                    'numeroInicial'         => $request->fe_start,
                    'numeroFinal'           => $request->fe_end,
                    'idnumeracion'          => '',
                    'estadoAcuse'           => '',
                    'razonSocial'           => '',
                    'mulCodEstDian'         => '',
                    'mulCodEstCliente'      => '',
                    'tipoDocumento'         => '',
                    'idDocumento'           => '',
                    'idVerficacionFuncional'=> ''
                );

                $return = $client->ListarDocumentosElectronicos($params);
                $return = json_decode($return->return);
                $values = $return->data;

            }else{
                $login1   = 'dcorreah';
                $password = "FE2020ev*";
                $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
                try {
                    $client = new SoapClient($wsdl_url);
                } catch (\SoapFault $e) {
                    return response($e->getMessage(), 500);
                }
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
                    'idUsuario' => '',
                    'idEstadoEnvioCliente' => '',
                    'idEstadoEnvioDian' => '',
                    'fechaInicial' => $fromdate,
                    'fechaFinal' => $todate,
                    'fechaInicialReg' => '',
                    'fechaFinalReg' => '',
                    'idEstadoGeneracion' => '',
                    'idTipoDocElectronico' => '1',
                    'numeroInicial' => '',
                    'numeroFinal' => '',
                    'idnumeracion' => '',
                    'estadoAcuse' => '',
                    'razonSocial' => '',
                    'mulCodEstDian' => '',
                    'mulCodEstCliente'  => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicos($params);
                $return = json_decode($return->return);
                $values = $return->data;
            }

            return datatables::of($values)
                ->addColumn('opciones', function($row){
                    $btn = '<div class="btn-group"> <button class="btn btn-sm btn-outline-light info_ws" id="'.$row->numero.'"><i class="fas fa-info-circle" style="color: #3085d6"></i></button>';
                    $btn = $btn.'<button class="btn btn-sm btn-outline-light download_ws" id="'.$row->numero.'" data-toggle="tooltip" data-placement="top" title="Descargar pdf"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>'.'</div>';
                    return $btn;})
                ->rawColumns(['opciones'])
                ->make(true);
        }
        return view('aplicaciones.facturacion_electronica.gestion.index');
    }


    public function comprobar_factura(Request $request){
        if ($request->ajax()){
            try {
                $errors = Array();
                $data = DB::connection('MAX')
                    ->table('CIEV_V_FE_FacturasTotalizadas')
                    ->leftJoin('CIEV_V_FE', 'CIEV_V_FE_FacturasTotalizadas.numero', '=', 'CIEV_V_FE.numero')
                    ->select('CIEV_V_FE_FacturasTotalizadas.numero as id',
                        'CIEV_V_FE_FacturasTotalizadas.identificacion as nit_cliente',
                        'CIEV_V_FE_FacturasTotalizadas.fecha as fecha',
                        'CIEV_V_FE_FacturasTotalizadas.razonsocial as razon_social',
                        'CIEV_V_FE_FacturasTotalizadas.bruto as bruto',
                        'CIEV_V_FE_FacturasTotalizadas.descuento as desc',
                        'CIEV_V_FE_FacturasTotalizadas.iva as valor_iva',
                        'CIEV_V_FE_FacturasTotalizadas.nomvendedor as vendedor',
                        'CIEV_V_FE_FacturasTotalizadas.ov as ov',
                        'CIEV_V_FE_FacturasTotalizadas.descplazo as plazo',
                        'CIEV_V_FE_FacturasTotalizadas.motivo as motivo',
                        'CIEV_V_FE.codigo_alterno as cod_alter',
                        'CIEV_V_FE_FacturasTotalizadas.subtotal as subtotal',
                        'CIEV_V_FE.emailentrega as email',
                        'CIEV_V_FE.emailcontacto as emailcontacto',
                        'CIEV_V_FE.nombres as nombres',
                        'CIEV_V_FE.apellidos as apellidos',
                        'CIEV_V_FE_FacturasTotalizadas.tipocliente as tipo_cliente')
                    ->where('CIEV_V_FE_FacturasTotalizadas.tipodoc', '=', 'CU')
                    ->where('CIEV_V_FE_FacturasTotalizadas.numero','=', $request->id)
                    ->orderBy('CIEV_V_FE_FacturasTotalizadas.numero', 'asc')
                    ->get()->first();

                if ($data == null){
                    return response()->json('Factura no encontrada en la vista CIEV_V_FE_FacturasTotalizadas', 500);
                }else{

                    if ($data->fecha == null ){
                        array_push($errors, "Factura sin fecha");
                    }
                    if ($data->plazo == null){
                        array_push($errors, "Factura sin Plazo");
                    }
                    if ($data->razon_social == null){
                        array_push($errors, "Factura sin razon social");
                    }
                    if ($data->tipo_cliente == null){
                        array_push($errors, "Falta tipo cliente");
                    }
                    if ($data->vendedor == null){
                        array_push($errors, "Falta vendedor");
                    }
                    if ($data->cod_alter == null){
                        array_push($errors, "Falta codigo alterno");
                    }
                    if (($data->desc / $data->bruto) * 100 >= 20){
                        array_push($errors, "Descuento demasiado alto");
                    }
                    if ($data->email == null || $data->email == ''){ //
                        array_push($errors, "Falta email para envio de facturas");
                    }
                    if ($data->motivo != 27 && ($data->valor_iva / $data->subtotal) * 100 <= 18.95 || ($data->valor_iva / $data->subtotal) * 100 >= 19.05 ){
                        array_push($errors, "Porcentaje de iva diferente a 19%");
                    }
                    if ($data->motivo == null){
                        array_push($errors, "Falta motivo");
                    }
                    if ($data->bruto == null){
                        array_push($errors, "Falta valor bruto");
                    }
                    if ($data->bruto >= 20000000){
                        array_push($errors, "Valor bruto demasiado alto");
                    }
                    if ($data->bruto <= 3000){
                        array_push($errors, "Valor bruto demasiado bajo");
                    }
                    if ($data->nombres == ''){
                        array_push($errors, "Faltan nombres (DMS)");
                    }
                    if ($data->emailcontacto == '' || $data->emailcontacto == null){
                        array_push($errors, "Falta email de contacto");
                    }
                    if ($data->tipo_cliente != 'ZF' && $data->tipo_cliente != 'EX' && $data->valor_iva == 0){
                        array_push($errors, "Falta el IVA");
                    }
                    return response()->json($errors, 200);
                }

            }catch (\Exception $e){
                return response($e->getMessage(), 500);
            }
        }
    }


}
