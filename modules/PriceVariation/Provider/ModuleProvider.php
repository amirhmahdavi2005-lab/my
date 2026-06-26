<?php

namespace modules\PriceVariation\Provider;

use Illuminate\Support\ServiceProvider;
use Modules\PriceVariation\Contracts\CategoryPriceVariationItemsRepositoryInterface;
use Modules\PriceVariation\Contracts\PriceVariationsRepositoryInterface;
use Modules\PriceVariation\Repositories\CategoryPriceVariationItemsRepository;
use Modules\PriceVariation\Repositories\PriceVariationsRepository;

class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once base_path('modules/PriceVariation/helper.php');

        $this->loadMigrationsFrom(
            base_path('modules/PriceVariation/database/migrations')
        );
                $this->app->singleton(
                    CategoryPriceVariationItemsRepositoryInterface::class,
                    CategoryPriceVariationItemsRepository::class
                );
        $this->app->singleton(
            PriceVariationsRepositoryInterface::class,
            PriceVariationsRepository::class
        );
    }

    public function boot(): void
    {

    }
}
