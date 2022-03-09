<?php

use App\User;
use App\Order;
use App\Service;
use App\Urgency;
use App\WorkLevel;
use Carbon\Carbon;
use App\Enums\PriceType;
use App\AdditionalService;
use App\Enums\PaymentReason;
use App\OfflinePaymentMethod;
use App\Services\OrderService;
use Illuminate\Database\Seeder;
use App\PendingForApprovalPayment;
use App\Services\CalculatorService;

class PendingForApprovalPaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public $faker;

    function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    public function run()
    {
        // Specifically for User with ID:3
        for ($i=1; $i < 6; $i++) { 
            $date = Carbon::now()->subDays($i)->toDateString();
            $this->generate(3, $date);
        }
        // Randomly picking 10 users from customer's list
        $users = User::doesntHave('roles')->pluck('id');  
        for ($i=0; $i < 40; $i++) {   
            $customer_id = $this->faker->randomElement($users->toArray());         
            $this->generate($customer_id);
        }
    }

    private function generate($customer_id, $date = null)
    {
        $faker = $this->faker;

        $offlineMethods = OfflinePaymentMethod::pluck('id');
        $method_id = $faker->randomElement($offlineMethods->toArray());
        $paymentMethod = OfflinePaymentMethod::find($method_id);

        $payment_reason = $faker->randomElement([PaymentReason::order, PaymentReason::wallettopup]);

        // it was an order
        if ($payment_reason == PaymentReason::order) {
            $order = $this->prepareDataToOrder($customer_id);
            $amount = $order->total;
            $cart = [
                'order_id' => $order->id,
                'cart_total' => $order->total
            ];

        } else {
            $cart = null;
            $amount = $this->faker->randomFloat(2, 20, 100);
        }

        $payment = PendingForApprovalPayment::create([
            'user_id' => $customer_id,
            'method' => $paymentMethod->name,
            'amount' => $amount,
            'reference' => $faker->ean13(),
            'attachment' => null,
            'payment_reason' => $payment_reason,
            'cart' => $cart
        ]);

        if($date)
        {
            $payment->created_at = $date;
            $payment->save();
        }
    }

    private function prepareDataToOrder($customer_id)
    {
        $faker = $this->faker;

        $services = Service::pluck('id');
        $urgencies = Urgency::pluck('id');
        $workLevels = WorkLevel::pluck('id');
        $users = User::doesntHave('roles')->pluck('id');     
        

        $calculator = new CalculatorService();
        if ($customer_id) {
            $data['customer_id'] = $customer_id;
        } else {
            $data['customer_id'] = $faker->randomElement($users->toArray());
        }

        $data['title'] = $faker->text(30);
        $data['instruction'] = $faker->paragraph(5);

        $data['service_id'] = $faker->randomElement($services->toArray());
        $service = Service::find($data['service_id']);
        $additionalServices= $service->additionalServices()->pluck('additional_service_id');

        $data['urgency_id'] = $faker->randomElement($urgencies->toArray());
        $urgency = Urgency::find($data['urgency_id']);
        $data['work_level_id'] = $faker->randomElement($workLevels->toArray());

        if(count($additionalServices->toArray()) > 0)
        {
            $adService = AdditionalService::find($faker->randomElement($additionalServices->toArray()));
            $data['added_services'] = [$adService->toArray()];
        }
        else
        {
            $data['added_services'] = [];
        }
        

        if ($service->price_type_id == PriceType::Fixed) {
            $data['quantity'] = 1;
        } else {
            $data['quantity'] = $service->minimum_order_quantity * $faker->randomElement([1, 2]);
        }

        if ($service->price_type_id == PriceType::PerPage) {
            $data['spacing_type'] = $faker->randomElement([
                'double',
                'single'
            ]);
        }
        $data['dead_line'] = $this->get_urgency_date($urgency->type, $urgency->value);

        $data = array_merge($data, $calculator->calculatePrice($data));
        $data['cart_total'] = $calculator->orderTotal($data);
        $data['staff_payment_amount'] = $calculator->staffPaymentAmount($data['cart_total']);
        $data['order_status_id'] = ORDER_STATUS_PENDING_PAYMENT;


        Order::reguard();

        $orderService = new OrderService();
        $order = $orderService->create($data);       

        return $order;
    }

    private function get_urgency_date($type, $value, $order_date = NULL)
    {
        if ($order_date && !empty($order_date)) {
            $now = Carbon::parse($order_date);
        } else {
            $now = Carbon::now();
        }


        $now = ($type == 'hours') ? $now->addHours($value) : $now->addDays($value);

        return $now->format('Y-m-d H:i:s');
    }

    // private function prepareDataToOrder($customer_id)
    // {
    //     $faker = $this->faker;

    //     $services = Service::pluck('id');
    //     $urgencies = Urgency::pluck('id');
    //     $workLevels = WorkLevel::pluck('id');
        


    //     $calculator = new CalculatorService();
    //     $data['customer_id'] = $customer_id;
    //     $data['title'] = $faker->text(30);
    //     $data['instruction'] = $faker->paragraph(5);

    //     $data['service_id'] = $faker->randomElement($services->toArray());
    //     $service = Service::find($data['service_id']);
    //     $additionalServices = $service->additionalServices()->pluck('additional_service_id');

    //     $data['urgency_id'] = $faker->randomElement($urgencies->toArray());
    //     $urgency = Urgency::find($data['urgency_id']);
    //     $data['work_level_id'] = $faker->randomElement($workLevels->toArray());

    //     if (count($additionalServices->toArray()) > 0) {
    //         $adService = AdditionalService::find($faker->randomElement($additionalServices->toArray()));
    //         $data['added_services'] = [$adService->toArray()];
    //     } else {
    //         $data['added_services'] = [];
    //     }


    //     if ($service->price_type_id == PriceType::Fixed) {
    //         $data['quantity'] = 1;
    //     } else {
    //         $data['quantity'] = $service->minimum_order_quantity * $faker->randomElement([1, 2]);
    //     }

    //     if ($service->price_type_id == PriceType::PerPage) {
    //         $data['spacing_type'] = $faker->randomElement([
    //             'double',
    //             'single'
    //         ]);
    //     }
    //     $data['dead_line'] = $this->getUrgencyDate($urgency->type, $urgency->value);

    //     $data = array_merge($data, $calculator->calculatePrice($data));
    //     $data['cart_total'] = $calculator->orderTotal($data);
    //     $data['staff_payment_amount'] = $calculator->staffPaymentAmount($data['cart_total']);
    //     $data['attachments'] = [];
    //     return $data;
    // }

   
}
