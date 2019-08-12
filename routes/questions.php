<?php

Route::resource('questions', 'QuestionController', ['except' => ['show']]);

Route::prefix('/{question}')->group(function () {

    Route::get('/', ['as' => 'questions.show', 'uses' => 'QuestionController@show']);

    Route::get('/finalize', 'QuestionController@finalize');
});
