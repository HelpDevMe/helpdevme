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

Auth::routes();

Route::get('/', 'QuestionController@index')->name('home');

Route::view('/about', 'about')->name('about');

Route::get('/{question}', ['as' => 'questions.show', 'uses' => 'QuestionController@show']);

Route::resource('questions', 'QuestionController', ['except' => [
    'index', 'show'
]]);

Route::resource('posts', 'PostController');
