<?php

namespace Modules\Brands\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Brands\Contracts\BrandRepositoryInterface;
use Modules\Brands\Repositories\BrandRepository;

class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(
            base_path('modules/Brands/database/migrations')
        );
        $this->app->singleton(BrandRepositoryInterface::class,
        BrandRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
