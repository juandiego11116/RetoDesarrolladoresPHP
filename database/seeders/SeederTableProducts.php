<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class SeederTableProducts extends Seeder
{
    public function run():void
    {
        Product::factory(20)->create();
    }
}
