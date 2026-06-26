<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Products\Http\Requests\GalleryUploadRequest;
use Modules\Products\Services\ProductDestroyGalleryService;
use Modules\Products\Services\ProductUploadGalleryService;

class ProductGalleryController
{
    public function upload(GalleryUploadRequest $request, ProductUploadGalleryService $service):array{
        return $service($request->all());
    }

    public function destroy(
        Request $request,
        ProductDestroyGalleryService $service
    ):array{
        return $service($request->all());
    }
}
