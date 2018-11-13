<?php

Route::resource('posts', 'PostController');

Route::get('posts/accept/{post}', 'PostController@accept')->name('posts.accept');

Route::get('posts/refused/{post}', 'PostController@refused')->name('posts.refused');