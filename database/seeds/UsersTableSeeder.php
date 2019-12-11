<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Str;
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
            'menu'           => 'administrator',
            'Codvendedor'    => '999',
            'password'       => bcrypt('password'),
            'remember_token' => Str::random(60),
        ]);

        $user->assignRole('user');
        $user->assignRole('super-admin');

        $user = User::create([
            'name'           => 'Usuario',
            'email'          => 'user@evpiu.com',
            'username'       => 'user',
            'menu'           => 'user',
            'Codvendedor'    => '999',
            'password'       => bcrypt('password'),
            'remember_token' => Str::random(60),
        ]);

        $user->assignRole('user');
    }
}
