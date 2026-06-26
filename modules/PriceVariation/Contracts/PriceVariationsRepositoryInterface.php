<?php

namespace Modules\PriceVariation\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Contracts\CrudRepositoryInterface;
use Modules\PriceVariation\Models\PriceVariation;

interface PriceVariationsRepositoryInterface extends CrudRepositoryInterface
{
    public function checkForUnique($conditions,int $exceptId):bool;

    public function latest(string $column = 'id');

    public function exists(array $conditions);

    public function create(array $data);

    public function first(array $conditions):?PriceVariation;

    public function firstOrFail(array $conditions): PriceVariation;
    public function update(int $id, array $data):void;
    public function pagination($data): LengthAwarePaginator ;

}
