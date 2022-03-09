<?php

use App\OfflinePaymentMethod;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OfflinePaymentMethodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $inst = 'Swift Code:  NORHUS33' . PHP_EOL .
        'Bank Name:  Centric Bank' . PHP_EOL .
        'Bank Address:  4320 Linglestown Road, Harrisburg, PA 17112' . PHP_EOL .
        'Bank Account #:  220148' . PHP_EOL .
        'Beneficiary Name: Prowriters' . PHP_EOL .
        'Beneficiary Address: New York, USA' . PHP_EOL .
        'Beneficiary Account #: 220148'; 

        $method = new OfflinePaymentMethod();  
        $method->name = "Wire Transfer";
        $method->description = "Pay via Wire Transfer";
        $method->instruction = $inst;
        $method->slug = Str::slug($method->name, '-');        
        $method->settings = [
            'requires_transaction_number' => true,
            'requires_uploading_attachment' => false,
            'reference_field_label' => 'Transaction Number',
            'attachment_field_label' => null,
        ];
        $method->success_message = 'Thank you for your payment. You will be notified when your payment is approved';
        $method->save();


        $method = new OfflinePaymentMethod();  
        $method->name = "Bank Deposit";
        $method->description = "Pay via Bank Deposit";
        $method->instruction = $inst;
        $method->slug = Str::slug($method->name, '-');        
        $method->settings = [
            'requires_transaction_number' => true,
            'requires_uploading_attachment' => true,
            'reference_field_label' => 'Transaction Number',
            'attachment_field_label' => 'Attach a scan copy of the deposit slip',
        ];
        $method->success_message = 'Thank you for your payment. You will be notified when your payment is approved';
        $method->save();

        
    }
}
