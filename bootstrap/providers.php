<?php

return [
    App\Providers\AppServiceProvider::class,
    \Modules\Main\Providers\ModuleProvider::class,
    \Modules\Users\Providers\ModuleProvider::class,
    \Modules\Categories\Providers\ModuleProvider::class,
    \Modules\Brands\Providers\ModuleProvider::class,
    \Modules\Colors\Providers\ModuleProvider::class, // اضافه کن
    Maatwebsite\Excel\ExcelServiceProvider::class,
];
