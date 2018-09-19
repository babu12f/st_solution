<?php

Route::get('/', function () {
    //return view('welcome');
    //return view('scrap');
    return view('koli');
});

Route::post('/scrap', 'ScrapController@index');

Route::post('/koli', 'ScrapController@koli');
