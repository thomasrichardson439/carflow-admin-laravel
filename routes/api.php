<?php

declare(strict_types=1);

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

        Route::group(['prefix' => 'users'], function() {
            Route::get('me', 'UsersController@me');
            Route::post('update', 'UsersController@update');
            Route::post('resubmit', 'UsersController@reSubmit');
            Route::get('status', 'UsersController@status');
        });

        Route::group(['prefix' => 'cars'], function() {
            Route::get('available', 'CarsController@availableForBooking');
            Route::get('{id}/book', 'CarsController@bookGet');
            Route::post('{id}/book', 'CarsController@bookPost');
        });

        Route::group(['prefix' => 'bookings'], function() {
            Route::get('upcoming', 'BookingsController@upcoming');
            Route::get('history', 'BookingsController@history');
            Route::get('{id}', 'BookingsController@show');
            Route::post('{id}/start', 'BookingsController@start');
            Route::post('{id}/end', 'BookingsController@end');
            Route::post('{id}/cancel', 'BookingsController@cancel');
            Route::post('{id}/receipt', 'BookingsController@receipt');

            Route::group(['prefix' => '{id}/help'], function() {
                Route::post('damage', 'BookingsHelpController@damage');
                Route::post('malfunction', 'BookingsHelpController@malfunction');
                Route::post('late', 'BookingsHelpController@late');
            });
        });
    });

    Route::post('validate-email', 'AuthController@validateEmail');
});