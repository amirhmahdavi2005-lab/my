<?php

namespace Modules\GeneralProductId\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralIdRequest extends FormRequest
{
    public function authorize():bool{
        return true;
    }

    public function rules():array{
        return [
            'category_id'=>'required|numeric',
            'general_id'=>'required|numeric',
            'title'=>'required|string|max:255'
        ];
    }

    public function attributes():array{
        return [
            'category_id'=>'دسته',
            'general_id'=>'شناسه عمومی',
            'title'=>'عنوان'
        ];
    }

}
