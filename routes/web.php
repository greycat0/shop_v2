<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ItemController@index');
Route::get('/items', 'ItemController@list');
Route::post('/createitem', 'ItemController@create')->middleware('isadmin');
Route::post('/updateitem/{id}', 'ItemController@update')->middleware('isadmin');
Route::post('/deleteitem/{id}', 'ItemController@delete')->middleware('isadmin');
Route::get('/cart', 'ItemController@cart');
Route::get('/cartitemcount', 'ItemController@cartItemCount');
Route::post('/cart', 'ItemController@updateItemInCart');
Route::get('/buy', 'ItemController@buy');
Route::get('/item/{id}', 'ItemController@show');
Route::get('/creationitem', 'ItemController@createItemPage')->middleware('isadmin');

Route::post('/categories', 'CategoryController@list');
Route::post('/createcategory', 'CategoryController@create')->middleware('isadmin');
Route::post('/updatecategory/{id}', 'CategoryController@update')->middleware('isadmin');
Route::post('/deletecategory/{id}', 'CategoryController@delete')->middleware('isadmin');

Route::get('/about', 'Controller@about');
Route::get('/delivery', 'Controller@delivery');
Route::get('/payment', 'Controller@payment');
// //Route::post('/item/{id}', 'ItemController@item');

// Route::post('/items', 'ItemController@items');

Auth::routes();
