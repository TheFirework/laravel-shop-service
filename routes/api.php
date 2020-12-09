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

Route::namespace('Manage')->group(function (){
    Route::post('/manage/auth/login', 'LoginController@login');
});


Route::namespace('Manage')->middleware(['refreshToken'])->prefix('manage')->group(function (){

    Route::group(['prefix' => 'auth'],function (){
        Route::post('logout', 'LoginController@logout');
        Route::post('refresh', 'LoginController@refresh');
        Route::post('me', 'LoginController@me');
        Route::get('permmenu','UserController@permmenu');
    });

    Route::group(['prefix' => 'dept'],function (){
        Route::get('/','DeptController@index');
        Route::post('/','DeptController@store');
        Route::post('/destroy','DeptController@destroy');
        Route::post('/updateOrder','DeptController@updateOrder');
        Route::post('/{dept}','DeptController@update');
    });

    Route::group(['prefix'=>'admin'],function (){
       Route::get('/','UserController@page');
    });

    Route::group(['prefix' => 'menu'],function (){
        Route::get('/','MenuController@index');
    });
});


