<?php
Route::namespace('\App\PaymentGateways')->group(function () {

    // Controllers Within The "App\Http\Controllers\PaymentGateways" Namespace

    // Paypal Checkout
    Route::prefix('paypal/checkout')->group(function () {

        Route::get('/', 'paypal_express\PaypalCheckoutController@index')
            ->name('paypal_checkout');

        Route::post('process', 'paypal_express\PaypalCheckoutController@capturePayment')
            ->name('paypal_checkout_process');

        Route::post('generate/token', 'paypal_express\PaypalCheckoutController@generateToken')
            ->name('paypal_checkout_generate_token');
    });

    // Stripe
    Route::prefix('stripe')->group(function () {

        Route::get('/', 'stripe\StripeController@index')
            ->name('stripe');

        Route::post('process', 'stripe\StripeController@capturePayment')
            ->name('stripe_process');
    });

    //Braintree
    Route::prefix('braintree')->group(function () {

        Route::get('/', 'braintree\BraintreeController@index')
            ->name('braintree');

        Route::post('process', 'braintree\BraintreeController@capturePayment')
            ->name('braintree_process');
    });


    //Paystack
    Route::prefix('paystack')->group(function () {

        Route::get('/', 'paystack\PaystackController@index')
            ->name('paystack');

        Route::post('/verify', 'paystack\PaystackController@verifyPayment')
            ->name('paystack_verify_payment');
    });


    //2Checkout
    Route::prefix('two_checkout')->group(function () {

        Route::get('/', 'two_checkout\TwoCheckoutController@index')
            ->name('two_checkout');

        Route::post('process', 'two_checkout\TwoCheckoutController@capturePayment')
            ->name('two_checkout_process');
    });

     //Paystack
     Route::prefix('payu')->group(function () {

        Route::get('/', 'payu\PayUController@index')
            ->name('payu');

        Route::post('/verify', 'payu\PayUController@verifyPayment')
            ->name('payu_verify_payment');

        Route::post('/payment-captured', 'payu\PayUController@paymentCaptured')
            ->name('payu_payment_captured');
    });

});
