<?php

namespace Modules\Categories\Models;

use  Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Categories\Database\Factories\CategoryFactory;

class  Category extends Model
{
    use SoftDeletes, HasFactory;

    protected  $table = 'categories';
    protected $guarded = ['pic'];

    protected static function newFactory():CategoryFactory
    {
        return CategoryFactory::new();
    }
    public static function searchItems($request):array{
        return [
            'name'=>[
                'operator'=>'like',
                'value'=>$request->get('name'),'orWhereColumn'=>'ename'
            ]
        ];
    }
}
