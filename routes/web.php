<?php

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
Route::get('/users', 'UserController@index');
Route::get('/users/show', 'UserController@show');
Route::get('/users/admin', 'UserController@getAdmin');
Route::get('/users/login/{id}', 'UserController@login');
Route::get('/users/getCurrent', 'UserController@getLoggedInUser');
Route::get('/users/logout', 'UserController@logout');
Route::get('/users/createTransaction', 'UserController@createTransaction');
Route::get('/users/getTransactions', 'UserController@getTransactions');
Route::get('/users/getAllTransactions', 'UserController@getAllTransactions');
Route::get('/users/add', 'UserController@addUser');
Route::get('/users/totals', 'UserController@getTotals');
Route::get('/users/userTotal/{id}', 'UserController@getUserTotals');


