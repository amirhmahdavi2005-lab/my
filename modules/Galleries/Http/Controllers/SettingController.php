<?php

namespace Modules\Galleries\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Galleries\Actions\AddGallerySetting;

class SettingController
{
    public function __invoke(Request $request,AddGallerySetting $addGallerySetting)
    {
       if($request->isMethod('post')){
           $addGallerySetting($request);
           return ['status'=>'ok'];
       }
       else{
           return config('gallery');
       }
    }
}
