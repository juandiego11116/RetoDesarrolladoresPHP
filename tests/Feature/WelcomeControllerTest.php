<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    use RefreshDatabase;
    public function testIndexWelcome()
    {
        $response = $this->get(route('welcome'));

        $response->assertOk();
        $response->assertViewIs('welcome');
    }
}
