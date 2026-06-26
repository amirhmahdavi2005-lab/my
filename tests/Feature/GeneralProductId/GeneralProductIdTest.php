<?php

namespace Tests\Feature\GeneralProductId;

use Modules\Categories\Models\Category;
use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;
use Modules\GeneralProductId\Models\GeneralProductId;
use Modules\Users\Models\User;
use Tests\TestCase;

class GeneralProductIdTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_create_generalId(): void
    {
        $category = Category::factory()->create();
        $data = [
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ];
        $response = $this
            ->actingAs($this->admin)
            ->post('/api/admin/general-product-ids', $data);
        $response->assertStatus(200);
    }

    public function test_show(): void
    {
        $category = Category::factory()->create();
        $generalId = GeneralProductId::create([
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/general-product-ids/' . $generalId->id);
        $this->assertEquals($response->json()['id'], $generalId->id);
        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $category = Category::factory()->create();
        $generalId = GeneralProductId::create([
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ]);

        $title = fake()->text(10);
        $response = $this
            ->actingAs($this->admin)
            ->put('api/admin/general-product-ids/' . $generalId->id, [
                'title' => $title,
                'category_id' => $generalId->category_id,
                'general_id' => $generalId->general_id
            ]);
        $response->assertStatus(200);
        $this->assertTrue(
            app(GeneralProductIdRepositoryInterface::class)->exists([
                'id' => $generalId->id,
                'title' => $title
            ])
        );
    }

    public function test_index(): void
    {
        $category = Category::factory()->create();
        GeneralProductId::create([
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ]);

        $response = $this
            ->actingAs($this->admin)
            ->get('api/admin/general-product-ids');
        $body = $response->json();
        $this->assertArrayHasKey('data', $body);
        $this->assertGreaterThan(0, sizeof($body['data']));
        $response->assertStatus(200);
    }

    public function test_destroy(): int
    {
        $category = Category::factory()->create();
        $product = GeneralProductId::create([
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ]);

        $response = $this->actingAs($this->admin)
            ->delete('api/admin/general-product-ids/' . $product->id);

        $this->assertFalse(app(GeneralProductIdRepositoryInterface::class)->exists([
            'id' => $product->id,
            'deleted_at' => null
        ]));

        $response->assertStatus(200);
        return $product->id;
    }

    public function test_restore(): void
    {
        $this->withoutExceptionHandling();

        $category = Category::factory()->create();
        $product = GeneralProductId::create([
            'title' => fake()->text(10),
            'category_id' => $category->id,
            'general_id' => rand(99999, 999999)
        ]);
        $product->delete();

        $response = $this->actingAs($this->admin)
            ->post('api/admin/general-product-ids/' . $product->id . '/restore');

        $this->assertTrue(app(GeneralProductIdRepositoryInterface::class)->exists([
            'id' => $product->id,
            'deleted_at' => null
        ]));

        $response->assertStatus(200);
    }
}
