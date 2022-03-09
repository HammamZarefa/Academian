<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAdditionalServicesTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('order_additional_services', function (Blueprint $table) {

            $table->increments('id');                 
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedInteger('service_id'); 
            $table->foreign('service_id')->references('id')->on('services');   
            $table->string('type');
            $table->string('name');                    
            $table->float('rate', 8, 2);   

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('order_additional_services');

    }

}


