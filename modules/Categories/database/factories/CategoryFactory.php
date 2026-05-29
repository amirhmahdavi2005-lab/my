<?php

namespace Modules\Categories\Database\factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Categories\Models\Category;

class CategoryFactory extends Factory
{
public function definition():array{
    return [
        'name'=>fake()->text(10),
        'ename'=>fake()->name(),
        'icon'=>"['fas','house']",
        'slug'=>'slug'
    ];
}
protected $model = Category::class;
}
