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
Route::post('auth', 'API\UserController@login')->name('user_login');


//Rotas autenticadas , somente com token é possivel acessar
Route::group(['prefix' => 'admin','middleware' => ['auth:api']], function() {
    Route::get('/show/{id}', 'API\UserController@show')->name('show_user');
    Route::get('/logout','API\UserController@logout')->name('logout_user');
    Route::post('/get_contents', 'API\ArticleController@get_contents')->name('get_content');
});
