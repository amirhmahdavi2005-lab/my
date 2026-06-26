<?php

namespace Modules\Products\Services;

use Modules\Galleries\Contracts\GalleryUploadFilesServiceInterface;

class ProductUploadGalleryService
{
    public function __invoke($data):array
    {
        $uploadFilesService=app(GalleryUploadFilesServiceInterface::class);
        $request=request();
        return $uploadFilesService
            ->handle($request);
    }
}

