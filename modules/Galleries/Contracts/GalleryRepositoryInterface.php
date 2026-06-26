<?php

namespace Modules\Galleries\Contracts;

use Illuminate\Support\Collection;
use Modules\Galleries\Models\Gallery;

interface GalleryRepositoryInterface
{
    public function listFiles(int $id,string $type):Collection;

    public function findByConditions(array $conditions): ?Gallery;

    public function create(array $data): Gallery;

    public function destory(array $conditions);

}
