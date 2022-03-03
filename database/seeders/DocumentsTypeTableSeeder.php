<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentsTypeTableSeeder extends Seeder
{
    public function run():void
    {
        DocumentType::create([
            'name' => 'Cedula de Ciudadania',
        ]);
        DocumentType::create([
            'name' => 'Passport',
        ]);
    }
}
