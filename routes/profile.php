<?php

Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@infos')->name('profile.infos');

    Route::get('/password', 'ProfileController@password')->name('profile.password');

    Route::match(['put', 'patch'], '/{id}', 'ProfileController@update')->name('profile.update');
});
