<?php

namespace Modules\Products\Events;

use Modules\Products\Contracts\ProductCategoryRepositoryInterface;

class AddProductCategories
{
    public function handel($product)
    {
        $repo = app(ProductCategoryRepositoryInterface::class);
        $repo->deleteByProductId($product->id);
        if($product->category_id){
            $repo->create([
                'product_id' => $product->id,
                'category_id' => $product->category_id
            ]);
            $category = $repo->firstWithRelation($product->category_id ,
            'parent.parent.parent');
            if($category){
                for ($i=0; $i<3; $i++){
                    if($category->parent){
                    $repo->create([
                        'product_id' => $product->id,
                        'category_id' => $category->parent -> id
                    ]);
                    $category = $category->parent;
                }
                }
            }
        }
    }
}
