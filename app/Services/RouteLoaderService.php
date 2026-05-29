<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

class RouteLoaderService
{
    public function load():void{
        $path = base_path('modules');
        $namespaceRoot ='Modules';
        $modules = array_diff(scandir($path), ['.', '..']);
        foreach ($modules as $module) {
            $modulepath = $path.DIRECTORY_SEPARATOR.$module;
            $namespace = '\\'.$namespaceRoot.'\\'.$module.'\\Http\\Controllers';
            $apiRouteFile = $modulepath.'/routes/api.php';
            $webRouteFile = $modulepath.'/routes/web.php';
            if (file_exists($apiRouteFile)) {
                Route::middleware('api')
                    ->prefix('api')->namespace ($namespace) ->group($apiRouteFile);
            }
        }

    }
}



