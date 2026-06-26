<?php

namespace Modules\Categories\Contracts;

use Illuminate\Support\Collection;

interface ProductSpecificationRepositoryInterface
{
    public function deleteByProductId(int $productId): void;

    public function insertMany(array $data): void;

    public function getByProductId(int $productId): Collection;
}
