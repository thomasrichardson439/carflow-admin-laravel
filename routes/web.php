<?php

Route::get('/', 'Admin\DashboardController@index')->middleware('auth.admin');

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth.admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::get('/', 'DashboardController@index')->name('home');

    Route::resource('users', 'UsersController');

    Route::group(['prefix' => 'users'], function () {
        Route::post('approve/{id}', 'UsersController@approve');
        Route::post('reject/{id}', 'UsersController@reject');

        Route::post('approve-profile-changes/{id}', 'UsersController@approveProfileChanges');
        Route::post('reject-profile-changes/{id}', 'UsersController@rejectProfileChanges');
    });

    Route::resource('cars', 'CarsController');
    Route::resource('receipts', 'ReceiptsController');
});

Auth::routes();

Route::get('/reset-success', 'Auth\ResetPasswordController@showSuccessPage');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::post('/password/change', 'ResetPasswordController@change')->middleware('auth:api');
});
