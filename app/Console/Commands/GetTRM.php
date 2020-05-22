<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psy\Exception\Exception;
use SoapClient;
use SoapFault;

class GetTRM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:trm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene el TRM diario atravez del web service de superfinanciera';

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
        $date = date("Y-m-d");

        try {
            $soap = new soapclient("https://www.superfinanciera.gov.co/SuperfinancieraWebServiceTRM/TCRMServicesWebService/TCRMServicesWebService?WSDL", array(
                'soap_version'   => SOAP_1_1,
                'trace' => 1,
                "location" => "http://www.superfinanciera.gov.co/SuperfinancieraWebServiceTRM/TCRMServicesWebService/TCRMServicesWebService",
            ));
            $response = $soap->queryTCRM(array('tcrmQueryAssociatedDate' => $date));
            $response = $response->return;

            if($response->success){
                $tasa = 1 / $response->value;
                DB::connection('MAX')
                    ->table('code_master')
                    ->where('CDEKEY_36','=','CURR')
                    ->where('CODE_36','=','US')->update([
                        'EXCRTE_36'         => $tasa,
                        'UDFKEY_36'         => $response->value,
                        'UDFREF_36'         => date("d-m-Y"),
                        'ModifiedBy'        => 'Evpiu',
                        'ModificationDate'  => Carbon::now()
                    ]);

                DB::connection('DMS')->table('monedas_factores')->insert([
                   'moneda' => 'US',
                   'fecha'  => Carbon::now()->format('Y-m-d 00:00:00'),
                   'factor' => $response->value
                ]);

                Log::info('[TAREAS AUTOMATICAS]: TRM Obtenido correctamente');

                $subject = "TRM SUBIDO CORRECTAMENTE";
                Mail::send('mails.automatic_task.trm',[], function($msj) use($subject){
                    $msj->from("dcorrea@estradavelasquez.com","Notificaciones EV-PIU");
                    $msj->subject($subject);
                    $msj->to(['auxsistemas@estradavelasquez.com','sistemas@estradavelasquez.com']);
                    $msj->cc("dcorrea@estradavelasquez.com");
                });

            }
        } catch(Exception $e){
            Log::emergency('[TAREAS AUTOMATICAS]: '. $e->getMessage());
            $subject = "ERROR AL SUBIR TRM";
            Mail::send('mails.automatic_task.fail_trm',[], function($msj) use($subject){
                $msj->from("dcorrea@estradavelasquez.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to(['auxsistemas@estradavelasquez.com','sistemas@estradavelasquez.com']);
                $msj->cc("dcorrea@estradavelasquez.com");
            });
        }
    }
}
