<?php

namespace Modules\PriceVariation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Products\Models\Product;
use Modules\Products\Models\ProductCategory;

class PriceVariation extends Model
{
    use SoftDeletes;

    protected $table='products__price_variations';

    protected $guarded=[];

    protected $hidden=['created_at','updated_at','selected_buy_box'];

    public function param1():MorphTo{
        return $this->morphTo();
    }

    public function param2():MorphTo{
        return $this->morphTo();
    }

    public static function findWhere():array{
        $request=request();
        return [
            'id'=>$request->route()->parameter('price_variation'),
            'product_id'=>$request->get('product_id'),
        ];
    }

    protected static function boot()
    {
        parent::boot();

        $dispatch = fn($variation) => runEvent('price-variation:updated', $variation);

        static::created($dispatch);
        static::updated($dispatch);
        static::deleted($dispatch);
        static::restored($dispatch);
    }

    public function productCategories():HasMany
    {
        return $this->hasMany(
            ProductCategory::class, 'product_id', 'product_id'
        );
    }

    public function product():belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
