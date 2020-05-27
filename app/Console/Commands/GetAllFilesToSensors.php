<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GetAllFilesToSensors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sensors:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Obtiene todos los datos de los archivos de los sensores de chimeneas y gas';

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
        $this->info('*  [CARGANDO] Por favor espere mientras termina la ejecucion de la tarea    *');
        $this->info('*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*---*');
        $this->info(' ');

        $list_to_files = Storage::disk('ftp')->files('Repositorio/GestionAmbiental/Chimenea');

        foreach ($list_to_files as $file){
            $filecontent =  Storage::disk('ftp')->get($file);
            $filecontent =  explode("\n", $filecontent);

            $date = explode('/', $file);
            $date = explode('-', $date[3]);
            $date = "20".$date[2]."-".$date[1]."-".$date[0];

            $data = [];

            foreach($filecontent as $line) {
                array_push($data, $line);
            }

            $stream_data = [];
            foreach($data as $line){
                array_push($stream_data, explode("\t", $line));
            }

            unset($stream_data[sizeof($stream_data)-1]);

            foreach($stream_data as $line){
                if(array_key_exists(1,$line)){
                    DB::table('sensor_chimeneas')->insert([
                        'time'                      =>  $line[0],
                        'temperature_inyecctora'    =>  $line[1],
                        'temperature_horno'         =>  $line[2],
                        'fecha'                     =>  $date
                    ]);
                }else{
                    continue;
                }
            }
        }


        $list_to_files_gas =  Storage::disk('ftp')->files('Repositorio\GestionAmbiental\MedidorGas');
        foreach ($list_to_files_gas as $file){
            $filecontent =  Storage::disk('ftp')->get($file);
            $filecontent = explode("\n", $filecontent);

            $date = explode('/', $file);
            $date = explode('-', $date[3]);
            $date = "20".$date[2]."-".$date[1]."-".$date[0];


            $data = [];
            foreach($filecontent as $line) {
                array_push($data, $line);
            }

            $stream_data = [];
            foreach($data as $line){
                array_push($stream_data, explode("\t", $line));
            }

            unset($stream_data[sizeof($stream_data)-1]);

            foreach($stream_data as $line){
                if(array_key_exists(1,$line)){
                    DB::table('sensor_gas')->insert([
                        'time'      =>  $line[0],
                        'lectura'   =>  $line[1],
                        'fecha'     =>  $date
                    ]);
                }else{
                    continue;
                }

            }
        }

    }
}
