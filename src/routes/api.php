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

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api'], function() {
    Route::group(['namespace'=>'Auth'], function() {
        Route::post('/register', ['uses' => 'RegisterController@register']);
        Route::post('/login', ['uses' => 'LoginController@login']);
        Route::post('/logout', ['uses' => 'LogoutController@logout'])->middleware('auth:api');
    });

    /*Route::apiResource('posts', 'PostController');*/
    Route::match(['GET', 'HEAD'], '/posts', ['uses'=>'PostController@index']);
    Route::match(['GET', 'HEAD'], '/posts/{post}', ['uses'=>'PostController@show']);
    Route::middleware(['auth:api'])->group(function () {
        Route::post('/posts', ['uses'=>'PostController@store']);
        Route::match(['PUT', 'PATCH'], '/posts/{post}', ['uses'=>'PostController@update'])->middleware('can:update-post,post');
        Route::delete('/posts/{post}', ['uses'=>'PostController@destroy'])->middleware('can:delete-post,post');
    });

});
