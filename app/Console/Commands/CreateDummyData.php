<?php

namespace App\Console\Commands;

use App\PaymentGateway;
use Illuminate\Console\Command;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class CreateDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prowriters:dummy-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->email();

        // \Artisan::call("route:clear");
        \Artisan::call("cache:clear");
        \Artisan::call("config:clear");
        \Artisan::call("view:clear");
        \Artisan::call("migrate:reset");
        \Artisan::call("migrate");
        \Artisan::call("db:seed");

        // the driver will send fake emails
        config()->set('mail', array_merge(config('mail'), [
            'driver' => 'log',
        ]));
        
        \Artisan::call("db:seed --class=AdditionalServicesTableSeeder");
        \Artisan::call("db:seed --class=ServicesTableSeeder");
        \Artisan::call("db:seed --class=UrgenciesTableSeeder");
        \Artisan::call("db:seed --class=WorkLevelsTableSeeder");
        

        \Artisan::call("db:seed --class=DummyUserSeeder");
        \Artisan::call("db:seed --class=OrderTableSeeder");
        \Artisan::call("db:seed --class=BillsTableSeeder");

        $this->paymentGateways();       
        
        \Artisan::call("db:seed --class=OfflinePaymentMethodTableSeeder");
        \Artisan::call("db:seed --class=PendingForApprovalPaymentTableSeeder");
        \Artisan::call("db:seed --class=ApplicantsTableSeeder");
        \Artisan::call("db:seed --class=RecruitmentSettingsSeeder");
        \Artisan::call("db:seed --class=WalletBalanceSeeder");
    }

    private function paymentGateways()
    {
        PaymentGateway::insert([
            // Paypal Checkout
            [
                'unique_name' => 'paypal_checkout',
                'name' => 'Paypal Smart Checkout',                
                'keys' => json_encode([
                    'client_id' => "ASurpZzLelJpjJCwFSCaStoV71rjInqmmEWkDnd2mWk8bxGVZiUgW_Y59tWRCFyx-no7AUW8ozjzGb6Cc",
                    'client_secret' => "EDta8P64QXuKQYoD8GwhlNaROaySGai0pYwoJXGzBjCBc-5BZ6Ud_pgBQmlWb6WQyFMQvhjJh6noxsqh",
                    'environment' => 'sandbox',
                ]),

            ],
            // Braintree
            [
                'unique_name' => 'braintree',
                'name' => 'Braintree',                
                'keys' => json_encode([                    
                    'merchant_id' => 'z5sjjhbgrbzfgnw6',
                    'public_key' => 'n6srpqmqn6mq5sdv',
                    'private_key' => '59f9e4bf4b149fd54fa553fb9c7f7c137',
                    'is_paypal_enabled' => true,
                    'environment' => 'sandbox',
                ]),

            ],
            // Stipe
            [
                'unique_name' => 'stripe',
                'name' => 'Stripe',           
                'keys' => json_encode([                    
                    'publishable_key' => 'pk_test_JBnqGXZs3sHVpaR4bBwPFXoTm',
                    'secret_key' => 'sk_test_9rRMThBsLosdJuBIbTIVuP4Q',
                ]),

            ],

        ]);
    }

    private function email()
    {
        DotenvEditor::setKeys([
            ['key' => 'MAIL_MAILER', 'value' => 'log'],
            ['key' => 'MAIL_HOST', 'value' => 'smtp.mailtrap.io'],
            ['key' => 'MAIL_PORT', 'value' => '465'],
            ['key' => 'MAIL_USERNAME', 'value' => 'ab2e68188d741d2'],
            ['key' => 'MAIL_PASSWORD', 'value' => '0b3bf07bd5204f'],
            ['key' => 'MAIL_ENCRYPTION', 'value' => 'tls'],
            ['key' => 'MAIL_FROM_ADDRESS', 'value' => 'prowriters@microelephant.io'],
            ['key' => 'MAILGUN_DOMAIN', 'value' => 'company_email_mailgun_domain'],
            ['key' => 'MAILGUN_SECRET', 'value' => 'company_email_mailgun_key'],
            ['key' => 'QUEUE_CONNECTION', 'value' => 'sync'],
        ]);
        DotenvEditor::save();
    }

    private function initial_env_setup()
    {
        // If database connection is alright, update the ENV file.
        DotenvEditor::setKeys([
            [
                'key' => 'APP_DEBUG',
                'value' => 'TRUE',

            ],
            [
                'key' => 'APP_ENV',
                'value' => 'development',

            ],

        ]);

        DotenvEditor::save();

        return true;
    }

    private function finalize_env_setup()
    {
        // If database connection is alright, update the ENV file.
        DotenvEditor::setKeys([
            [
                'key' => 'APP_ENV',
                'value' => 'production',

            ],
            [
                'key' => 'APP_DEBUG',
                'value' => 'FALSE',

            ],

        ]);

        DotenvEditor::save();

        return true;
    }
}
