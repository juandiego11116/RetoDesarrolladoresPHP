<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class SeederTableProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(20)->create();
    }
}
