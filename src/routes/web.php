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

Route::get('/sign-in/github','UserController@signin');

Route::get('/sign-in/github/redirect','UserController@redirect');

Route::get('/sign-in/fb','UserController@signinFB');

Route::get('/sign-in/fb/redirect','UserController@redirectFB');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    var_dump("test route");die;
});

Route::get('/posts/index/{id?}','PostController@index');

Route::post('/posts/create','PostController@create');

Route::put('/posts/update/{id}','PostController@update');

Route::delete('/posts/delete/{id}','PostController@delete');
