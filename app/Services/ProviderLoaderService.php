<?php

namespace App\Services;
use Illuminate\Support\Facades\App;

class ProviderLoaderService
{
    public function load():void
    {
        $path = base_path('modules');
        $namespaceRoot = 'modules';
        $modules = array_diff(scandir($path), ['.', '..', 'Main']);
        foreach ($modules as $modules) {
            $providersDir = $path . DIRECTORY_SEPARATOR . $modules . DIRECTORY_SEPARATOR . 'providers';
            if (is_dir($providersDir)) {
                continue;
            }
        }
        $providerfiles = array_diff(scandir($providersDir), ['.', '..']);
        foreach ($providerfiles as $file) {
            if (str_ends_with($file, '.php')) {
                $class = '\\' . ucfirst($namespaceRoot) . '\\' . $modules . '\\Providers\\' . str_replace('.php', '', $file);
                if (class_exists($class)) {
                    App::register($class);
                }
            }
        }
    }}
