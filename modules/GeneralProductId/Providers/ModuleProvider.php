<?php

namespace Modules\GeneralProductId\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\GeneralProductId\Contracts\GeneralProductIdRepositoryInterface;
use Modules\GeneralProductId\Repositories\GeneralProductIdRepository;

class ModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(
            base_path('modules/generalproductid/database/migrations')
        );

        $this->app->bind(
            GeneralProductIdRepositoryInterface::class,
             GeneralProductIdRepository::class
        );
    }

    public function boot(){

    }
}
