<?php

Route::resource('payments', 'PaymentController');

Route::prefix('/payments')->group(function () {

    Route::prefix('/paypal')->group(function () {

        Route::post('/pay', 'PaymentController@pay')->name('payments.paypal.pay');

        Route::prefix('/fund')->group(function () {

            Route::post('/', 'PaymentController@fund')->name('payments.paypal.fund');

            Route::prefix('/{finance}')->group(function () {

                Route::get('/status', 'PaymentController@statusFund')->name('payments.paypal.fund.status');

                Route::get('/canceled', 'PaymentController@canceledFund')->name('payments.paypal.fund.canceled');
            });
        });

        Route::prefix('/{post}')->group(function () {

            Route::get('/status', 'PaymentController@statusPay')->name('payments.paypal.status');

            Route::get('/canceled', 'PaymentController@canceledPay')->name('payments.paypal.canceled');
        });
    });

    Route::post('/transfer', 'PaymentController@transfer')->name('payments.transfer');
});
