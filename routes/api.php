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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'register', 'namespace' => 'Api'], function () {
    Route::get('/login', 'AuthController@login');
    Route::post('/step-1', 'AuthController@registerStep1');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/step-2', 'AuthController@registerStep2');
        Route::post('/step-3', 'AuthController@registerStep3');
    });
});
