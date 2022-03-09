<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentRecordService;

class DropPaymentInfoFromOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('orders', 'payment_method')) {

            $this->transferPaymentInfoToPaymentsTable();

            Schema::table('orders', function (Blueprint $table) {

                $table->dropColumn('payment_method');
                $table->dropColumn('transaction_id');
                $table->dropColumn('credit_applied');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }

    private function transferPaymentInfoToPaymentsTable()
    {
        DB::beginTransaction();

        try {

            $paymentRecordService = new PaymentRecordService();

            DB::table('orders')->orderBy('id')->chunk(20, function ($orders) use ($paymentRecordService) {
                foreach ($orders as $order) {

                    $paymentRecordService->store($order->customer_id, $order->payment_method, $order->total, $order->transaction_id);

                    $user = \App\User::find($order->customer_id);
                    $order = \App\Order::find($order->id);
                    $user->wallet()->pay($order->total, $order);
                        
                }
            });

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();            
        }
    }
}
