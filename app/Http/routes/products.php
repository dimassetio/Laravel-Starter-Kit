<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web']], function () {
    /**
     * Products Routes
     */
    Route::resource('products', 'ProductController');
    Route::get('products/get-price/{id}', 'ProductController@getPrice');

    Route::resource('sales', 'SaleController');
    Route::get('monthly-sales', 'SaleController@monthlySales');
});
