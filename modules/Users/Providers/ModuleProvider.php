<?php

namespace Modules\Users\Providers;
use Illuminate\Support\ServiceProvider;
use Modules\Users\Contracts\UserRepositoryInterface;
use Modules\Users\Repositories\UserRepository;


class ModuleProvider extends ServiceProvider
{
    public function register():void{
        $this->loadMigrationsFrom(base_path('modules/Users/database/migrations'));


        require_once base_path('Modules/Users/helpers.php');
        $this->app->singleton(UserRepositoryInterface::class,
            UserRepository::class);
    }

    public function boot():void
    {

    }
}
