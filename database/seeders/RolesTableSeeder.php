<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{

    public function run():void
    {
        Role::create([
            'name' => 'admin',
            'guard_name' => config('auth.defaults.guard')
        ]);
        Role::create([
            'name' => 'customer',
            'guard_name' => config('auth.defaults.guard')
        ]);
    }
}
