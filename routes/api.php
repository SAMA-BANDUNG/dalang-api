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

Route::group(['prefix' => '/v1'], function() {
    Route::post('/register', 'Auth\AuthController@store');
    Route::post('/login', 'Auth\AuthController@login');
    Route::get('/account/verif/{id}', 'Auth\AuthController@verif');
    Route::get('/vendor/list', 'VendorController@list');
    Route::get('/vendor/{id}', 'VendorController@getById');

    Route::group(['middleware' => ['auth:sanctum', 'role:Super Admin']], function(){
        Route::get('/vendor/verif/{id}', 'AdminController@verif');
    });

    Route::group(['middleware' => ['auth:sanctum', 'role:User']], function(){
        Route::post('/register/vendor', 'VendorController@register');
    });

    Route::group(['middleware' => ['auth:sanctum', 'role:Vendor']], function(){
        
    });

    Route::group(['middleware' => ['auth:sanctum', 'role:Super Admin|User|Vendor']], function(){
        Route::get('/logout', 'Auth\AuthController@logout');
    });
});