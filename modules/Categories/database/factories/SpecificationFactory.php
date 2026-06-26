<?php

namespace Modules\Categories\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Categories\Models\Specifications;

class SpecificationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'=>fake()->text(10),
            'important'=>fake()->boolean()
        ];
    }

    protected $model=Specifications::class;
}
