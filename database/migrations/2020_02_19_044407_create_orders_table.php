<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->increments('id');
            $table->string('number')->nullable();
            $table->string('title')->nullable();
            $table->text('instruction')->nullable();

            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('service_id');
            $table->foreign('service_id')
                ->references('id')
                ->on('services');

            $table->unsignedInteger('work_level_id');
            $table->foreign('work_level_id')
                ->references('id')
                ->on('work_levels');
            $table->float('work_level_percentage_to_add', 8, 2);

            $table->unsignedInteger('urgency_id');
            $table->foreign('urgency_id')
                ->references('id')
                ->on('urgencies');
            $table->float('urgency_percentage_to_add', 8, 2);
            $table->date('dead_line')->nullable();

            $table->decimal('base_price', 10, 2);
            $table->string('spacing_type');

            $table->date('start_date')->nullable();

            $table->date('completed_date')->nullable();

            $table->unsignedInteger('number_of_pages');
            $table->string('number_of_sources')->nullable();

            $table->unsignedInteger('staff_id')->nullable();
            $table->foreign('staff_id')
                ->references('id')
                ->on('users');

            $table->unsignedInteger('order_status_id')->unsigned();
            $table->foreign('order_status_id')
                ->references('id')
                ->on('order_statuses');

            $table->boolean('update_via_sms')->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('discount', 10, 2)
                ->default(0)
                ->nullable();
            
            $table->decimal('credit_applied', 10, 2)
            ->default(0)
            ->nullable();

            $table->decimal('total', 10, 2);
            $table->decimal('staff_payment_amount', 10, 2)->nullable();

            $table->string('payment_method');
            $table->string('transaction_id');

            $table->timestamps();
            $table->softDeletes();
            $table->boolean('billed')->nullable();

            $table->index('order_status_id');
            $table->index('customer_id');
            $table->index('staff_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}


