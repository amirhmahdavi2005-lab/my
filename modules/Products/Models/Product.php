<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\PriceVariation\Models\PriceVariation;
use Modules\Products\Contracts\AdminProductSearchFiltersInterface;
use Modules\Products\database\factories\ProductFactory;

class Product extends Model
{
    use SoftDeletes,HasFactory;
    protected $table = 'products';
    protected $guarded = ['weight'];
    protected $hidden=[
        'content',
        'product_count',
        'lowest_price',
        'created_at',
        'updated_at',
        'deleted_at',
        'view',
        'description',
        'sales_count',
        'user_id',
        'user_type'
    ];
    protected static  function newFactory():Factory
    {
        return ProductFactory::new();
    }

    public function getCreatedAtAttribute($value):int
    {
        return Carbon::parse($value)->timestamp;
    }
    public static array $visibleForPagination=
        [
            'product_count',
            'created_at',
            'updated_at',
            'deleted_at',
            'sales_count',
            'lowest_price'
        ];
    public function variations(): HasMany
    {
        return $this->hasMany(PriceVariation::class, 'product_id');
    }

    public function variation()
    {
        return $this->hasOne(PriceVariation::class, 'product_id');
    }

    public static function searchItems($request):array
    {
        $repository=app(AdminProductSearchFiltersInterface::class);
        return  $repository->apply($request);
    }
}
