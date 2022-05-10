<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Fruit',
        ]);
        Category::create([
            'name' => 'Vegetables',
        ]);
    }
}
