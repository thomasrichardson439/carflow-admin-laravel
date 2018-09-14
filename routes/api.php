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
        Route::post('/create', 'AuthController@register');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/upload-documents', 'AuthController@uploadDocuments');
            Route::post('/profile-info', 'AuthController@profileInfo');
        });
    });
});
