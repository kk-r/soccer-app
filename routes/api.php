<?php

use Illuminate\Http\Request;

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


Route::get('teams', 'TeamController@index');
Route::get('teams/{id}/', 'TeamController@show');
Route::get('players', 'PlayerController@index');
Route::get('teams/{id}/players', 'TeamController@getPlayer');
Route::resource('players', 'PlayerController')->except('index');
Route::resource('teams', 'TeamController')->except(['index', 'show']);
