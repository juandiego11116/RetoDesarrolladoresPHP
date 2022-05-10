<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'last_name' => 'Test',
            'id_document_type' => '1',
            'document' => '1010101010',
            'id_country' => '1',
            'address' => 'Calle',
            'phone_number' => '3200000000',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'last_name' => 'Test',
            'id_document_type' => '1',
            'document' => '1010101010',
            'id_country' => '1',
            'address' => 'Calle',
            'phone_number' => '3200000000',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
