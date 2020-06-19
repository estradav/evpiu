<?php

namespace App\Http\Controllers\FacturacionElectronica;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SoapClient;
use Yajra\DataTables\DataTables;

class GestionController extends Controller
{

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
                    $btn = $btn.'<button class="btn btn-sm btn-outline-light download_ws" id="'.$row->numero.'"><i class="fas fa-file-pdf" style="color: #FF0000"></i></button>'.'</div>';
                    return $btn;})
                ->rawColumns(['opciones'])
                ->make(true);
        }

        return view('aplicaciones.facturacion_electronica.gestion.index');
    }
}
