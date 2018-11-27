<?php

Route::get('/', 'MainController@index');

Route::get('/main', 'MainController@index');
Route::get('/drivers', 'MainController@drivers');
Route::get('/owners', 'MainController@owners');
Route::get('/how-it-works', 'MainController@how_it_works');
Route::get('/about-us', 'MainController@about_us');
Route::get('/faq', 'MainController@faq');
Route::get('/register-car', 'MainController@register_car');
Route::get('/register-driver', 'MainController@register_driver');
Route::get('/welcome', 'MainController@welcome');

//Route::get('/', 'Admin\DashboardController@index')->middleware('auth.admin');

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth.admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {

    Route::get('/', 'UsersController@index');

    Route::resource('users', 'UsersController');

    Route::group(['prefix' => 'users'], function () {
        Route::post('{id}/approve', 'UsersController@approve');
        Route::post('{id}/reject', 'UsersController@reject');

        Route::post('{id}/approve-profile-changes', 'UsersController@approveProfileChanges');
        Route::post('{id}/reject-profile-changes', 'UsersController@rejectProfileChanges');

        Route::post('{id}/policy', 'UsersController@policy');
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
