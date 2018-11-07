<?php

Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@profile')->name('profile.index');
    Route::get('/password', 'ProfileController@password')->name('profile.password');
    Route::match(['put', 'patch'], '/{id}', 'ProfileController@update')->name('profile.update');
});