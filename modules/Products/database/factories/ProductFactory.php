<?php

namespace Modules\Products\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Products\Models\Product;


class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'=>fake()->text(10),
            'description'=>fake()->paragraph(),
            'content'=>fake()->paragraph(),
            'en_title'=>fake()->text(15)
        ];
    }

    protected $model=Product::class;
}
