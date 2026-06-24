<?php

namespace Modules\Warranties\Models\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Brands\database\factories\BrandFactory;
use Modules\Warranties\database\factories\WarrantyFactory;

class Warranty extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'warranties';
    protected $guarded = [];

    public static function searchItems($request):array{
        return [
            'name'=>['operator'=>'like','value'=>$request->get('name')]
        ];
    }

    protected $hidden=['created_at','updated_at'];

    protected static function newFactory():Factory{
        return WarrantyFactory::new();
    }
}


