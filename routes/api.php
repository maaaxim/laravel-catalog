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

Route::get('categories/{category}/products', 'CategoryController@products');
Route::get('products/{product}/sell', 'ProductController@sellItem');
Route::get('products/{product}/return', 'ProductController@returnItem');
Route::apiResource('categories', 'CategoryController')->only(['index']);

Route::group(['middleware' => 'auth:api'], function(){
	Route::apiResource('categories', 'CategoryController')->only(['store', 'update', 'destroy']);
	Route::apiResource('products', 'ProductController')->only(['store', 'update', 'destroy']);
	Route::get('/user', function (Request $request) {
		return $request->user();
	});
});