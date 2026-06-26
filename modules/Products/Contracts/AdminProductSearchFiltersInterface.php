<?php

namespace Modules\Products\Contracts;

interface AdminProductSearchFiltersInterface
{
    public function apply($request):array;
}
