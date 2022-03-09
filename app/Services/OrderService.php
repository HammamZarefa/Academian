<?php

namespace App\Services;

use App\Order;
use App\Urgency;
use App\Attachment;
use App\NumberGenerator;
use App\Events\NewOrderEvent;
use App\OrderAdditionalService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    function create(array $data)
    {

        $data['number'] = NumberGenerator::gen('App\Order');

        if (!isset($data['order_status_id']) && empty($data['order_status_id'])) {
            $data['order_status_id'] = ORDER_STATUS_PENDING_PAYMENT;
        }
        // Get the datetime based on the urgency
        $urgency            = Urgency::find($data['urgency_id']);
        if ($urgency->type == 'hours') {
            $data['dead_line']  = get_urgency_date($urgency->type, $urgency->value, 'Y-m-d H:i:s');
        } else {
            $data['dead_line'] = date("Y-m-d H:i:s", strtotime($data['dead_line']));
        }

        $order = Order::create($data);
        $this->record_added_services($order, $data);
        $this->record_attachments($order, $data);



        return $order;
    }



    private function isPaymentPending($order_status_id)
    {
        if (in_array($order_status_id, [
            ORDER_STATUS_PENDING_PAYMENT,
            ORDER_STATUS_PAYMENT_NEEDS_APPROVAL,
            ORDER_STATUS_PAYMENT_DISAPPROVED
        ])) {
            return true;
        }
    }
    public function confirmOrderPayment($order_id)
    {
        $order = Order::find($order_id);
        $urgency = $order->urgency;
        $order->dead_line =  get_urgency_date($urgency->type, $urgency->value, 'Y-m-d H:i:s');
        $order->order_status_id = ORDER_STATUS_NEW;
        $order->invoiced = now();
        $order->save();

        //Deduct balance from customer's wallet
        $order->customer->wallet()->pay($order->total, $order);

        //Dispatching Event
        event(new NewOrderEvent($order));
        return $order;
    }


    public function markAsPaymentWaitingForApproval($order_id)
    {
        Order::where('id', $order_id)->update([
            'invoiced' => now(),
            'order_status_id' => ORDER_STATUS_PAYMENT_NEEDS_APPROVAL
        ]);
    }

    public function markAsPaymentDisapproved($order_id)
    {
        Order::where('id', $order_id)->update([
            'invoiced' => null,
            'order_status_id' => ORDER_STATUS_PAYMENT_DISAPPROVED
        ]);
    }

    public function destroy(Order $order)
    {
        DB::beginTransaction();
        $success = false;
        try {            
            // $order->comments()->delete();
            // $order->followers()->delete();
            // $order->attachments()->delete();
            // $order->added_services()->delete();
            $order->delete();

            $success = true;
            DB::commit();
        } catch (\Exception  $e) {
            debug($e);
            $success = false;
            DB::rollback();
        }

        return $success;
    }

    private function record_added_services(Order $order, $data)
    {
        if (isset($data['added_services']) && is_array($data['added_services']) && count($data['added_services']) > 0) {
            foreach ($data['added_services'] as $row) {
                $service = new OrderAdditionalService();
                $service->service_id = $row['id'];
                $service->type = $row['type'];
                $service->name = $row['name'];
                $service->rate = $row['rate'];
                $order->added_services()->save($service);
            }
        }
    }

    private function record_attachments(Order $order, $data)
    {
        if (isset($data['files_data']) && is_array($data['files_data']) && count($data['files_data']) > 0) {
            foreach ($data['files_data'] as $row) {

                if (isset($row['upload']['data']['name'])) {
                    $attachment = new Attachment();
                    $attachment->name = $row['upload']['data']['name'];
                    $attachment->display_name = $row['upload']['data']['display_name'];
                    $attachment->user_id = $data['customer_id'];

                    $order->attachments()->save($attachment);
                }
            }
        }
    }
}
