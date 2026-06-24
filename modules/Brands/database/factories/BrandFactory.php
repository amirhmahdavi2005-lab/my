<?php

namespace Modules\Brands\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Brands\Models\Brand;


class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'=>fake()->text(10),
            'english_name'=>fake()->text(10),
            'categories'=>[1,2]
        ];
    }

    protected $model=Brand::class;
}
