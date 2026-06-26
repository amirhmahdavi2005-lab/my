<?php

namespace Modules\Products\Repositories;

use Modules\Products\Contracts\ProductKeywordsRepositoryInterface;
use Modules\Products\Models\ProductKeyword;

class ProductKeywordsRepository implements ProductKeywordsRepositoryInterface
{

    public function create(array $data): void
    {
        ProductKeyword::create($data);
    }

    public function destroy(int $productId): void
    {
        ProductKeyword::where('product_id', $productId)->delete();
    }
    public function getTagsByProductId(int $productId): string
    {
        return ProductKeyword::where('product_id', $productId)
            ->pluck('tag')
            ->implode(',');
    }
}
