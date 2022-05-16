<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Database\Seeders\SeederTablePermissions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGoToIndex(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();
        Product::factory()->create();
        $user->assignRole('admin');


        $response = $this->actingAs($user)
            ->get(route('reports.index'));

        $response->assertViewIs('reports.index');
    }

    public function testImportProduct(): void
    {
        $this->seed(SeederTablePermissions::class);
        $this->seed(RolesTableSeeder::class);
        $user = User::factory()->create();

        $user->assignRole('admin');

        Storage::fake('products');
        $file = new File('tests\Feature\stubs\products-import.cvs');

        /*$response = $this->actingAs($user)->json('POST', 'reports/import/product', [
            'products' => UploadedFile::fake()->create('products-import.cvs')
        ]);*/
        $response =  $this->actingAs($user)
            ->post(route('reports/import/product'), $file);
        dd($response);
        $path = base_path('tests\Feature\stubs');
        Storage::disk('products')->assertExists($path, 'products-import.cvs');


        /*


        Excel::assertQueued('products-import.cvs', 'local');*/

        //$path = base_path('tests\Feature\stubs\products-import.cvs');
        //$importFile = new UploadedFile($path, 'products-import.cvs', null, null, true);

        //$this->post('reports/import/product', ['file' => $importFile]);

        //$this->assertDatabaseHas('products', ['name' => 'Guayaba', 'stock_number' => 1000]);
    }
}
