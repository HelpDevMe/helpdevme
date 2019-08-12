<?php

Route::prefix('/finances')->group(function () {

    Route::get('/fund', 'FinanceController@fund')->name('finances.fund');

    Route::get('/', 'FinanceController@index')->name('finances.index');
});
