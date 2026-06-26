<?php

namespace App\Services;

class ProviderLoaderService
{
    public function load(): void
    {
        $path = base_path('modules');
        $namespaceRoot = 'modules';
        $modules = array_diff(scandir($path), ['.', '..', 'Main']);

        foreach ($modules as $module) {
            $providersDir = $path . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'providers';
            if (!is_dir($providersDir)) {
                continue;
            }
            $providerFiles = array_diff(scandir($providersDir), ['.', '..']);
            foreach ($providerFiles as $file) {
                if (str_ends_with($file, '.php')) {
                    $class = '\\' . ucfirst($namespaceRoot) . '\\' . $module . '\\Providers\\' . str_replace('.php', '', $file);
                    if (class_exists($class)) {
                        app()->register($class);
                    }
                }
            }
        }
    }
}
