<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\SeederTablePermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexToUsersForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('show-user');

        $response = $this->actingAs($user)
            ->get(route('users.index'));

        $response->assertViewIs('users.index');
    }

    public function testViewCreateUser(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('create-user');

        $response = $this->actingAs($user)
            ->get(route('users.create'));

        $response->assertViewIs('users.create');
    }

    public function testStoreUserForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $userForSave = User::factory()->make();
        $user->assignRole('admin');
        $user->givePermissionTo('create-user');

        $response = $this->actingAs($user)
            ->post(route('users.store'), [
                'name' => $userForSave->name,
                'last_name' => $userForSave->last_name,
                'id_document_type' => $userForSave->id_document_type,
                'document' => $userForSave->document,
                'id_country' => $userForSave->id_country,
                'address' => $userForSave->address,
                'phone_number' => $userForSave->phone_number,
                'email' => $userForSave->email,
                'password' => '12345678',

            ]);

        $response->assertRedirect();
    }
    public function testGoToViewEditUser(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $userForEdit = User::factory()->create();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('edit-user');

        $response = $this->actingAs($user)
            ->get(route('users.edit', ['user' => $userForEdit]));

        $response->assertViewIs('users.edit');
        $this->assertEquals($userForEdit->id, $response['user']->id);
    }

    public function testUpdateUserForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $userForEdit = User::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('edit-user');

        $response = $this->actingAs($user)
            ->patch(route('users.update', $userForEdit), [
                'name' => $userForEdit->name,
                'last_name' => $userForEdit->last_name,
                'id_document_type' => $userForEdit->id_document_type,
                'document' => $userForEdit->document,
                'id_country' => $userForEdit->id_country,
                'address' => $userForEdit->address,
                'phone_number' => $userForEdit->phone_number,
                'email' => $userForEdit->email,
                'password' => '12345678',
                'roles' => 'customer'
            ]);

        $response->assertRedirect();
    }

    public function testForDeleteUserForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $userForDelete = User::factory()->create();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('delete-user');

        $response = $this->actingAs($user)
            ->delete(route('users.destroy', ['user' => $userForDelete]));

        $response->assertRedirect(route('users.index'));
    }
}
