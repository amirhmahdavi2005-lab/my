<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table='products__categories';

    protected $guarded=[];

    protected $hidden=['created_at','updated_at'];
}
