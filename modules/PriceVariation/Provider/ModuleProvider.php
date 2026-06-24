<?php

namespace Modules\PriceVariation\Provider;

use Carbon\Laravel\ServiceProvider;


class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom(base_path('modules/PriceVariation/database/migrations'));
    }
}
