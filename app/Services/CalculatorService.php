<?php

namespace App\Services;

use App\Service;
use App\WorkLevel;
use App\Urgency;
use App\AdditionalService;
use App\Setting;
use App\Enums\PriceType;
use App\Enums\SpacingType;

class CalculatorService
{
    /*
        The calculatePrice method requires the following keys to contain in 
        the request array parameter:
            $request['service_id']
            $request['work_level_id']
            $request['urgency_id']
            $request['spacing_type']
            $request['quantity']
            $request['added_services']
    */

    function calculatePrice($request)
    {
        $service = Service::find($request['service_id']);
        $workLevel = WorkLevel::find($request['work_level_id']);
        $urgency = Urgency::find($request['urgency_id']);

        // When Price Type is fixed
        if ($service->price_type_id == PriceType::Fixed) {
            $base_price = $service->price;
            $unit_name = PriceType::FixedPriceUnit;
        }
        // When Price Type is Per Word
        if ($service->price_type_id == PriceType::PerWord) {
            $base_price = $service->price;
            $unit_name = PriceType::PerWordPriceUnit;
        }
        // When Price Type is based on Number of Pages
        if ($service->price_type_id == PriceType::PerPage) {
            if ($request['spacing_type'] == SpacingType::DoubleLine) {
                // If spacing type is double
                $base_price = $service->double_spacing_price;
            } else {
                // If spacing type is single
                $base_price = $service->single_spacing_price;
            }
            $unit_name = PriceType::PerPagePriceUnit;
        }
        if ($service->price_type_id == PriceType::Later) {
            $base_price = $service->price;
            $unit_name = PriceType::CalcLater;
        }
        else {
            $request['spacing_type'] = null;
        }

        // Calculate Work Level Price
        $work_level_price = $this->calculatePercentage($base_price, $workLevel->percentage_to_add);

        // Calculate Urgency Price 
        $urgency_price = $this->calculatePercentage($base_price, $urgency->percentage_to_add);

        // Calculate Unit Price
        $unit_price = ($base_price + $work_level_price + $urgency_price);

        // Amount before including Additional Services
        $amount = $this->roundPrice(($unit_price * $request['quantity']));

        // Calculate Total Price of Additional Services
        $additional_services_cost = $this->getTotalPriceoOfAdditionalServices($request['added_services']);

        // Calculate Sub Total  Amount + Additional Services      
        $sub_total = $this->roundPrice(($amount + $additional_services_cost));

        // Total (work here if you need to add discount option)
        $total = $sub_total;

        return [
            'spacing_type' => $request['spacing_type'],
            'unit_name' => $unit_name,
            'base_price' => $base_price,
            'work_level_price' => $work_level_price,
            'urgency_price' => $urgency_price,
            'unit_price' => $unit_price,
            'amount' => $amount,
            'additional_services_cost' => $additional_services_cost,
            'sub_total' => $sub_total,
            'discount' => 0,
            'total' => $total,

        ];
    }

    function orderTotal($request)
    {
        return $this->calculatePrice($request)['total'];
    }

    private function calculatePercentage($basePrice, $percentageToAdd)
    {
        return $this->roundPrice((($basePrice * $percentageToAdd) / 100));
    }

    private function getTotalPriceoOfAdditionalServices($added_services)
    {
        if (isset($added_services) && is_array($added_services) && count($added_services) > 0) {
            foreach ($added_services as $row) {
                $service_ids[] = $row['id'];
            }

            return AdditionalService::whereIn('id', $service_ids)->sum('rate');
        }

        return 0;
    }

    public function priceList()
    {
        $record['work_levels'] = [];
        $record['pricings'] = [];
        $record['services'] = [];

        $services = Service::whereNull('inactive')->get();
        $workLevels = WorkLevel::whereNull('inactive')->orderBy('percentage_to_add', 'ASC')->get();
        $urgencies = Urgency::whereNull('inactive')->orderBy('percentage_to_add', 'ASC')->get();

        if ($services->count() > 0 && $workLevels->count() > 0 && $urgencies->count() > 0) {
            foreach ($services as $service) {
                $record['pricings'][$service->id] = $this->getPriceByService($service, $workLevels, $urgencies);
            }

            $record['work_levels'] = $workLevels->toArray();
            $record['services'] = $services->toArray();
        }

        return $record;
    }

    private function getPriceByService($service, $workLevels, $urgencies)
    {
        foreach ($urgencies as $urgency) {
            $data[] = [
                'name' => $urgency->value . ' ' . $urgency->type,
                'record' => $this->calculateServicePrice($workLevels, $urgency, $service)
            ];
        }

        return $data;
    }

    private function calculateServicePrice($workLevels, $urgency, $service)
    {
        foreach ($workLevels as $workLevel) {

            $price = $this->calculatePrice([
                'service_id' => $service->id,
                'work_level_id' => $workLevel->id,
                'urgency_id' => $urgency->id,
                'spacing_type' => $workLevel->id,
                'quantity' => $service->minimum_order_quantity,
                'added_services' => [],
            ]);
            $data[] = $price['total'];
        }

        return $data;
    }

    public function staffPaymentAmount($order_total)
    {
        if (Setting::get_setting('enable_browsing_work') == 'yes') {
            // Calculate Staff payment
            $payment_value = Setting::get_setting('staff_payment_amount');

            if (Setting::get_setting('staff_payment_type') == 'percentage') {
                return $this->roundPrice((($order_total * $payment_value) / 100));
            } else {
                return $payment_value;
            }
        }
        return NULL;
    }


    public function roundPrice($amount)
    {
        return number_format($amount, 2, '.', '');
    }
}
