<?php

Route::get('finances/fund', 'FinanceController@fund')->name('finances.fund');

Route::get('finances/{question}', 'FinanceController@transfer');

Route::resource('finances', 'FinanceController');
