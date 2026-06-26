<?php

namespace Categories;

use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Contracts\SpecificationRepositoryInterface;
use Modules\Categories\Models\Category;
use Modules\Categories\Models\Specifications;
use Modules\Users\Models\User;
use Tests\TestCase;

class SpecificationTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = getAdminForTest();
    }

    public function test_add_specifications(): void
    {
        $category = Category::factory()->create(); // FIX: مهم‌ترین اصلاح

        $specifications = [];

        for ($i = 0; $i < 3; $i++) {

            $childs = [];

            $data = Specifications::factory()
                ->make()
                ->toArray();

            if ($i % 2 == 0) {
                for ($j = 0; $j < 2; $j++) {
                    $childs[] = Specifications::factory()
                        ->make()
                        ->toArray();
                }
            }

            $data['childs'] = $childs;
            $specifications[] = $data;
        }

        $response = $this
            ->actingAs($this->admin)
            ->post(
                'api/admin/category/' . $category->id . '/specification',
                [
                    'technical_specifications' => $specifications
                ]
            );

        $response->assertStatus(200);
    }

    public function test_update_specifications(): void
    {
        $category = Category::factory()->create();

        $specificationRepo = app(SpecificationRepositoryInterface::class);

        $specifications = $specificationRepo->getCategorySpecifications($category->id);

        $array = [];

        foreach ($specifications as $specification) {
            $array[] = [
                'id' => $specification->id,
                'name' => fake()->text(15),
                'parent_id' => $specification->parent_id,
                'important' => $specification->important,
                'childs' => $specification->childs->toArray()
            ];
        }

        $response = $this
            ->actingAs($this->admin)
            ->post(
                'api/admin/category/' . $category->id . '/specification',
                [
                    // FIX: unified name
                    'technical_specifications' => $array
                ]
            );

        $response->assertStatus(200);
    }

    public function test_get_category_specifications(): void
    {
        $category = Category::factory()->create();

        $response = $this
            ->actingAs($this->admin)
            ->get('api/category/' . $category->id . '/specifications');

        $response->assertStatus(200);
    }
}
