<?php

namespace Modules\Brands\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brands\database\factories\BrandFactory;


class Brand extends Model
{
    use SoftDeletes,HasFactory;

    protected $table='products__brands';

    protected $guarded=[];

    protected static  function newFactory()
    {
        return BrandFactory::new();
    }

    public static function searchItems($request):array{
        return [
            'name'=>['operator'=>'like','value'=>$request->get('name')]
        ];
    }

    protected $casts=[
        'categories'=>'array'
    ];
}
