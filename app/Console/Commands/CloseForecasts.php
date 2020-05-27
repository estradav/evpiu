<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Psy\Exception\Exception;

class CloseForecasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'close:forecasts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cierra los pronosticos.';

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
     */
    public function handle()
    {
        try {
            $Pronosticos = DB::connection('MAX')
                ->table('CIEV_V_Pronosticos')
                ->where('Estado', '=', '3')->pluck('NumeroPronostico');

            $EstadoOp = [];
            foreach ($Pronosticos as $pronostico) {
                $EstadoOp[$pronostico] = DB::connection('MAX')
                    ->table('CIEV_V_OP_Pronosticos_v1')
                    ->where('Pronostico', '=', $pronostico)
                    ->select('Pronostico', 'EstadoOP')->get();
            }

            $recuento = [];
            foreach ($EstadoOp as $OP) {
                if (count($OP) != 0) {
                    $bandera = 1;

                    foreach ($OP as $p) {
                        if (trim($p->EstadoOP) == 3) {
                            $bandera = 0;
                        }

                    }
                    if ($bandera == 1) {
                        $recuento[] = $OP[0]->Pronostico;
                    }
                }
            }


            foreach ($recuento as $pronostico) {
                DB:: beginTransaction();

                try {
                    DB::connection('MAX')->table('Order_Master')->where('ORDNUM_10', '=', $pronostico)->update([
                        'STATUS_10' => '4'
                    ]);

                    DB::connection('MAX')->table('Requirement_Detail')->where('ORDNUM_11', '=', $pronostico)->update([
                        'STATUS_11' => '4'
                    ]);
                } catch (\Exception $e) {
                    DB::rollback();
                    echo json_encode(array(
                        'error' => array(
                            'msg' => $e->getMessage(),
                            'code' => $e->getCode(),
                            'code2' => $e->getLine(),
                        ),
                    ));
                }
            }

            Log::info('[TAREAS AUTOMATICAS]: Pronosticos cerrados correctamente');

            $subject = "PRONOSTICOS CERRADOS";
            Mail::send('mails.automatic_task.close_forecast',[], function($msj) use($subject){
                $msj->from("notificacionesitciev@gmail.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to(['auxsistemas@estradavelasquez.com','sistemas@estradavelasquez.com']);
                $msj->cc("dcorrea@estradavelasquez.com");
            });


        } catch(Exception $e){
            Log::emergency('[TAREAS AUTOMATICAS]:'. $e->getMessage());

            $subject = "ERROR AL CERRAR PRONOSTICOS";
            Mail::send('mails.automatic_task.fail_close_forecast',[], function($msj) use($subject){
                $msj->from("notificacionesitciev@gmail.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to(['auxsistemas@estradavelasquez.com','sistemas@estradavelasquez.com']);
                $msj->cc("dcorrea@estradavelasquez.com");
            });
        }
    }
}
