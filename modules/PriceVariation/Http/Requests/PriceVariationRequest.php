<?php

namespace Modules\PriceVariation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\PriceVariation\Rules\UniqueReview;


class PriceVariationRequest extends FormRequest
{
    public function authorize():bool{
        return true;
    }

    public function rules():array{
        $rules=[
            'price1'=>'required|numeric',
            'price2'=>'required|numeric',
            'product_count'=>['required','numeric',new UniqueReview()],
            'sku'=>[
                'nullable',
                'string',
                Rule::unique('products__price_variations', 'sku')
                    ->ignore($this->route('price_variation'))
            ]
        ];
        if(!empty($this->request->get('preparation_time')))
        {
            $rules['preparation_time']='numeric';
        }
        return $rules;
    }

    public function attributes():array{
        return [
            'price1'=>'قیمت محصول',
            'price2'=>'قیمت محصول برای فروش',
            'product_count'=>'تعداد موجودی محصول',
            'max_product_cart'=>'تعداد سفارش در سبد خرید',
            'preparation_time'=>'زمان آماده سازی محصول'
        ];
    }

    protected function getValidatorInstance()
    {
        $array=['price1','price2','preparation_time','product_count','max_product_cart'];
        foreach ($array as $value){
            if($this->request->has($value))
            {
                $raw = $this->request->get($value);
                $normalized = function_exists('replaceFaNumber')
                    ? replaceFaNumber($raw)
                    : $raw;
                $this->merge([
                    $value => str_replace(',', '', $normalized)
                ]);
            }
        }

        return parent::getValidatorInstance();
    }
}
