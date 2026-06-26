<?php

namespace Modules\Categories\Repositories;

use Illuminate\Support\Collection;
use Modules\Categories\Contracts\ProductSpecificationRepositoryInterface;
use Modules\Categories\Models\ProductSpecification;
use Modules\Categories\Models\Specifications;

class ProductSpecificationRepository implements ProductSpecificationRepositoryInterface
{

    public function deleteByProductId(int $productId): void
    {
        ProductSpecification::where('product_id', $productId)->delete();
    }

    public function insertMany(array $data): void
    {
        if (empty($data)) {
            ProductSpecification::insert($data);
        }
    }

    public function getByProductId(int $productId): Collection
    {
       return ProductSpecification::where('product_id', $productId)->get();
    }
}
