<?php

use Illuminate\Database\Seeder;
use App\PermissionGroup;

class PermissionGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionGroup = PermissionGroup::create([
            'name' => 'Estándar',
        ]);
    }
}
