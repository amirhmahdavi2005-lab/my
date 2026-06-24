<?php

namespace Modules\PriceVariation\Repositories;

use Modules\PriceVariation\Contracts\CategoryPriceVariationItemsRepositoryInterface;
use Modules\PriceVariation\Models\CategoryPriceVariationItems;

class CategoryPriceVariationItemsRepository implements  CategoryPriceVariationItemsRepositoryInterface
{
    public function first($condition){
        return CategoryPriceVariationItems::where($condition)
            ->first();
    }

    public function findByCategoryId(int $categoryId): ?object
    {
        return CategoryPriceVariationItems::where('category_id', $categoryId)->first();
    }

    public function updateOrCreateByCategoryId(int $categoryId, array $data): void
    {
        CategoryPriceVariationItems::updateOrCreate(
            ['category_id' => $categoryId],
            $data
        );
    }

    public function getAllKeyedByCategory(): array
    {
        return CategoryPriceVariationItems::get()
            ->keyBy('category_id')
            ->toArray();
    }
}
