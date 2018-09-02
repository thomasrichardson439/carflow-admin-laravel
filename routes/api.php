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

Route::group(['namespace' => 'Auth'], function () {
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::post('/password/change', 'ResetPasswordController@change')->middleware('auth:api');
});

Route::group(['namespace' => 'Api'], function () {
    Route::post('/login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('users', 'UsersController');
    });


    Route::group(['prefix' => 'register'], function () {
        Route::post('/step-1', 'AuthController@registerStep1');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/step-2', 'AuthController@registerStep2');
            Route::post('/step-3', 'AuthController@registerStep3');
        });
    });
});
