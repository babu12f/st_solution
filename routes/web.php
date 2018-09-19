<?php

Route::get('/', function () {
    //return view('welcome');
    //return view('scrap');
    return view('koli');
});

// Products Route
Route::get('/products', 'ProductController@index');
Route::get('/products/search', 'ProductController@search');
Route::get('/products/searchstockandprice', 'ProductController@stockAndPrice');
Route::get('/products/create', 'ProductController@create');
Route::Post('/products/create', 'ProductController@store')->name('product.create');
Route::get('/products/{id}/edit', 'ProductController@edit');
Route::post('/products/{id}/edit', 'ProductController@update')->name('product.update');
Route::get('/products/{id}/delete', 'ProductController@destroy');
Route::get('/products/{id}/show', 'ProductController@show');

// Purchase Route
Route::get('/purchase', 'PurchaseController@index');
Route::get('/purchase/create', 'PurchaseController@create');
Route::post('/purchase/create', 'PurchaseController@store')->name('purchase.create');
Route::get('/purchase/{id}/delete', 'PurchaseController@destroy');

// Sell Route
Route::get('/sells', 'SellController@index');
Route::get('/sells/create', 'SellController@create');
Route::post('/sells/create', 'SellController@store')->name('sell.create');
Route::get('/sells/{id}/delete', 'SellController@destroy');

// Route::post('/scrap', 'ScrapController@index');

Route::post('/koli', 'ScrapController@koli');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
