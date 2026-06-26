<?php

namespace Modules\Products\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Products\Models\Product;
use Modules\Users\Models\User;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'en_title' => fake()->text(15),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'content' => fake()->paragraph(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'user_id' => fn () => User::query()->first()?->id ?? User::factory(),
            'user_type' => User::class,
        ];
    }
}
