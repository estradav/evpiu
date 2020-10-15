<?php

namespace App\Console\Commands;

use App\EncabezadoPedido;
use App\InfoAreaPedido;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ReplaceDataPedidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pedidos:rda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para remplazar datos en la tabla pedidos detalle area';

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
     * @return void
     */
    public function handle()
    {
        $options = [
            1 => 'Reemplazar',
            2 => 'Eliminar columnas',
            3 => 'Salir',
        ];


        $question = $this->choice(
            'Este comando reemplaza o eliminar columnas de la tabla * pedidos_detalle_area *, por favor escoga una opcion',
            $options, false,  1, false
        );

        if ($question == 'Reemplazar') {
            $pedidos = InfoAreaPedido::all();

            $this->info('Reemplazando datos... Un momento por favor.');

            foreach ($pedidos as $pedido){
                $user_id = User::where('name', $pedido->AproboCartera)->first();
                if ($user_id) {
                    $pedido->aprobo_cartera = $user_id->id;
                    $pedido->save();
                }


                $user_id = User::where('name', $pedido->AproboCostos)->first();
                if ($user_id) {
                    $pedido->aprobo_costos = $user_id->id;
                    $pedido->save();
                }


                $user_id = User::where('name', $pedido->AproboProduccion)->first();
                if ($user_id) {
                    $pedido->aprobo_produccion = $user_id->id;
                    $pedido->save();
                }


                $user_id = User::where('name', $pedido->AproboBodega)->first();
                if ($user_id) {
                    $pedido->aprobo_bodega = $user_id->id;
                    $pedido->save();
                }
            }


            $this->question('La informacion fue reemplazada con exito!');

        }
        else if ($question == 'Eliminar columnas') {
            $this->info('Eliminando columnas...');

            Artisan::call('migrate', array('--path' => 'database/other_migrations/pedidos'));

            $this->question('Columnas eliminadas con exito!');
        }else{
            $this->question('No se realizo ninguna accion');
        }
    }
}
