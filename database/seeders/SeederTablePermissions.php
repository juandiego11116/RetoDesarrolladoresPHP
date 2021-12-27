<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //roles permissions
            'showRole',
            'createRole',
            'editRole',
            'deleteRole',
            //product permissions
            'showProduct',
            'createProduct',
            'editProduct',
            'deleteProduct',

        ];
        foreach ($permissions as $permission) {
            Permission::create(['name'=>$permission]);
        }
    }
}
