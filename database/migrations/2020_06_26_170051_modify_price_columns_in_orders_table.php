<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Enums\PriceType;
use \App\Order;
class ModifyPriceColumnsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('orders', function (Blueprint $table) {     

            $table->renameColumn('number_of_pages', 'quantity');
            $table->string('unit_name')->after('dead_line');
            $table->decimal('work_level_price', 10, 2)->after('base_price');
            $table->decimal('urgency_price', 10, 2)->after('work_level_price');
            $table->decimal('unit_price', 10, 2)->after('urgency_price');
            $table->decimal('amount', 10, 2)->after('unit_price');
            
            $table->renameColumn('work_level_percentage_to_add', 'work_level_percentage');
            $table->renameColumn('urgency_percentage_to_add', 'urgency_percentage');

            $table->string('spacing_type', 20)->nullable()->change();
            $table->dropColumn('number_of_sources');
            $table->dropColumn('start_date');
            $table->dropColumn('completed_date');
        });


        DB::statement("ALTER TABLE orders MODIFY COLUMN quantity int(10) AFTER unit_price");

        DB::statement("ALTER TABLE orders MODIFY COLUMN sub_total decimal(10,2)  AFTER amount");
        DB::statement("ALTER TABLE orders MODIFY COLUMN discount decimal(10,2)  AFTER sub_total");
        DB::statement("ALTER TABLE orders MODIFY COLUMN total decimal(10,2)  AFTER discount");
        DB::statement("ALTER TABLE orders MODIFY COLUMN staff_payment_amount decimal(10,2)  AFTER total");


        DB::statement("ALTER TABLE orders MODIFY COLUMN work_level_percentage double AFTER spacing_type");
        DB::statement("ALTER TABLE orders MODIFY COLUMN urgency_percentage double AFTER work_level_percentage");

        $this->updatePriceInformation();

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('quantity', 'number_of_pages');
            $table->dropColumn('unit_name');
            $table->dropColumn('work_level_price');
            $table->dropColumn('urgency_price');
            $table->dropColumn('unit_price');
            $table->dropColumn('amount');
            $table->renameColumn('work_level_percentage', 'work_level_percentage_to_add');
            $table->renameColumn('urgency_percentage', 'urgency_percentage_to_add');                     
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('number_of_sources')->nullable()->after('number_of_pages');
            $table->date('start_date')->nullable()->after('spacing_type');
            $table->date('completed_date')->nullable()->after('start_date');
        });
    }

    private function updatePriceInformation()
    {
        DB::beginTransaction();
        try {

            DB::table('orders')->orderBy('id')->chunk(10, function ($orders) {
                $data = [];
                foreach ($orders as $order) {
                    $order = \App\Order::find($order->id);
                    $order->work_level_price = $this->findPercentage($order->base_price, $order->work_level_percentage);
                    $order->urgency_price = $this->findPercentage($order->base_price, $order->urgency_percentage);
                    $order->unit_price = $order->base_price + $order->work_level_price + $order->urgency_price;
                    $order->amount = round($order->unit_price * $order->quantity, 2);
                    $order->unit_name = PriceType::PerPagePriceUnit;
                    $order->save();
                }
            });

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    private function findPercentage($basePrice, $percentageToAdd)
    {
        return round(($basePrice * $percentageToAdd) / 100, 2);
    }
}
