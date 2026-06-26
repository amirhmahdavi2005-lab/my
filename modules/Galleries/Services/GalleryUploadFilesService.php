<?php

namespace Modules\Galleries\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Galleries\Contracts\GalleryUploadFilesServiceInterface;

class GalleryUploadFilesService implements GalleryUploadFilesServiceInterface
{

    public function handle(Request $request): array
    {
        $paths=[];
        $files=$request->all()['files'];
        foreach ($files as $key=>$image){
            $ex=$image->getClientOriginalExtension();
            $fileName=$key.Str::uuid().'.'.$ex;
            if($image->move(fileDirectory('/gallery'),$fileName)){
                $paths[]='gallery/'.$fileName;
            }
        }
        return ['status'=>'ok','paths'=>$paths];
    }
}
