<?php

/**
 * Pages Routes
 */
Route::get('/', function () { return redirect()->route('home'); });
Route::get('about', ['as'=>'about' , function () { return view('pages.about'); }, 'middleware'=>['web','auth']]);
Route::get('home', ['as'=>'home' , function () { return view('pages.home'); }, 'middleware'=>['web','auth']]);