<?php

namespace Modules\PriceVariation\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPriceVariationItems extends Model
{
    protected $table='categories__price_variation';

    public $timestamps=false;

    protected $guarded=[];
}
