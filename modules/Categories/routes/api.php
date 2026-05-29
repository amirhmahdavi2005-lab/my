<?php

use \Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route ::resource('categories', 'CategoryController')
        ->except(['create', 'edit']);
    Route::post('categories/{Category}/restore', 'CategoryController@restore');
});
