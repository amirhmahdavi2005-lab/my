<?php

namespace Brands;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;
use Tests\TestCase;
use Modules\Brands\Models\Brand;
use Modules\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BrandTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin Test',
            'username' => 'admin_test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }

    public function test_create_brand(): void
    {
        $brand = Brand::factory()->make()->toArray();

        $response = $this->actingAs($this->admin)
            ->postJson('/api/admin/brands', $brand);
        $lasted = app(BrandRepositoryInterface::class)->latest('id');
        $this->assertNull($lasted->icon);
        $response->assertStatus(200);
    }

    public function test_upload_icon_for_create(): void
    {
        $data = Brand::factory()->make()->toArray();
        $data['icon'] = UploadedFile::fake()->image('icon.png');
        $response = $this->actingAs($this->admin)->post('api/admin/brands', $data);
        $lasted = app(BrandRepositoryInterface::class)->latest('id');
        $this->assertNotNull($lasted->icon);
        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $brand = Brand::factory()->create();

        $data = $brand->toArray();
        unset($data['icon']);
        $data['name'] = Str::random(5);
        $data['english_name'] = $brand->english_name;

        $response = $this->actingAs($this->admin)
            ->put('/api/admin/brands/' . $brand->id, $data);

        $response->assertStatus(200);

        $this->assertTrue(
            app(BrandRepositoryInterface::class)->exists([
                'id' => $brand->id,
                'name' => $data['name'],
            ])
        );

    }

    public function test_index(): void
    {
        Brand::factory()->create();

        $response = $this->actingAs($this->admin)->get('/api/admin/brands');

        $body = $response->json();

        $this->assertArrayHasKey('data', $body);
        $this->assertGreaterThan(0, sizeof($body['data']));
        $response->assertStatus(200);
    }

    public function test_index_search(): void
    {
        Brand::factory()->create([
            'name' => 'idehpardazanjavn',
            'deleted_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)
            ->get('api/admin/brands?trashed=true&name=idehpardazan');

        $this->assertArrayHasKey('data', $response->json());

        $count = app(BrandRepositoryInterface::class)
            ->countTrashedCategoriesByText('idehpardazan');

        $this->assertEquals($response->json()['total'], $count);

        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get('api/admin/brands/' . $brand->id);

        $this->assertEquals($response->json()['id'], $brand->id);

        $response->assertStatus(200);
    }

    public function test_destroy(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete('api/admin/brands/' . $brand->id);

        $response->assertStatus(200);

        $this->assertFalse(
            app(BrandRepositoryInterface::class)->exists([
                'id' => $brand->id,
                'deleted_at' => null
            ])
        );
    }

    public function test_restore(): void
    {
        $brand = Brand::factory()->create();

        $brand->delete(); // مهم: واقعی soft delete

        $response = $this->actingAs($this->admin)
            ->post('api/admin/brands/' . $brand->id . '/restore');

        $response->assertStatus(200);

        $this->assertTrue(
            app(BrandRepositoryInterface::class)->exists([
                'id' => $brand->id,
                'deleted_at' => null
            ])
        );
    }

    public function test_all()
    {
        $response = $this->actingAs($this->admin)->get('/api/admin/brands');

        $body = $response->json();

        $brandsCount = sizeof(app(BrandRepositoryInterface::class)->getAll());

        $this->assertEquals($brandsCount, sizeof($body['data']));

        $response->assertStatus(200);
    }

    public function test_get_brand_categories()
    {
        $category = Category::factory()->create();

        $brand = Brand::factory()->create([
            'categories' => $category->id
        ]);

        $response = $this->get('api/brand/' . $brand->english_name . '/categories');
        $this->assertCount(1, ($response->json()));
        $response->assertStatus(200);
    }
}
