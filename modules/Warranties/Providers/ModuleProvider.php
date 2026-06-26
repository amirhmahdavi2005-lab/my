<?php

namespace Modules\Warranties\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Warranties\Contracts\WarrantyRepositoryInterface;
use Modules\Warranties\Repositories\WarrantyRepository;

class ModuleProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->loadMigrationsFrom(
            base_path('modules/warranties/database/migrations')
        );
        $this->app->singleton(
            WarrantyRepositoryInterface::class,
            WarrantyRepository::class
        );
    }

    public function boot(): void
    {

    }
}
