<?php

namespace Modules\Galleries\Services;

use Modules\Galleries\Contracts\GalleryRemoveFileServiceInterface;
use Modules\Galleries\Contracts\GalleryRepositoryInterface;

class GalleryRemoveFileService implements GalleryRemoveFileServiceInterface
{
    public function __construct(
        protected GalleryRepositoryInterface $galleryRepository
    ){}

    public function handle(?int $id, ?string $path):void
    {
        if($path && file_exists(fileDirectory($path))){
            unlink(fileDirectory($path));
        }
        if($id){
            $this->galleryRepository->destory(['id'=>$id]);
        }
    }
}
