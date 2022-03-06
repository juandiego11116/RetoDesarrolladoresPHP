<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SeederTableUsers extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'last_name' => 'Super',
            'id_document_type' => '1',
            'document' => '1234567890',
            'id_country' => '1',
            'address' => 'Calle 1 # 2 - 3',
            'phone_number' => '3216549872',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

        $customer = User::create([
            'name' => 'Customer',
            'last_name' => 'Customer',
            'id_document_type' => '1',
            'document' => '1234567890',
            'id_country' => '1',
            'address' => 'Calle 1 # 2 - 3',
            'phone_number' => '3216549872',
            'email' => 'customer@app.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('customer');
    }
}
