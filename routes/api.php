<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'cors', 'prefix' => 'v1'], function () {
    Route::get('/heartbeats', 'V1\API\GeneralController@heartbeats');
    Route::get('/app/version', 'V1\API\GeneralController@appVersion');

    Route::group(['namespace' => 'V1\API\Admin\Auth', 'prefix' => 'admin'], function () {
        Route::post('login', 'AdminAuthAPIController@login');
        Route::post('register', 'AdminAuthAPIController@store');
    });

    Route::group(['namespace' => 'V1\API\User\Auth', 'prefix' => 'user'], function () {
        Route::post('login', 'UserAuthAPIController@login');
        Route::post('register', 'UserAuthAPIController@store');
        Route::post('update', 'UserAuthAPIController@update')->middleware(['assign.guard:users', 'jwt.auth']);

    });

    Route::group(['namespace' => 'V1\API\Admin', 'prefix' => 'admin', 'middleware' => ['assign.guard:admins', 'jwt.auth']], function () {
        Route::resource('users', 'UserAPIController');
        Route::resource('posts', 'PostAPIController');
    });

    Route::group(['namespace' => 'V1\API\User', 'prefix' => 'user', 'middleware' => ['assign.guard:users', 'jwt.auth']], function () {
        Route::resource('posts', 'PostAPIController');
    });
});






