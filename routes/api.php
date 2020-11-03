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
Route::post('/register', 'API\RegisterController@register');


Route::middleware('auth:api')->group( function () {
    Route::get('/posts', 'API\PostsController@index');
    Route::get('/post', 'API\PostsController@show');
    Route::post('/post', 'API\PostsController@store');
    Route::put('/post', 'API\PostsController@update');
    Route::delete('/post', 'API\PostsController@destroy');
});