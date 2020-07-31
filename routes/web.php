<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::resource('users', 'UserController')->only(['index', 'show']);
    Route::get('/users-get', 'UserController@getUsers')->name('users.get');
    Route::resource('categories', 'CategoryController');
    Route::get('/categories-get', 'CategoryController@getCategories')->name('categories.get');
    Route::resource('products', 'ProductController');
    Route::get('/products-get', 'ProductController@getProducts')->name('products.get');
    Route::get('/products/{product}/image', 'ProductController@productImage')->name('products.image.create');
    Route::post('/products/{product}/image', 'ProductController@uploadProductImage')->name('products.image.upload');
});