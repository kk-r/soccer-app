<?php

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


Route::get('/', 'FrontendController@index')->name('home');
Route::get('/team/{id}/players', 'FrontendController@getPlayers')->name('getPlayers');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::group(['prefix' => 'admin', 'middleware' => ['auth:web']], function () {
    Route::get('/', 'AdminController@show');
    Route::get('players', 'AdminController@players')->name('admin_players');
    Route::get('teams', 'AdminController@teams')->name('admin_teams');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
