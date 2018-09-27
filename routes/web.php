<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Admin\DashboardController@index')->middleware('auth.admin');

Route::group([
    'namespace' => 'Admin',
    'middleware' => 'auth.admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/', 'DashboardController@index')->name('home');
    Route::resource('users', 'UsersController');
    Route::get('/users-data', 'UsersController@usersData')
        ->name('users.usersData');

    Route::post('/approve/{id}', 'UsersController@approveDocuments');
    Route::post('/reject/{id}', 'UsersController@rejectDocuments');
});

Auth::routes();

Route::get('/reset-success', 'Auth\ResetPasswordController@showSuccessPage');
