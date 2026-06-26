<?php

namespace Modules\PriceVariation\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PriceVariationExportRepositoryInterface
{
    public function getExportData(?int $categoryId, ?int $brandId, int $perPage = 250): LengthAwarePaginator;

}
