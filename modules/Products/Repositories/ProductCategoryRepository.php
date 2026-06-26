<?php

namespace Modules\Products\Repositories;

use Modules\Categories\Models\Category;
use Modules\Products\Contracts\ProductCategoryRepositoryInterface;
use Modules\Products\Models\ProductCategory;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{

    public function deleteByProductId(int $productId):void
    {
        ProductCategory::where('product_id', $productId)->delete();
    }

    public function firstWithRelation($id, $relation)
    {
        return Category::where([ 'id'=>$id])->with($relation)->first();
    }

    public function create(array $data):void
    {
       ProductCategory::create($data);
    }
}
