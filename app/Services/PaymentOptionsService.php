<?php

namespace App\Services;

use App\OfflinePaymentMethod;
use App\PaymentGateway;

class PaymentOptionsService
{

    public function all()
    {
        return [
            'online' => $this->online(),
            'offline' => $this->offline()
        ];
    }

    public function online()
    {
        $gateways  = config('paymentgateways')['gateways'];

        if (is_array($gateways) && count($gateways) > 0) {
            $paymentOptions = PaymentGateway::whereNull('inactive')->get();

            if ($paymentOptions->count() > 0) {

                foreach ($paymentOptions as $paymentOption) {

                    if (array_key_exists($paymentOption->unique_name, $gateways)) {

                        $gateway = $gateways[$paymentOption->unique_name];

                        $paymentOption->url = route($gateway['route']);

                        $data[] = $paymentOption;
                    }
                }

                return (object) $data;
            }
        }

        return NULL;
    }

    public function offline()
    {
        $paymentOptions = OfflinePaymentMethod::whereNull('inactive')->get();

        return ($paymentOptions->count() > 0) ? $paymentOptions : null;
    }
}
