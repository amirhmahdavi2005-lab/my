<?php

namespace Modules\GeneralProductId\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Main\Contracts\CrudRepositoryInterface;

interface GeneralProductIdRepositoryInterface  extends CrudRepositoryInterface
{
    public function create(array $data):bool;

    public function update(int $id,array $data):void;

    public function getByCategoriesId(array $ids):Collection;

    public function exists(array $condition);

    public function latest($column='id');
}
