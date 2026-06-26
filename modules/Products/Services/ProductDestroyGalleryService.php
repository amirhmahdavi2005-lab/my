<?php

namespace Modules\Products\Services;

use Modules\Galleries\Contracts\GalleryRemoveFileServiceInterface;
use Modules\Galleries\Contracts\GalleryRepositoryInterface;
use Modules\Products\Models\Product;

class ProductDestroyGalleryService
{
    public function __construct(
        protected GalleryRepositoryInterface $galleryRepository,
        protected GalleryRemoveFileServiceInterface $removeFileService
    ){}

    public function __invoke($data,$user_type=null,$user_id=null):array
    {
        $path=$data['path'];
        $conditions=['path'=>$path,'tableable_type'=>Product::class];
        if($user_id && $user_type){
            $conditions['user_id']=$user_id;
            $conditions['user_type']=$user_type;
        }
        $gallery=$this->galleryRepository->findByConditions(
            $conditions
        );
        $this->removeFileService->handle(
            id:$gallery ? $gallery->id : null,
            path:$path
        );
        return ['status'=>'ok'];
    }
}
