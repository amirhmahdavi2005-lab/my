<?php

namespace Modules\Main\Repositories;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Main\Contracts\CrudPaginationInterface;
use Modules\Main\Contracts\CrudPaginationOrderInterface;

class CrudPaginationRepository implements CrudPaginationInterface
{
    protected array $filters;
    protected CrudPaginationOrderInterface $ordering;
    public function __construct(array $filters, CrudPaginationOrderInterface $ordering){
        $this->filters = $filters;
        $this->ordering = $ordering;
    }

    public function paginate(Request $request, string $modelClass): LengthAwarePaginator
    {
        $query = $modelClass::query();

        foreach ($this->filters as $filter){
            $query = $filter->apply($query, $request, $modelClass);
        }
        $query = $this ->ordering->apply($query, $modelClass);
        $paginator = $query->paginate(10);

        if (property_exists($modelClass, 'VisibleForPagination')) {
            $paginator-> data = $paginator-> makeVisible($modelClass::$visibleForPagination);
        }
        return $paginator;
    }}


