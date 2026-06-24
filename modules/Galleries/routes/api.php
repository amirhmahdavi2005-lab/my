<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(AdminMiddleware)->group(function (){
    Route::match(['get','post'],
        'setting/gallery',
        'SettingController'
    );
});

