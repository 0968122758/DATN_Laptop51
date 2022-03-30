<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin;

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
    // user route
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UsersController@index')->name('admin.user.index');
        Route::get('/getData', 'UsersController@getData')->name('admin.user.getData');
        Route::delete('/deleteItem/{id}', 'UsersController@delete_record')->name('admin.user.delete_record');
        Route::post('/deleteAll', 'UsersControllerr@deleteAll')->name('admin.user.deleteAll');
        Route::post('/search', 'UsersController@Search');
        Route::get('/edit/{id}', 'UsersController@edit')->name('admin.users.edit');
        Route::put('/edit', 'UsersController@saveEdit');


    });

    // categories route
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoriesController@index')->name('admin.category.index');
        Route::get('/getData', 'CategoriesController@getData')->name('admin.category.getData');
        Route::post('/delete-all', 'CategoriesController@deleteAll')->name('admin.category.deleteAll');
    });
});

Auth::routes();
