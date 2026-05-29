<?php

namespace Modules\main\Providers;
use App\Services\RouteLoaderService;
use Illuminate\Support\ServiceProvider;
use App\services\ProviderLoaderService;
use Modules\Main\Contracts\CrudPaginationInterface;
use Modules\Main\Contracts\CrudRepositoryInterface;
use Modules\Main\Repositories\CrudPagination;
use Modules\Main\Repositories\CrudPaginationRepository;
use Modules\Main\Repositories\CrudRepository;

class ModuleProvider extends ServiceProvider
{
    public function register():void{
        (new ProviderLoaderService())->load();
        (new RouteLoaderService())->load();
        require_once base_path().'/modules/Main/helper.php';
        $this->app->singleton(
            CrudRepositoryInterface::class,
            CrudRepository::class
        );
        $this->app->singleton(
            CrudPaginationInterface::class,
            CrudPaginationRepository::class
        );

}

    public function boot():void
    {

}
}
