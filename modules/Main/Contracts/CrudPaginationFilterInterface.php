<?php

namespace Modules\Main\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface CrudPaginationFilterInterface
{
 public function apply(Builder $query , Request $request , string $modelClass): Builder;
}
