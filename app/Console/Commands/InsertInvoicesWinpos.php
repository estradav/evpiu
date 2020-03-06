<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Psy\Exception\Exception;

class InsertInvoicesWinpos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insertinvoices:winpos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Valida y sube las facturas generada de winpos a dms, ademas envia un correo electronico con las facturas que no pudieron ser subidas';

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

            //

        }catch(Exception $e){
            Log::emergency($e->getMessage());
        }
    }
}
