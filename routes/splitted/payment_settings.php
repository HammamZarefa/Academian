<?php

Route::get('payment/gateways', 'SettingsController@paymentGateways')
->name('settings_payment_gateways');


Route::namespace('Payments')->group(function () {   

	// Controllers Within The "App\Http\Controllers\Payments" Namespace

    // Offline Payment Methods   
	Route::prefix('payment/offline/methods')->group(function () {			

		Route::get('/', 'OfflinePaymentMethodController@index')
    	->name('offline_payment_methods');

		Route::post('/paginate', 'OfflinePaymentMethodController@datatable')
			->name('datatable_offline_payment_methods');

		Route::get('/create', 'OfflinePaymentMethodController@create')
			->name('offline_payment_method_create');

		Route::post('/create', 'OfflinePaymentMethodController@store')
			->name('offline_payment_method_store');

		Route::get('/{method}/edit', 'OfflinePaymentMethodController@edit')
			->name('offline_payment_method_edit');

		Route::patch('/{method}/edit', 'OfflinePaymentMethodController@update')
			->name('offline_payment_method_update');

		Route::get('/{method}', 'OfflinePaymentMethodController@destroy')
			->name('offline_payment_method_delete');
	});
	// End of Work Levels  	    
});



Route::namespace('\App\PaymentGateways')->group(function () {  

	// Controllers Within The "App\Http\Controllers\Payments\Gateways\Settings" Namespace

    Route::patch('stripe/configure', 'stripe\StripeSettingsController@updateSettings')
        ->name('patch_settings_stripe');   

    Route::patch('braintree/configure', 'braintree\BraintreeSettingsController@updateSettings')
        ->name('patch_settings_braintree');

    Route::patch('paypal/checkout/configure', 'paypal_express\PaypalCheckoutSettingsController@updateSettings')
        ->name('patch_settings_paypal_checkout');
    
    Route::patch('paystack/configure', 'paystack\PaystackSettingsController@updateSettings')
		->name('patch_settings_paystack'); 
		

	Route::patch('two_checkout/configure', 'two_checkout\TwoCheckoutSettingsController@updateSettings')
		->name('patch_settings_two_checkout'); 
	
		Route::patch('payu/configure', 'payu\PayUSettingsController@updateSettings')
		->name('patch_settings_payu'); 
		
    
});