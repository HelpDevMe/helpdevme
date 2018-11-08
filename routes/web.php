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

Route::view('/about', 'about')->name('about');

Route::resource('posts', 'PostController');

Route::resource('talks', 'TalkController');

Route::resource('users', 'UserController');

Route::resource('payments', 'PaymentController');

Route::get('activities/client', 'ActivityController@client')->name('activities.client');
Route::get('activities/freelancer', 'ActivityController@freelancer')->name('activities.freelancer');

Route::prefix('payments/paypal')->group(function () {
    
    Route::post('/', 'PaymentController@payWithPaypal')->name('payments.paypal');
    
    Route::prefix('/{post}')->group(function () {
    
        Route::get('/status', 'PaymentController@status')->name('payments.paypal.status');
    
        Route::get('/canceled', 'PaymentController@canceled')->name('payments.paypal.canceled');
    });
});

Route::resource('questions', 'QuestionController', ['except' => [
    'index', 'show'
]]);

Route::patch('posts/accept/{question}', 'PostController@accept')->name('posts.accept');

Route::get('/', 'QuestionController@index')->name('home');

Route::get('/{question}', ['as' => 'questions.show', 'uses' => 'QuestionController@show']);