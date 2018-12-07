<?php

Route::get('/', 'MainController@index');

Route::get('/main', 'MainController@index')->name('home-page');
Route::get('/drivers', 'MainController@drivers');
Route::get('/owners', 'MainController@owners');
Route::get('/how-it-works', 'MainController@how_it_works');
Route::get('/about-us', 'MainController@about_us');
Route::get('/faq', 'MainController@faq');
Route::get('/register-car', 'MainController@register_car')->name('register_car');
Route::get('/register-driver', 'MainController@register_driver')->name('register_driver');
Route::post('/user/register-driver', 'UsersController@store')->name('save_driver');
Route::post('/user/register-car-owner', 'UsersController@store_car')->name('save_car_owner');
Route::post('/user/validate-email', 'UsersController@validateEmail')->name('validate-email');
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

        Route::get('{id}/policy', 'UsersController@policy');
    });

    Route::resource('cars', 'CarsController');
    Route::resource('receipts', 'ReceiptsController');

    Route::group(['prefix' => 'book'], function () {
        Route::post('{id}/approve', 'UsersController@approve');
        Route::post('{id}/reject', 'UsersController@reject');

        Route::post('{id}/approve-profile-changes', 'UsersController@approveProfileChanges');
        Route::post('{id}/reject-profile-changes', 'UsersController@rejectProfileChanges');

        Route::get('{id}/policy', 'UsersController@policy');
    });
});

Auth::routes();

Route::get('/reset-success', 'Auth\ResetPasswordController@showSuccessPage');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::post('/password/change', 'ResetPasswordController@change')->middleware('auth:api');
});
