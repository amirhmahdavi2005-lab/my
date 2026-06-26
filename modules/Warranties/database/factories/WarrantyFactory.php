<?php

namespace Modules\Warranties\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Warranties\Models\Warranty;

class WarrantyFactory extends Factory
{
    public function definition():array{
        return [
            'name'=>fake()->text(10),
            'link'=>fake()->url(),
            'phone_number'=>fake()->numerify('09#########'),
        ];
    }
    protected $model=Warranty::class;
}
