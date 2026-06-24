<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->middleware(AdminMiddleware)->group(function (){

    Route::resource('warranties','WarrantyController')
        ->except(['create','edit']);

    Route::post('warranties/{id}/restore','WarrantyController@restore');

});

