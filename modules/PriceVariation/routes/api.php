<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function (){

    Route::get('/category/{id}/price-variation',
        'CategoryPriceVariationItemsController@index');

    Route::post('/category/{id}/price-variation',
        'CategoryPriceVariationItemsController@store');
    Route::resource('products/price-variations',
        'PriceVariationsController')->except(['create','edit']);

    Route::post('products/price-variations/{price_variation}/restore',
        'PriceVariationsController@restore');
});
Route::get('/category/{id}/price-variation/items',
    'CategoryPriceVariationItemsController@items');
Route::get('product/variation/items',
    'VariationItemsController'
);
Route::post('prices/export','PricesExportController');

Route::post('prices/update','UpdatePricesController');

Route::get('product/{id}/variations', 'PriceVariationsController@byProduct');
