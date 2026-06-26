<?php

namespace Modules\Galleries\Contracts;

interface GalleryServiceInterface
{
    public function handel(array $data, bool $withWatermark = false): void;
}
