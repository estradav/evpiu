<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PermisionFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:folder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Da permisos a las carpetas storage, boostrap y cache.';

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
       echo shell_exec('sudo chmod -R 777 /var/www/evpiu/storage');
    }
}
