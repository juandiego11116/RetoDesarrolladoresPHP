<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\SeederTablePermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexToRolesForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('show-role');

        $response = $this->actingAs($user)
            ->get(route('roles.index'));

        $response->assertViewIs('roles.index');
    }

    public function testViewCreateUser(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');
        $user->givePermissionTo('create-role');

        $response = $this->actingAs($user)
            ->get(route('roles.create'));

        $response->assertViewIs('roles.create');
    }

    public function testStoreRoleForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $role = 'create-product';
        $user->assignRole('admin');
        $user->givePermissionTo('create-role');


        $response = $this->actingAs($user)
            ->post(route('roles.store'), [
                'name' => $role,
            ]);

        $response->assertRedirect();
    }

    public function testGoToViewEditRole(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $roleForEdit = Role::all();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('edit-role');

        $response = $this->actingAs($user)
            ->get(route('roles.edit', ['role' => $roleForEdit[1]]));

        $response->assertViewIs('roles.edit');
        $this->assertEquals($roleForEdit[1]->id, $response['role']->id);
    }

    public function testUpdateRoleForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        $roleForEdit = Role::all();
        $user->assignRole('admin');
        $user->givePermissionTo('edit-role');

        $response = $this->actingAs($user)
            ->patch(route('roles.update', $roleForEdit[1]), [
                    'name' => $roleForEdit[1]->name,
            ]);

        $response->assertRedirect();
    }

    public function testForDeleteRoleForAdmin(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $RoleForDelete = Role::all();
        $user = User::factory()->create();

        $user->assignRole('admin');
        $user->givePermissionTo('delete-role');

        $response = $this->actingAs($user)
            ->delete(route('roles.destroy', ['role' => $RoleForDelete[1]]));

        $response->assertRedirect(route('roles.index'));
    }
}
