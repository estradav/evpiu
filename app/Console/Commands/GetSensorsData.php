<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GetSensorsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensors:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lee e inserta todos las lecturas de los sensores de gas y chimenea en la DB, pd: hacer una unica vez';

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
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $this->info('*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*');
        $this->info('*   [CARGANDO] Por favor espere mientras termina la ejecucion de la tarea   *');
        $this->info('*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*');
        $this->info(' ');

        $fecha_actual = Carbon::now()->format('d-m-y');



        $registros_db = DB::table('sensor_chimeneas')
            ->whereDate('fecha','=', Carbon::now()->format('yy-m-d'))
            ->count();


        $filecontent =  Storage::disk('ftp')->get('Repositorio/GestionAmbiental/Chimenea/'.$fecha_actual);
        $filecontent = explode("\n", $filecontent);


        $data = [];
        foreach($filecontent as $line) {
            array_push($data, $line);
        }

        $stream_data = [];
        foreach($data as $line){
            array_push($stream_data, explode("\t", $line));
        }

        unset($stream_data[sizeof($stream_data)-1]);

        $contador_errors_chimenea = 0;

        for ($i = $registros_db; $i <= sizeof($stream_data) - 1; $i++){
            DB::table('sensor_chimeneas')->insert([
                'time'                      =>  $stream_data[$i][0],
                'temperature_inyecctora'    =>  $stream_data[$i][1],
                'temperature_horno'         =>  $stream_data[$i][2],
                'fecha'                     =>  Carbon::now()->format('yy-m-d')
            ]);
            if ($stream_data[$i][1] == '0,0' ||  $stream_data[$i][2] == '0,0'){
                $contador_errors_chimenea++;
            }
        }




        /* Sensor de gas */

        $registros_db_gas = DB::table('sensor_gas')
            ->whereDate('fecha','=', Carbon::now()->format('yy-m-d'))
            ->count();


        $filecontent_gas =  Storage::disk('ftp')->get('Repositorio/GestionAmbiental/MedidorGas/'.$fecha_actual);
        $filecontent_gas =  explode("\n", $filecontent_gas);


        $data_gas = [];
        foreach($filecontent_gas as $line) {
            array_push($data_gas, $line);
        }


        $stream_data_gas = [];
        foreach($data_gas as $line){
            array_push($stream_data_gas, explode("\t", $line));
        }


        unset($stream_data_gas[sizeof($stream_data_gas)-1]);
        $contador_errors_gas = 0;
        for ($i = $registros_db_gas; $i <= sizeof($stream_data_gas) - 1; $i++){
            DB::table('sensor_gas')->insert([
                'time'      =>  $stream_data_gas[$i][0],
                'lectura'   =>  $stream_data_gas[$i][1],
                'fecha'     =>  Carbon::now()->format('yy-m-d')
            ]);

            if ($stream_data_gas[$i][1] == '0,0'){
                $contador_errors_gas++;
            }
        }


        /* Enviar un correo electronico si hay mas de 3 registros en 0 */
        if ($contador_errors_gas > 3 || $contador_errors_chimenea > 3){
            $subject = "SENSORES APAGADOS";
            Mail::send('mails.automatic_task.sensors_off',[], function($msj) use($subject){
                $msj->from("notificacionesitciev@gmail.com","Notificaciones EV-PIU");
                $msj->subject($subject);
                $msj->to(['auxsistemas@estradavelasquez.com','sistemas@estradavelasquez.com']);
                $msj->cc("dcorrea@estradavelasquez.com");
            });
        }

        $this->info('*---*---*---*---*---*---*---*---*---*---*---*---*---*');
        $this->info('*    [TERMINADO] Proceso terminado correctamente!   *');
        $this->info('*---*---*---*---*---*---*---*---*---*---*---*---*---*');

    }
}
