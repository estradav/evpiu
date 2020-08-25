<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExitAllEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exit:employees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambia el estado de todos los empleados en la aplicacion medida de prevencion';

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
        DB::table('employee_prevention')
            ->update([
                'state' => '0'
            ]);
    }
}
