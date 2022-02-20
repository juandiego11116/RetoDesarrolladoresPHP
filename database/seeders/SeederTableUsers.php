<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SeederTableUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'last_name' => 'Super',
            'document_type' => 'CC',
            'document' => '1234567890',
            'country' => 'Colombia',
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
            'document_type' => 'CC',
            'document' => '1234567890',
            'country' => 'Colombia',
            'address' => 'Calle 1 # 2 - 3',
            'phone_number' => '3216549872',
            'email' => 'customer@app.com',
            'password' => bcrypt('12345678'),
            'email_verified_at' => now(),
        ]);
        $customer->assignRole('user');
    }
}
