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

    // contacts route
    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', 'ContactsController@index')->name('admin.contact.index');
        Route::get('/getData', 'ContactsController@getData')->name('admin.contact.getData');
        Route::post('/delete-all', 'ContactsController@deleteAll')->name('admin.contact.deleteAll');
    });
});

Auth::routes();
