<?php

namespace App\Routes;
use App\Http\Route;
 
Route::get('/', 'HomeController@index');
Route::get('/users', 'UserController@show');
Route::post('/user', 'UserController@create');
Route::put('/user', 'UserController@edit');
Route::delete('/user', 'UserController@remove');
