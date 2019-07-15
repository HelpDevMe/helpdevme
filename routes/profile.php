<?php

Route::prefix('profile')->group(function () {
    Route::get('/', function () {
        return view('profile.infos');
    })->name('profile.index');

    Route::get('/password', function () {
        return view('profile.password');
    })->name('profile.password');

    Route::match(['put', 'patch'], '/{id}', 'ProfileController@update')->name('profile.update');
});
