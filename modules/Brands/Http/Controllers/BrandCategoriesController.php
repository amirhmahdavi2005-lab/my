<?php

namespace Modules\Brands\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;

class BrandCategoriesController
{
    public function __construct(
        protected BrandRepositoryInterface $brandRepository,
        protected CategoryRepositoryInterface $categoryRepository)
    {

    }

    public function __invoke($slug){
        $brand=$this->brandRepository->first(['english_name'=>$slug]);
        if($brand){
            return Cache::remember('brand-'.replaceSpace($slug),
            now()->addMinutes(24*60),function () use($brand){
                return $this->categoryRepository->
                    getByArrayId(explode(',',$brand->categories));
                });

        }
        return [];
    }
}
