<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers;

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

Route::get('/', 'Admin\UsersController@index')->name('user.index');
Route::group([
    'prefix' => 'admin',
    'namespace' => "Admin"
], function () {
    Route::resource('user', "UsersController");

    // categories route
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoriesController@index')->name('admin.category.index');
        Route::get('/getData', 'CategoriesController@getData')->name('admin.category.getData');
        Route::post('/delete-all', 'CategoriesController@deleteAll')->name('admin.category.deleteAll');
    });
    Route::group(['prefix' => 'reviews'], function () {
        Route::get('/', 'ReviewsController@index')->name('admin.review.index');
        Route::get('/getData', 'ReviewsController@getData')->name('admin.review.getData');
        Route::post('/delete-item/{id}', 'ReviewsController@deleteItem')->name('admin.review.deleteItem');
        Route::post('/delete-all', 'ReviewsController@deleteAll')->name('admin.review.deleteAll');
    });
});

Auth::routes();
