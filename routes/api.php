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

Route::namespace('Manage')->prefix('manage')->group(function (){
    Route::post('/auth/login', 'LoginController@login');
});


Route::namespace('Manage')->middleware(['refreshToken','permission'])->prefix('manage')->group(function (){

    Route::group(['prefix' => 'auth'],function (){
        Route::post('logout', 'LoginController@logout');
        Route::post('refresh', 'LoginController@refresh');
        Route::post('me', 'LoginController@me');
        Route::get('menu','AdminController@menu');
    });

    // 需要验证权限 'permission'

    Route::post('/uploadImage', 'UploadController@uploadImage');
    Route::post('/uploadFile', 'UploadController@uploadFile');
    Route::post('/uploadAlbum', 'UploadController@uploadAlbum');

    Route::group(['prefix'=>'sys'],function (){

        Route::group(['prefix'=>'user'],function (){
            Route::get('/page','AdminController@index');
            Route::post('/create','AdminController@store');
            Route::post('/destroy','AdminController@destroy');
            Route::post('/move','AdminController@move');
            Route::post('/update/{admin}','AdminController@update');
        });

        Route::group(['prefix' => 'menu'],function (){
            Route::get('/page','MenuController@index');
            Route::post('/create','MenuController@store');
            Route::post('/destroy','MenuController@destroy');
            Route::post('/update/{menu}','MenuController@update');
        });

        Route::group(['prefix' => 'role'],function (){
            Route::get('/page','RoleController@index');
            Route::post('/create','RoleController@store');
            Route::post('/destroy','RoleController@destroy');
            Route::post('/update/{role}','RoleController@update');
        });

        Route::group(['prefix' => 'dept'],function (){
            Route::get('/list','DeptController@index');
            Route::post('/create','DeptController@store');
            Route::post('/destroy','DeptController@destroy');
            Route::post('/sort','DeptController@updateOrder');
            Route::post('/update/{dept}','DeptController@update');
        });

    });

    Route::group(['prefix'=>'product'],function (){

        Route::group(['prefix' => 'category'],function (){
            Route::get('/page','CategoriesController@page');
            Route::get('/all','CategoriesController@all');
            Route::post('/create','CategoriesController@store');
            Route::post('/destroy/{category}','CategoriesController@destroy');
            Route::post('/update/{category}','CategoriesController@update');
        });

        Route::group(['prefix' => 'brand'],function (){
            Route::get('/page','BrandController@page');
            Route::post('/create','BrandController@store');
            Route::post('/destroy/{brand}','BrandController@destroy');
            Route::post('/update/{brand}','BrandController@update');
        });

        Route::group(['prefix' => 'goods'],function (){
            Route::get('/page','ProductController@page');
            Route::post('/create','ProductController@store');
            Route::post('/destroy/{product}','ProductController@destroy');
            Route::post('/update/{product}','ProductController@update');
        });

        Route::group(['prefix'=>'album'],function (){
            Route::get('/page','AlbumController@page');
            Route::get('/getAlbumList','AlbumController@getAlbumList');
            Route::post('/addAlbum','AlbumController@addAlbum');
            Route::post('/editAlbum/{album}','AlbumController@editAlbum');
            Route::post('/deleteAlbum/{album}','AlbumController@deleteAlbum');
            Route::post('/modifyPicName','AlbumController@modifyPicName');
            Route::post('/modifyFileAlbum','AlbumController@modifyFileAlbum');
            Route::post('/deleteFile','AlbumController@deleteFile');
        });
    });

});


