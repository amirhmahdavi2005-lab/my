<?php

namespace Modules\Categories\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Categories\Contracts\CategoryKeywordRepositoryInterface;
use Modules\Categories\Contracts\CategoryRepositoryInterface;
use Modules\Categories\Contracts\StoreCategoryServiceInterface;
use Modules\Categories\Contracts\UpdateCategoryServiceInterface;
use Modules\Categories\Repositories\CategoryKeywordRepository;
use Modules\Categories\Repositories\CategoryRepository;
use Modules\Categories\Services\StoreCategoryService;
use Modules\Categories\Services\UpdateCategoryService;

class ModuleProvider extends ServiceProvider
{
    public function register():void{
    $this->loadMigrationsFrom(base_path('Modules/Categories/database/migrations'));
    $this->app->singleton(CategoryRepositoryInterface::class,
        CategoryRepository::class);
        $this->app->singleton(StoreCategoryServiceInterface::class,
            StoreCategoryService::class);
        $this->app->singleton(CategoryKeywordRepositoryInterface::class,
            CategoryKeywordRepository::class);
        $this->app->singleton(
            UpdateCategoryServiceInterface::class,
            UpdateCategoryService::class
        );
}

    public function boot():void
    {

}
}
