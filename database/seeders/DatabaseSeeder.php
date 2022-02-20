<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //RolesTableSeeder::class,
          //  SeederTableUsers::class,
            SeederTableProducts::class,
        ]);
    }
}
