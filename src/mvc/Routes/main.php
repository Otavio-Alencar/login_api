<?php


use App\Http\Route;
Route::get('/',          'UserController@index');
Route::post('/users/create',        'UserController@store');
Route::post('/users/login',         'UserController@login');
Route::get('/users/fetch',          'UserController@fetch');
Route::get('/db/table',          'DBController@newTable');
Route::get('/db/table/delete',          'DBController@removeTable');
Route::put('/users/update',         'UserController@update');
Route::delete('/users/delete', 'UserController@remove');