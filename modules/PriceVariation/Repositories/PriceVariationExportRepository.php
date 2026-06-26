<?php

namespace Modules\PriceVariation\Repositories;

use Modules\PriceVariation\Contracts\PriceVariationExportRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Modules\PriceVariation\Models\PriceVariation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PriceVariationExportRepository implements PriceVariationExportRepositoryInterface
{
    public function getExportData(?int $categoryId, ?int $brandId, int $perPage = 250): LengthAwarePaginator
    {
        $query = PriceVariation::query()
            ->with(['param1', 'param2', 'product']);

        if ($brandId && $brandId > 0) {
            $query->whereHas('product', function (Builder $builder) use ($brandId) {
                $builder->where('brand_id', $brandId);
            });
        }

        if ($categoryId && $categoryId > 0) {
            $query->whereHas('productCategories', function (Builder $builder) use ($categoryId) {
                $builder->where('category_id', $categoryId);
            });
        }

        return $query->paginate($perPage);
    }
}
