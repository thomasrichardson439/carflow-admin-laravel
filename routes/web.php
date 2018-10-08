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
    Route::get('/users-data', 'UsersController@usersData')->name('users.usersData');
    Route::post('/approve/{id}', 'UsersController@approveDocuments');
    Route::post('/reject/{id}', 'UsersController@rejectDocuments');
    Route::post('/reject-profile/{id}', 'UsersController@rejectProfile');
});

Auth::routes();

Route::get('/reset-success', 'Auth\ResetPasswordController@showSuccessPage');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::post('/password/change', 'ResetPasswordController@change')->middleware('auth:api');
});
