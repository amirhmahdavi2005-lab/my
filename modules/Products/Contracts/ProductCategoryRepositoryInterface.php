<?php

namespace Modules\Products\Contracts;

interface ProductCategoryRepositoryInterface
{
    public function deleteByProductId(int $productId):void;

    public function firstWithRelation($id , $relation);

    public function create(array $data);
}
