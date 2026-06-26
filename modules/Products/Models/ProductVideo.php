<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class ProductVideo extends Model
{
    protected $table='products__videos';

    protected $guarded=[];

    public static function searchItems(Request $request):array{
        return [
            'product_id'=>[
                'operator'=>'=','value'=>$request->get('product_id')
            ],
            'user'=>function ($query) {
                return $query->with('user');
            }
        ];
    }

}
