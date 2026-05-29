<?php

namespace Modules\Main\Contracts;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CrudPaginationInterface
{
public function paginate(Request $request ,string $modelClass):LengthAwarePaginator;
}
