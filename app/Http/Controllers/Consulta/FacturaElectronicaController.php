<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Egulias\EmailValidator\Exception\AtextAfterCFWS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SoapClient;

class FacturaElectronicaController extends Controller
{
    public function index(){
        return view('aplicaciones.consultas.factura_electronica.index');
    }

    public function obtener_factura(Request $request){
        if ($request->ajax()){
            try {
                $data = $this->validar_documento($request->id);
                if (Auth::user()->hasRole('super-admin')){
                    if (empty($data)){
                        return response()->json([
                            'code' => 101,
                            'data' => 'El documento electrónico seleccionado aún no ha sido subido a la plataforma de la Dian o no está disponible en este momento.'
                        ], 200);
                    }else{
                        return response()->json([
                            'code' => 102,
                            'data' => $data[0]
                        ], 200);
                    }
                }else{
                    $result = DB::connection('MAX')
                        ->table('CIEV_V_FE_FacturasTotalizadas')
                        ->where('NUMERO', '=', $request->id)
                        ->pluck('CODVENDEDOR')->first();


                    if (trim($result) == Auth::user()->codvendedor){
                        if (empty($data)){
                            return response()->json([
                                'code' => 101,
                                'data' => 'El documento electrónico seleccionado aún no ha sido subido a la plataforma de la Dian o no está disponible en este momento.'
                            ], 200);
                        }else{
                            return response()->json([
                                'code' => 102,
                                'data' => $data[0]
                            ], 200);
                        }
                    }else{
                        return response()->json([
                            'code' => 100,
                            'data' => 'No tiene permisos para ver el documento electrónico seleccionado, si cree que se trata de un error por favor comuníquese con el área de sistemas.'
                        ], 200);
                    }
                }
            }catch (\Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
    }


    private function validar_documento($numero_factura){
        $login1   = "dcorreah";
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
            'numeroInicial' => $numero_factura,
            'numeroFinal' => $numero_factura,
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

        return $return->data;
    }

}
