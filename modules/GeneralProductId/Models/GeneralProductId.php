<?php

namespace Modules\GeneralProductId\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralProductId extends Model
{
    use SoftDeletes;

    protected $table='products__general-ids';

    protected $guarded=[];

    protected static function searchItems($request):array{
        return [
            'title'=>[
                'operator'=>'like','value'=>$request->get('title')
            ],
            'category_id'=>[
                'operator'=>'=','value'=>$request->get('category_id')
            ]
        ];
    }
}
