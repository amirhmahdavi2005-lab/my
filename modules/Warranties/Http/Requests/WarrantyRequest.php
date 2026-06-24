<?php

namespace Modules\Warranties\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarrantyRequest extends FormRequest
{

    public function authorize():bool
    {
        return true;
    }


    public function rules():array
    {
        return [
            'name'=>['required','string','max:255'],
            'link'=>['nullable','string','url','max:255'],
            'phone_number'=>['nullable','string','digits:11']
        ];
    }

    public function attributes():array
    {
        return [
            'name'=>'نام گارانتی',
            'link'=>'لینک وب سایت',
            'phone_number'=>'شماره تماس'
        ];
    }
}
