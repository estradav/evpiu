<?php

namespace App\Console\Commands;

use App\EncabezadoPedido;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ReplaceDataEncabezadoPedidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pedidos:repu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reemplaza el nombre de usuario por un id en el encabezado de los pedidos';

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
     * @return int
     */
    public function handle(){
        $options = [
            1 => 'Reemplazar',
            2 => 'Eliminar columnas',
            3 => 'Salir',
        ];


        $question = $this->choice(
            'Este comando reemplaza o eliminar columnas de la tabla * encabezado_pedidos *, por favor escoga una opcion',
            $options, false,  1, false
        );


        if ($question == 'Reemplazar') {
            $pedidos = EncabezadoPedido::all();
            $this->question('Reemplazando datos... Un momento por favor...');

            foreach ($pedidos as $pedido){
                $user_id = User::where('name', $pedido->NombreVendedor)->first();

                if ($user_id) {
                    $pedido->vendedor_id = $user_id->id;
                    $pedido->save();
                }
            }
            $this->question('La informacion fue reemplazada con exito!');
        }elseif ($question == 'Eliminar columnas'){
            $this->info('Eliminando columnas...');

            Artisan::call('migrate', array('--path' => 'database/other_migrations/pedidos/2020_10_15_154227_drop_user_values_to_encabezado_pedidos_table.php'));

            $this->question('Columnas eliminadas con exito!');
        }else {
            $this->question('No se realizo ninguna accion');
        }


    }
}
