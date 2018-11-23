<?php

Route::get('finances/{question}', 'FinanceController@transfer');

Route::resource('finances', 'FinanceController');
