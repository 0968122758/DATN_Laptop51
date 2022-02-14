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
});

Auth::routes();
