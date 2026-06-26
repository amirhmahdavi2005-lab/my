<?php

namespace Modules\Galleries\Repositories;

use Illuminate\Support\Collection;
use Modules\Galleries\Contracts\GalleryRepositoryInterface;
use Modules\Galleries\Models\Gallery;

class GalleryRepository  implements GalleryRepositoryInterface
{
    public function listFiles(int $id,string $type):Collection
    {
        return Gallery::where([
            'tableable_id'=>$id,
            'tableable_type'=>$type
        ])->orderBy('position','ASC')
            ->get();
    }

    public function findByConditions(array $conditions): ?Gallery
    {
        return Gallery::where($conditions)->first();
    }

    public function create(array $data): Gallery
    {
        return Gallery::create($data);
    }

    public function destory(array $data):void
    {
        Gallery::where($data)->delete();
    }
}
