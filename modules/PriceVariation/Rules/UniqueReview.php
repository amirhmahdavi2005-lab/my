<?php

namespace Modules\PriceVariation\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;
use Modules\PriceVariation\Models\PriceVariation;

class UniqueReview implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $request=request();
        $params=$request->route()->parameters();
        $conditions=[
            'product_id'=>$request->get('product_id')
        ];
        if($request->has('param1_id') && !empty($request->post('param1_id'))){
            $conditions['param1_id']=$request->post('param1_id');
            $conditions['param1_type']=$request->post('param1_type');
        }
        if($request->has('param2_id') && !empty($request->post('param2_id'))){
            $conditions['param2_id']=$request->post('param2_id');
            $conditions['param2_type']=$request->post('param2_type');
        }
        $exists=app(PriceVariationsRepositoryInterface::class)
            ->checkForUnique($conditions,
                array_key_exists('price_variation',$params) ? $params['price_variation'] : 0
            );
        if($exists){
            $fail('تنوع قیمت قبلا ثبت شده');
        }
    }
}
