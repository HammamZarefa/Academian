<?php

use Illuminate\Database\Seeder;
use App\Services\PaymentRecordService;

class WalletBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 is admin, 3 is customer
        foreach([1,3] as $customer_id)
        {
            $this->generate($customer_id);
        }       

    }

    public function generate($customer_id, $amount = 3000)
    {
        $faker = \Faker\Factory::create();
        $payment = new PaymentRecordService();
        $gateway = $faker->randomElement(['Paypal Smart Checkout', 'Stripe', 'Bank Transfer']);       
        $payment->store($customer_id, $gateway, $amount, $faker->isbn13());
    }
}
