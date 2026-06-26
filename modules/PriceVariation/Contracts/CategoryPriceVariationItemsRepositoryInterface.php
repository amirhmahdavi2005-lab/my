<?php

namespace Modules\PriceVariation\Contracts;

interface CategoryPriceVariationItemsRepositoryInterface
{
    public function first($condition);

    public function findByCategoryId(int $categoryId): ?object;

    public function updateOrCreateByCategoryId(int $categoryId, array $data): void;

    public function getAllKeyedByCategory(): array;

}
