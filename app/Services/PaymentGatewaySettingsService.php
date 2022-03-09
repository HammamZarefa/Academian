<?php

namespace App\Services;

use App\PaymentGateway;

class PaymentGatewaySettingsService
{
    public function save(string $unique_name, string $name, array $keys, bool $inactive = NULL)
    {
        return PaymentGateway::updateOrCreate(['unique_name' => $unique_name], [
            'unique_name' => $unique_name,
            'name' => $name,
            'keys' => $keys,
            'inactive' => $inactive,
        ]);
    }


    public function recordsForSettingsPage($gatewaySlug, $config)
    {
        // $current_gateway value example: paypal_checkout
        $current_gateway = $this->getCurrentGateway($gatewaySlug, $config);

        // Get the settings of the gateway from database
        $records = PaymentGateway::where('unique_name', $current_gateway)->get();

        if ($records->count() > 0) {
            $data['settings'] = $records->first();
        } else {
            // Need the following to avoid error in blade view, if the gateway table is empty or no record found
            $settings = new \stdClass();
            $settings->keys = new \stdClass();
            $data['settings'] = $settings;
        }
        $data['gateways'] = $config['gateways'];

        if (($records->count() > 0)) {
            $data['settings'] = $records->first();
        } else {
            $settings = new \stdClass();
            $settings->keys = new \stdClass();
            $data['settings'] = $settings;
        }
      
        // $gatewayConfig = $config['gateways'][$current_gateway];
        $data['options'] = $config['generic_options'];
        $data['view_name'] = $current_gateway . DIRECTORY_SEPARATOR . $config['settings_view'];
        $data['current_gateway'] = $current_gateway;

        return $data;
    }

    public function isValidGateway($slug, $getways)
    {
        if (!empty($slug) && !array_key_exists($this->convertSlugToUniqueKey($slug), $getways)) {
            return true;
        }
        return false;
    }

    /*
        Converts the slug to gateway unique key (e.g: paypal-checkout to paypal_checkout)
    */
    private function convertSlugToUniqueKey($slug)
    {
        return strtolower(str_replace('-', '_', $slug));
    }

    private function getCurrentGateway($gatewaySlug, $config)
    {
        if (empty($gatewaySlug)) {
            return $config['default_gateway'];
        } else {
            return $this->convertSlugToUniqueKey($gatewaySlug);
        }
    }
}
