<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function (){

    Route::resource('brands','BrandController')
        ->except(['create','edit']);
    Route::post('brands/{id}/restore','BrandController@restore');

});

Route::get('brands/list','BrandController@all');
Route::get('brand/{slug}/categories','BrandCategoriesController');
