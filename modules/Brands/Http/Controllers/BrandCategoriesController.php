<?php

namespace Modules\Brands\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;

class BrandCategoriesController
{
    public function __invoke($slug):array|Collection{
        $brand=getBrandFromSlug($slug);
        if($brand){
            $categories=getActionQuery('product:query',function ($query) use ($brand){
               return $query->where('brand_id',$brand->id)
                   ->pluck('category_id','category_id')
                   ->toArray();
            });
            return getActionQuery('category:query',function ($query) use ($categories){
                return $query
                    ->whereNull('url')
                    ->whereIn('id',$categories)->get();
            });
        }
        return [];
    }
}
