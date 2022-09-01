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
Route::get('test','UserController@test'); 

Route::post('/auth/register','AuthController@register');
Route::post('auth/login','AuthController@login');
Route::get('users','UserController@user');
Route::get('users/profile','UserController@profile')->middleware('auth:api');
Route::get('users/profile/{id}','UserController@profileById')->middleware('auth:api');
Route::put('users/{user}','UserController@update')->middleware('auth:api');
Route::post('post','PostController@add')->middleware('auth:api');
Route::put('post/{post}','PostController@update')->middleware('auth:api'); 
Route::delete('post/{post}','PostController@delete')->middleware('auth:api');