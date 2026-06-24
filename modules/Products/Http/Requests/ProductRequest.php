<?php

namespace Modules\Products\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{

    public function authorize():bool
    {
        return true;
    }


    public function rules()
    {
        $rules=[
            'title'=>['required','string','max:255'],
            'description'=>['string'],
            'content'=>['nullable','string'],
            'en_title'=>['nullable','string','max:255']
        ];
        return runEvent(
            'create-product-rules', $rules, true
        );
    }

    public function attributes():array
    {
        return [
            'title'=>'عنوان محصول',
            'en_title'=>'عنوان انگلیسی',
            'pic'=>'تصویر'
        ];
    }

}
