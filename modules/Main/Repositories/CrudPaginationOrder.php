<?php

namespace Modules\Main\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\Main\Contracts\CrudPaginationOrderInterface;

class CrudPaginationOrder implements CrudPaginationOrderInterface
{
    public function apply(Builder $query, string $modelClass): Builder
    {
        $orderBy = property_exists($modelClass, 'orderBy')
            ? $modelClass::$orderBy
            : 'id';

        return $query->orderBy($orderBy, 'desc');
    }
}
