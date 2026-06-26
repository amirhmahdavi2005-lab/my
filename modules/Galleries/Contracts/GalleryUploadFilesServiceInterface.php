<?php

namespace Modules\Galleries\Contracts;

use Illuminate\Http\Request;

interface GalleryUploadFilesServiceInterface
{
    public function handle(Request $request):array;
}
