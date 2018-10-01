<?php
declare(strict_types=1);
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
Route::group(['namespace' => 'Auth', 'middleware' => ['api']], function () {
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::post('/password/change', 'ResetPasswordController@change')->middleware('auth:api');
    Route::post('users/check-status', 'Auth\ForgotPasswordController@accessPassword');
});


Route::post('register/create', 'Api\AuthController@registers');

Route::group(['namespace' => 'Api', 'middleware' => ['api']], function () {
    Route::post('/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::apiResource('users', 'UsersController');
    });
    Route::post('validate-email', 'AuthController@validateUser');
    Route::post('users/check-status', 'UsersController@checkUserStatus');
});
