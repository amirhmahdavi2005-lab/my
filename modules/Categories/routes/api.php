<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(AdminMiddleware)->group(function () {

    Route::resource('categories', 'CategoryController')
        ->except(['create', 'edit']);

    Route::post(
        'categories/{Category}/restore',
        'CategoryController@restore'
    );

    Route::post(
        '/category/{id}/specification',
        'SpecificationsController@store'
    );

    Route::delete(
        '/category/specification/{id}',
        'SpecificationsController@destroy'
    );
});

Route::get(
    'category/all',
    'AllCategoryController'
);

Route::get(
    '/category/{id}/specifications',
    'CategorySpecificationsController'
);
