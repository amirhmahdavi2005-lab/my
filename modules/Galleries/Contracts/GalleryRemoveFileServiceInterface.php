<?php

namespace Modules\Galleries\Contracts;

interface GalleryRemoveFileServiceInterface
{
    public function handle(int |null $id,string|null $path);
}
