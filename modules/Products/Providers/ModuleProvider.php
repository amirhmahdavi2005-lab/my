<?php

namespace Modules\Products\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Modules\Categories\Contracts\ProductSpecificationRepositoryInterface;
use Modules\Categories\Repositories\ProductSpecificationRepository;
use Modules\Products\Contracts\AdminProductSearchFiltersInterface;
use Modules\Products\Contracts\ProductCategoryRepositoryInterface;
use Modules\Products\Contracts\ProductDetailRepositoryInterface;
use Modules\Products\Contracts\ProductKeywordsRepositoryInterface;
use Modules\Products\Contracts\ProductRepositoryInterface;
use Modules\Products\Events\AddProductGallery;
use Modules\Products\Events\ProductCategories;
use Modules\Products\Events\SavingProduct;
use Modules\Products\Repositories\Filters\AdminProductSearchFiltersProvider;
use Modules\Products\Repositories\ProductCategoryRepository;
use Modules\Products\Repositories\ProductDetailRepository;
use Modules\Products\Repositories\ProductKeywordsRepository;
use Modules\Products\Repositories\ProductRepository;

class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(
            base_path('modules/Products/database/migrations')
        );

        $this->app->singleton(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->singleton(
            ProductDetailRepositoryInterface::class,
            ProductDetailRepository::class

        );
        $this->app->singleton(
            ProductKeywordsRepositoryInterface::class,
        ProductKeywordsRepository::class);
        $this->app->singleton(
            AdminProductSearchFiltersInterface::class,
        AdminProductSearchFiltersProvider::class);
        $this->app->singleton(
            ProductCategoryRepositoryInterface::class,
        ProductCategoryRepository::class);


        Event::listen('product.created', SavingProduct::class);
        Event::listen('product.updated', SavingProduct::class);
        addEvent('product.created',AddProductCategories::class);
        addEvent('product.updated',AddProductCategories::class);

        Event::listen('product.created', \Modules\Products\Events\gallery\AddProductGallery::class);
        Event::listen('product.updated', \Modules\Products\Events\gallery\AddProductGallery::class);

    }
}
