<?php

namespace Modules\Brands\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'english_name'=>['required','string'],
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
