<?php

namespace Modules\Main\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Modules\Main\Contracts\CrudPaginationFilterInterface;

class CrudPaginationFilter implements CrudPaginationFilterInterface
{

    public function apply(Builder $query, Request $request, string $modelClass): Builder
    {
        if (!method_exists($modelClass, 'searchItems')) {
            return $query;
        }

        $filterItems = $modelClass::searchItems($request);

        foreach ($filterItems as $key => $item) {
            if (is_array($item)) {
                $operator = $item['operator'] ?? '=';
                $value = $item['value'] ?? null;

                if (!is_null($value) && $value !== 'null') {
                    if ($operator == 'like') {
                        $query->where(function ($query) use ($key, $item, $value) {
                            $query->where($key, 'like', '%' . $value . '%');

                            if (!empty($item['orWhereColumn'])) {
                                $query->orWhere($item['orWhereColumn'], 'like', '%' . $value . '%');
                            }
                        });
                    } else {
                        $query->where($key, $operator, $value);
                    }
                }
            } elseif (is_callable($item)) {
                $query = $item($query);
            }
        }

        return $query;
    }}
