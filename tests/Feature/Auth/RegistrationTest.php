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
            'lastName' => 'Test',
            'document_type' => 'cc',
            'document' => '1010101010',
            'country' => 'Colombia',
            'address' => 'Calle',
            'phoneNumber' => '3200000000',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'lastName' => 'Test',
            'document_type' => 'cc',
            'document' => '1010101010',
            'country' => 'Colombia',
            'address' => 'Calle',
            'phoneNumber' => '3200000000',
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
