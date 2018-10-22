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

Route::middleware('auth:api')->group(function () {

    Route::get('users', function (Request $request) {
        return \App\User::all();
    });

    Route::get('messages', 'Api\PostController@fetchMessages');
    Route::post('messages', 'Api\PostController@sendMessage');
    Route::get('private-messages/{user}', 'Api\PostController@privateMessages')->name('privateMessages');
    Route::post('private-messages/{user}', 'Api\PostController@sendPrivateMessage')->name('privateMessages.store');
});
