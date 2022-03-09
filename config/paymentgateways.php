<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    |
    'name' => '',
     The route that will take the user to pay through the gateway
     route' => ''
     The fields that will be fetched from database when loading the settings page
    'fields' => [];
    |
    */

    'gateways' => [
        'paypal_checkout' => [
            'name' => 'Paypal Smart Checkout',
            'route' => 'paypal_checkout',       

        ],
        'stripe' => [
            'name' => 'Stripe',
            'route' => 'stripe',          
        ],
        'braintree' => [
            'name' => 'Braintree',
            'route' => 'braintree',      
            // 'options' => [],
            
        ],
        'paystack' => [
            'name' => 'Paystack',
            'route' => 'paystack',                    
        ],
        'payu' => [
            'name' => 'PayU',
            'route' => 'payu',                    
        ],
        
        // 'two_checkout' => [
        //     'name' => '2Checkout',
        //     'route' => 'two_checkout',                  
        // ],

    ],
    
    'default_gateway' => 'paypal_checkout',
    'module_folder_root' => app_path('PaymentGateways'),
    'settings_view' => 'views'. DIRECTORY_SEPARATOR . 'setup',
    'generic_options'   => [
        'env_list' => [
             'sandbox' => 'Sandbox',
             'production' => 'Production'
         ]
     ]


];
