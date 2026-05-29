<?php

namespace Modules\Categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Categories\Rules\CheckCategoryEnglishName;

class CategoryRequest extends FormRequest
{

    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'name' => ['required', 'string'],
            'pic'  => ['nullable', 'image'],
            'url'  => $this->missing('ename') ? ['required'] : ['nullable'],
            'ename'=> $this->filled('ename')
                ? ['required', 'string', new CheckCategoryEnglishName($this->category)]
                : ['nullable'],
        ];
    }

    public function attributes():array{
        return [
            'name'=>'نام دسته',
            'pic'=>'تصویر دسته',
            'ename'=>'نام انگلیسی دسته'
        ];
    }

    public function messages():array{
        return [
            'url.required'=>'برای دسته باید نام انگلیسی یا url ثبت شود'
        ];
    }
}

