<?php

Route::resource('questions', 'QuestionController', ['except' => [
    'index', 'show'
]]);

Route::get('/', 'QuestionController@index')->name('home');

Route::prefix('/{question}')->group(function () {
    
    Route::get('/', ['as' => 'questions.show', 'uses' => 'QuestionController@show']);
    
    Route::get('/finalize', 'QuestionController@finalize');
});
