<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::namespace('API')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'RegisterController@login');
    Route::middleware(['auth:api'])->group(function () {
        Route::resource('categories', 'CategoryController')->only(['index', 'show']);
        Route::resource('products', 'ProductController')->only(['index', 'show']);
        Route::post('logout', 'RegisterController@logout');
    });
});
