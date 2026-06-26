<?php

namespace Modules\Main\Contracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
interface CrudPaginationOrderInterface
{
    public function apply(Builder $query , string $modelClass): Builder;
}


