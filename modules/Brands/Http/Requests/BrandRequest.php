<?php

namespace Modules\Brands\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>['required','string'],
            'english_name'=>['required','string'
            , Rule::unique('products__brands',
                    'english_name')->ignore($this->brand)],
            'icon'=>['nullable','image','max:512']
        ];
    }

    public function attributes():array
    {
        return [
            'name'=>'نام برند',
            'english_name'=>'نام انگلیسی برند',
            'icon'=>'ایکون'
        ];
    }
}
