<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function (){

    Route::resource('general-product-ids','GeneralProductIdController')
        ->except(['create','edit']);

    Route::post('/general-product-ids/{id}/restore','GeneralProductIdController@restore');

});

Route::get('/general-product-ids/{category_id}/list','CategoryGeneralProductIds');
