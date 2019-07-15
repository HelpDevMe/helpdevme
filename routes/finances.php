<?php

Route::get('finances/fund', function () {
    return view('finances.fund');
})->name('finances.fund');

Route::get('finances/{question}', 'FinanceController@transfer');

Route::get('finances', function () {
    return view('finances.index');
})->name('finances.index');
