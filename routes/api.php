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


    // 要验证权限的路由
    Route::group(['prefix'=>'sys'],function (){

        Route::group(['prefix'=>'user'],function (){
            Route::get('/page','UserController@page');
        });

        Route::group(['prefix' => 'menu'],function (){
            Route::get('/page','MenuController@index');
        });

        Route::group(['prefix' => 'dept'],function (){
            Route::get('/page','DeptController@index');
            Route::post('/add','DeptController@store');
            Route::post('/destroy','DeptController@destroy');
            Route::post('/sort','DeptController@updateOrder');
            Route::post('/update/{dept}','DeptController@update');
        });
    });

});


