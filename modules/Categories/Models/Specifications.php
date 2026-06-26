<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Categories\Database\Factories\SpecificationFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\Factory;

class Specifications extends Model
{
    use HasFactory;

    protected $table = 'specification';

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function childs(): HasMany
    {
        return $this->hasMany(
            Specifications::class,
            'parent_id',
            'id'
        );
    }

    protected static function newFactory(): Factory
    {
        return SpecificationFactory::new();
    }
}
