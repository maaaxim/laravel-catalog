<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::apiResource('categories', 'CategoryController')->only(['index', 'store', 'show', 'update', 'delete']);
Route::get('categories/{category}/products', 'CategoryController@products');

Route::apiResource('products', 'ProductController')->only(['index', 'store', 'show', 'update', 'delete']);
Route::get('products/{product}/sell', 'ProductController@sell');
Route::get('products/{product}/return', 'ProductController@return');