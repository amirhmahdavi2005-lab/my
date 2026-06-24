<?php

namespace Modules\Colors\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Colors\Models\Color;


class ColorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'=>fake()->colorName(),
            'code'=>fake()->hexColor()
        ];
    }

    protected $model=Color::class;
}
