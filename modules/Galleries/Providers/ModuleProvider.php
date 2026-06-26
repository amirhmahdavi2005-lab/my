<?php

namespace Modules\Galleries\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Modules\Galleries\Contracts\GalleryRepositoryInterface;
use Modules\Galleries\Contracts\GalleryServiceInterface;
use Modules\Galleries\Contracts\GalleryUploadFilesServiceInterface;
use Modules\Galleries\Events\ProductPageQuery;
use Modules\Galleries\Models\Gallery;
use Modules\Galleries\Repositories\GalleryRepository;
use Modules\Galleries\Services\GalleryRemoveFileService;
use Modules\Galleries\Services\GalleryUploadFilesService;
use Modules\Galleries\Services\SaveGalleryFileService;
use Modules\Galleries\Contracts\GalleryRemoveFileServiceInterface;

class ModuleProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->loadMigrationsFrom(base_path('modules/Galleries/database/migrations'));


        $this->app->singleton(
            GalleryServiceInterface::class,
            SaveGalleryFileService::class
        );
        $this->app->singleton(
            GalleryRepositoryInterface::class,
            GalleryRepository::class
        );

        $this->app->singleton(
            GalleryUploadFilesServiceInterface::class,
            GalleryUploadFilesService::class
        );

        $this->app->singleton(
            GalleryRemoveFileServiceInterface::class,
            GalleryRemoveFileService::class
        );
    }

    public function boot(): void
    {
        Builder::macro('gallery',function (){
            $query=$this->getModel()->hasMany(
                Gallery::class,
                'tableable_id',
                'id'
            );
            if(defined('gallery_tableable_type')){
                $query->where('tableable_type',gallery_tableable_type);
            }
            return $query;
        });
    }
}
