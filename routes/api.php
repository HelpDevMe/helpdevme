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

Route::resource('posts', 'Api\PostController');

Route::resource('tags', 'Api\TagController');

Route::resource('questions', 'Api\QuestionController');

Route::resource('talks', 'Api\TalkController');
