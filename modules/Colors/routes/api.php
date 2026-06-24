<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function (){

    Route::resource('colors','ColorController')
        ->except(['create','edit']);

    Route::post('colors/{id}/restore','ColorController@restore');
});

Route::get('search/{category_id}/colors','ColorsForFilterController');

Route::get('colors/list','ColorController@all');
