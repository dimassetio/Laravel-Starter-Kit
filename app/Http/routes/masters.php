<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'], 'namespace' => 'Masters'], function () {
    /**
     * Masters Routes
     */
    Route::get('masters/{id}/delete', ['as' => 'masters.delete', 'uses' => 'MastersController@delete']);
    Route::resource('masters', 'MastersController');
});
