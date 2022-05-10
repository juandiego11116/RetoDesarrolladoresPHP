<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablePermissions extends Seeder
{
    public function run(): void
    {
        $permissions = [
            //roles permissions
            'show-role',
            'create-role',
            'edit-role',
            'delete-role',
            //product permissions
            'show-product',
            'create-product',
            'edit-product',
            'delete-product',
            //user permissions
            'show-user',
            'create-user',
            'edit-user',
            'delete-user',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
