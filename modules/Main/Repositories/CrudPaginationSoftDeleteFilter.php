<?php

namespace Modules\Main\Repositories;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Modules\Main\Contracts\CrudPaginationFilterInterface;

class CrudPaginationSoftDeleteFilter implements CrudPaginationFilterInterface
{

    public function apply(Builder $query, Request $request, string $modelClass): Builder
    {
        if(in_array(SoftDeletes::class , class_uses($modelClass))
            && $request->get('trashed')==='true'){
            $query->onlyTrashed();
        }
        return $query;
    }
}
