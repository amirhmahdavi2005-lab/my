<?php


namespace Modules\Colors\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\Repositories\ColorRepository;

class ModuleProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ColorRepositoryInterface::class,
            ColorRepository::class
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(
            base_path('modules/Colors/database/migrations')
        );
    }
}
