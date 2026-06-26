<?php

namespace Tests\Feature\PriceVariation;

use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;
use Modules\PriceVariation\Models\PriceVariation;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;
use Tests\TestCase;

class PriceVariationTest extends TestCase
{
    protected User $admin;
    protected Product $product;
    protected array $variationPayload;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();

        // یه product آماده برای همه تست‌ها
        $this->product = app(ProductRepositoryInterface::class)->latest()
            ?? Product::factory()->create();

        $this->variationPayload = [
            'price1'           => rand(99999, 999999),
            'price2'           => rand(99999, 999999),
            'preparation_time' => rand(0, 2),
            'product_count'    => rand(1, 100),
            'max_product_cart' => rand(1, 5),
            'param1_type'      => '\Modules\colors\Models\Color',
            'param1_id'        => rand(9, 99),
            'param2_type'      => '\Modules\warranties\Models\Warranty',
            'param2_id'        => rand(9, 99),
            'status'           => 'true',
        ];

        // یه variation اولیه بساز تا تست‌های دیگه روی null نزنن
        $existing = app(PriceVariationsRepositoryInterface::class)->latest();
        if (! $existing) {
            $this->actingAs($this->admin)
                ->post(
                    'api/admin/products/price-variations?product_id=' . $this->product->id,
                    $this->variationPayload
                );
        }
    }

    public function test_create_price_variation(): void
    {
        $latest = app(PriceVariationsRepositoryInterface::class)->latest();
        $param1_id = $latest ? $latest->param1_id + 1 : rand(9, 99);

        $payload = array_merge($this->variationPayload, ['param1_id' => $param1_id]);

        $response = $this->actingAs($this->admin)
            ->post(
                'api/admin/products/price-variations?product_id=' . $this->product->id,
                $payload
            );
        $response->assertStatus(200);
    }

    public function test_index(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('api/admin/products/price-variations?product_id=' . $this->product->id);

        $body = $response->json();
        $this->assertArrayHasKey('data', $body);
        $this->assertGreaterThan(0, sizeof($body['data']));
        $response->assertStatus(200);
    }

    public function test_unique_row(): void
    {
        $priceVariation = app(PriceVariationsRepositoryInterface::class)->latest();

        $response = $this->actingAs($this->admin)
            ->post(
                'api/admin/products/price-variations?product_id=' . $priceVariation->product_id,
                [
                    'price1'           => rand(99999, 999999),
                    'price2'           => rand(99999, 999999),
                    'preparation_time' => rand(0, 2),
                    'product_count'    => rand(1, 100),
                    'max_product_cart' => rand(1, 5),
                    'product_id'       => $priceVariation->product_id,
                    'param1_type'      => $priceVariation->param1_type,
                    'param1_id'        => $priceVariation->param1_id,
                    'param2_type'      => $priceVariation->param2_type,
                    'param2_id'        => $priceVariation->param2_id,
                ]
            );
        $response->assertStatus(302);
    }

    public function test_show(): void
    {
        $priceVariation = app(PriceVariationsRepositoryInterface::class)->latest();

        $response = $this->actingAs($this->admin)
            ->get(
                'api/admin/products/price-variations/' . $priceVariation->id .
                '?product_id=' . $priceVariation->product_id
            );

        $this->assertEquals($response->json()['id'], $priceVariation->id);
        $response->assertStatus(200);
    }

    public function test_update(): void
    {
        $priceVariation         = app(PriceVariationsRepositoryInterface::class)->latest()->toArray();
        $priceVariation['price1'] = rand(99, 999);
        $priceVariation['price2'] = rand(9, 99);
        $priceVariation['status'] = 'true';

        $response = $this->actingAs($this->admin)
            ->put(
                'api/admin/products/price-variations/' . $priceVariation['id'] .
                '?product_id=' . $priceVariation['product_id'],
                $priceVariation
            );

        $response->assertStatus(200);
        $this->assertTrue(
            app(PriceVariationsRepositoryInterface::class)->exists([
                'id'     => $priceVariation['id'],
                'price1' => $priceVariation['price1'],
                'price2' => $priceVariation['price2'],
            ])
        );
    }

    public function test_get_product_variations(): void
    {
        $response = $this->get('/api/product/' . $this->product->id . '/variations');
        $response->assertStatus(200);
        $this->assertGreaterThan(0, count($response->json()));
    }
}
