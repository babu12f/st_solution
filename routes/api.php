<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function (Request $request) {
    return response()->json([
        'name'=>'babor',
        'email'=>'b@k.com'
    ]);
});


Route::group(['middleware'=>'auth:api'], function(){
    
    Route::resource('products', 'ProductsController');
    
});
