<?php

namespace Tests\Feature\Products;
use  Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Products\Contracts\ProductDetailRepositoryInterface;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Tests\TestCase;

class ProductTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_create_product(): void
    {
        $gallery = [
            ['path' => 'gallery/1781789828439-019edaf2-5011-75c3-8299-c6a99ed47a7a.png'],
            ['path' => 'gallery/1781813412363-019edc59-73a5-7529-9ce0-3b38dcff8c11.png']
        ];

        $product = Product::factory()->make();
        $category = \Modules\Categories\Models\Category::factory()->create(); // namespace رو مطابق پروژه‌ات تنظیم کن
        $brand = \Modules\Brands\Models\Brand::factory()->create();        // namespace رو مطابق پروژه‌ات تنظیم کن

        $response = $this->actingAs($this->admin)
            ->post('api/admin/products', [
                'title' => $product->title,
                'en_title' => $product->en_title,
                'description' => $product->description,
                'content' => $product->content,
                'status' => 0,
                'category_id' => $category->id,
                'weight' => 100,
                'gallery' => $gallery,
                'product_dimensions' => 'small',
                'keywords' => 'tag1,tag2',
                'fake' => 'true',
                'brand_id' => $brand->id
            ]);

        $response->assertStatus(200);
    }
    public function test_update(): void
    {
        $title = Str::random(10);

        $product = Product::factory()->create();

        $productArray = $product->toArray();

        $detail = app(ProductDetailRepositoryInterface::class)->getDetail($productArray['id']);

        $productArray['title'] = $title;
        $productArray = array_merge($productArray, $detail ?? []);

        $response = $this->actingAs($this->admin)
            ->put('api/admin/products/' . $productArray['id'], $productArray);

        $this->assertTrue(
            app(ProductRepositoryInterface::class)->exists([
                'id' => $productArray['id'],
                'title' => $title
            ])
        );
        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $product = Product::factory()->create([
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->get('api/admin/products/' . $product->id);

        $this->assertEquals($response->json()['id'], $product->id);
        $response->assertStatus(200);
    }
    public function test_index():void{
        $response = $this->actingAs($this->admin)
            ->get('api/admin/products');
        $this->assertArrayHasKey('data',$response->json());
        $response->assertStatus(200);
    }

    public function test_destroy(): int
    {
        $product = Product::factory()->create([
            'user_id' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->delete('api/admin/products/' . $product->id);

        $this->assertFalse(app(ProductRepositoryInterface::class)->exists([
            'id' => $product->id,
            'deleted_at' => null
        ]));

        $response->assertStatus(200);
        return $product->id;
    }
    #[\PHPUnit\Framework\Attributes\Depends('test_destroy')]
    public function test_restore(): void
    {
        $product = Product::factory()->create([
            'user_id' => $this->admin->id,
        ]);
        $product->delete();

        $response = $this->actingAs($this->admin)
            ->post('api/admin/products/' . $product->id . '/restore');

        $this->assertTrue(app(ProductRepositoryInterface::class)->exists([
            'id' => $product->id,
            'deleted_at' => null
        ]));

        $response->assertStatus(200);
    }
}

