<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use SoapClient;
class GestionFacturacionElectronicaController extends Controller
{
    public function index(Request $request)
    {
        $fromdate = Carbon::now()->format('Y-m-d');
        $todate = Carbon::now()->format('Y-m-d');

        if (request()->ajax()) {
            if (!empty($request->from_date) || !empty($requsalidaest->fe_start)) {
                $login1 = $request->Username;
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
                    'tipoDocumento'         => '',
                    'idDocumento'           => '',
                    'idVerficacionFuncional'=> ''
                );

                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);
                $values = $return->data;

            }else{
                $login1 = $request->Username;
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
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);

                $values = $return->data;
            }
            return datatables::of($values)
                ->addColumn('opciones', function($row){
                $btn = '<div class="btn-group"> <button class="btn btn-sm btn-outline-light info_ws" id="'.$row->numero.'"><i class="fas fa-info-circle"></i></button>';
                $btn = $btn.'<button class="btn btn-sm btn-outline-light download_ws" id="'.$row->DT_RowId.'"><i class="far fa-file-pdf"></i></button>'.'</div>';
                return $btn;})
                ->rawColumns(['opciones'])
                ->make(true);
        }
       return view('FacturacionElectronica.AuditoriaFE.index');
    }

    public function DownloadPdf(Request $request)
    {
        $Numero_Factura = $request->id;

        $login1 = $request->Username;
        $password = "FE2020ev*";
        $wsdl_url = "https://factible.fenalcoantioquia.com/FactibleWebService/FacturacionWebService?wsdl";
        $client = new SoapClient($wsdl_url);
        $client->__setLocation($wsdl_url);

        // Inicio de sesion
        $params = array(
            'login' => $login1,
            'password' => $password
        );

        $auth = $client->autenticar($params);
        $respuesta = json_decode($auth->return);
        $token = $respuesta->data->salida;

        $params = array(
            'token'                     => $token,
            'iddocumentoelectronico'    => $Numero_Factura,
        );

        $return = $client->descargarDocumentoElectronico_VersionGrafica($params);

        $resultados = json_decode($return->return);

        //cerramos sesion
        $params = array(
            'token' => $token
        );
        $logout = $client->cerrarSesion($params);
        $respuesta = json_decode($logout->return);

        return response()->json($resultados->data->salida);
    }

    public function InfoWs(Request $request)
    {
        $id = $request->id;

        if (request()->ajax()) {
            $login1 = $request->Username;
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
                'numeroInicial' => $id,
                'numeroFinal' => $id,
                'idnumeracion' => '',
                'estadoAcuse' => '',
                'razonSocial' => '',
                'mulCodEstDian' => '',
                'tipoDocumento' => '',
                'idDocumento' => '',
                'idVerficacionFuncional' => ''
            );
            $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
            $return = json_decode($return->return);

            $values = $return->data[0];

            return response()->json($values);
        }
    }

    public function ListadeFacturas(Request $request)
    {
        $fromdate = Carbon::now()->format('Y-m-d');
        $todate = Carbon::now()->format('Y-m-d');


        if (request()->ajax()) {
            if (!empty($request->from_date) || !empty($request->fe_start)) {
                $login1 = $request->Username;
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
                    'fechaInicial' => strval($request->from_date),
                    'fechaFinal' => strval($request->to_date),
                    'fechaInicialReg' => '',
                    'fechaFinalReg' => '',
                    'idEstadoGeneracion' => '',
                    'idTipoDocElectronico' => $request->type_doc,
                    'numeroInicial' => $request->fe_start,
                    'numeroFinal' => $request->fe_end,
                    'idnumeracion' => '',
                    'estadoAcuse' => '',
                    'razonSocial' => '',
                    'mulCodEstDian' => '',
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);
                $values = $return->data;

                return response()->json($values);

            } else {
                $login1 = $request->Username;
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
                    'tipoDocumento' => '',
                    'idDocumento' => '',
                    'idVerficacionFuncional' => ''
                );
                $return = $client->ListarDocumentosElectronicosSuperAdmin($params);
                $return = json_decode($return->return);
                $values = $return->data;

                return response()->json($values);
            }
        }
    }
}
