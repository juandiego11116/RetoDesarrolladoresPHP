<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesTableSeeder::class,
            CategoriesTableSeeder::class,
            CountriesTableSeeder::class,
            DocumentsTypeTableSeeder::class,
            SeederTablePermissions::class,
            SeederTableUsers::class,
            SeederTableProducts::class,
        ]);
    }
}
