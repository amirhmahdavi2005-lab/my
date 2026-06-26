<?php

namespace Tests\Feature\pricevariation;

use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Models\Category;
use Modules\pricevariation\Models\CategoryPriceVariationItems;
use Modules\users\Models\User;
use Tests\TestCase;

class CategoryVariationsTest extends TestCase
{
    protected User $admin;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();

        // یه category مشترک برای همه تست‌ها بساز و variations هم اضافه کن
        $this->category = Category::factory()->create();

        $this->actingAs($this->admin)
            ->post('api/admin/category/' . $this->category->id . '/price-variation', [
                'item1' => '\Modules\colors\Models\Color',
                'item2' => '\Modules\warranties\Models\Warranty',
            ]);
    }

    public function test_add_variations_for_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post('api/admin/category/' . $category->id . '/price-variation', [
                'item1' => '\Modules\colors\Models\Color',
                'item2' => '\Modules\warranties\Models\Warranty',
            ]);
        $response->assertStatus(200);
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('api/admin/category/' . $this->category->id . '/price-variation');
        $this->assertArrayHasKey('category_id', $response->json());
        $response->assertStatus(200);
    }

    public function test_variation_items(): void
    {
        $response = $this
            ->get('/api/category/' . $this->category->id . '/price-variation/items');
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertStatus(200);
    }

    public function test_categories_variation(): void
    {
        $response = $this
            ->get('/api/product/variation/items');
        $this->assertGreaterThan(0, sizeof($response->json()));
        $response->assertStatus(200);
    }
}
