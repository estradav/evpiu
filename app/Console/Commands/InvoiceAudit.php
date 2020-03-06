<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psy\Exception\Exception;
use SoapClient;
use SoapFault;

class InvoiceAudit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia por correo electronico una lista de facturas faltantes por subir a la Dian';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws SoapFault
     */
    public function handle()
    {
        try {
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
            $array = [];

            foreach ($values as $value){
                array_push($array, $value->numero);
            }


            sort($array);
            $missing = [];

            for ($i = 1; $i < count($array); $i++ ){
                if ($array[$i] - $array[$i-1] != 1){
                    $x = $array[$i] - $array[$i-1];
                    $j = 1;
                    while ($j < $x){
                        array_push($missing, $array[$i-1]+$j);
                        $j++;
                    }
                }
            }


            Log::info('[TAREAS AUTOMATICAS]: Auditoria de facturacion electronica');

            $subject = "AUDITORIA DE FACTURACION ELECTRONICA";
            Mail::send('mails.automatic_task.invoice_audit',['missing' => $missing], function($msj) use($subject){
                $msj->from("dcorrea@estradavelasquez.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to(['dcorrea@estradavelasquez.com','adcano@estradavelasquez.com','auxsistemas@estradavelasquez.com']);
                $msj->cc("dcorrea@estradavelasquez.com");
            });
        }catch(Exception $e){
            Log::emergency('[TAREAS AUTOMATICAS]:'. $e->getMessage());
        }
    }
}
