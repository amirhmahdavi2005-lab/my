<?php

namespace Modules\Colors\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Colors\Contracts\ColorFilterRepositoryInterface;
use Modules\Colors\Contracts\ColorRepositoryInterface;
use Modules\Colors\Contracts\ProductColorRepositoryInterface;
use Modules\Colors\Events\AddOrRemoveProductColor;
use Modules\Colors\Events\CheckRoleAccess;
use Modules\Colors\Events\SearchProductsQuery;
use Modules\Colors\Models\ProductColor;
use Modules\Colors\Repositories\ColorFilterRepository;
use Modules\Colors\Repositories\ColorRepository;
use Modules\Colors\Repositories\ProductColorRepository;

class ModuleProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->loadMigrationsFrom(
            base_path('modules/colors/database/migrations')
        );

        $this->app->bind(
            ColorRepositoryInterface::class,
            ColorRepository::class);

        $this->app->bind(
            ColorFilterRepositoryInterface::class,
            ColorFilterRepository::class
        );

        $this->app->bind(
            ProductColorRepositoryInterface::class,
            ProductColorRepository::class
        );

    }

    public function boot(): void
    {
        addEvent('route-access:check',CheckRoleAccess::class);
        addEvent('price-variation:updated',AddOrRemoveProductColor::class);
        addEvent('search-products:query',SearchProductsQuery::class);


        \Illuminate\Database\Eloquent\Builder::macro('productColors', function () {
            return $this->getModel()->hasMany(ProductColor::class,'product_id','id');
        });

        addArrayList('variations',[
            'title'=>'رنگ',
            'model_type'=>'\Modules\Colors\Models\Color',
            'repository'=>ColorRepositoryInterface::class
        ]);
    }
}
