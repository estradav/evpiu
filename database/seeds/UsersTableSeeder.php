<?php

use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'           => 'Administrador',
            'email'          => 'admin@evpiu.com',
            'username'       => 'administrator',
            'password'       => bcrypt('password'),
            'remember_token' => str_random(60),
        ]);

        $user->assignRole('user');
        $user->assignRole('super-admin');

        $user = User::create([
            'name'           => 'Usuario',
            'email'          => 'user@evpiu.com',
            'username'       => 'user',
            'password'       => bcrypt('password'),
            'remember_token' => str_random(60),
        ]);

        $user->assignRole('user');
    }
}
