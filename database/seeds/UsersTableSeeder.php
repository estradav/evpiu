<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            User::create([
                'name'           => 'Administrador',
                'email'          => 'admin@evpiu.com',
                'password'       => bcrypt('password'),
                'remember_token' => str_random(60),
            ]);
        }
    }
}
