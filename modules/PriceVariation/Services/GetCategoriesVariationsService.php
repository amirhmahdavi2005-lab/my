<?php

namespace Modules\PriceVariation\Services;

use Illuminate\Support\Facades\Cache;
use Modules\PriceVariation\Contracts\CategoryPriceVariationItemsRepositoryInterface;

class GetCategoriesVariationsService
{
    public function __invoke(int $category_id):array
    {
        return Cache::remember('items'.$category_id, 3600, function() use ($category_id){
            $result = [];
            $repository = app(CategoryPriceVariationItemsRepositoryInterface::class);
            $categoriesId = getParentCategoriesId($category_id);
            foreach ($categoriesId as $id) {
                if(sizeof($result) < 3){
                    $variationItems = $repository->first(['category_id' => $id]);
                    if($variationItems){
                        if($variationItems->item1) {
                            $result[0] = $variationItems->item1::itemsDetail();
                        }
                        if($variationItems->item2) {
                            $result[1] = $variationItems->item2::itemsDetail();
                        }
                        if($variationItems->item3) {
                            $result[2] = $variationItems->item3::itemsDetail();
                        }
                    }
                }
            }
            return $result;
        });
    }
}
