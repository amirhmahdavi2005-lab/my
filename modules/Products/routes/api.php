<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function (){

    Route::resource('products','ProductController')
        ->except(['create','edit']);

    Route::post('products/{id}/restore','ProductController@restore');
    Route::post('/product/gallery','ProductGalleryController@upload');
    Route::delete('/product/gallery','ProductGalleryController@destroy');
    });
