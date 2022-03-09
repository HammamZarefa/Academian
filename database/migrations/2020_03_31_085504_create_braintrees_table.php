<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBraintreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('braintrees', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('environment');
        //     $table->string('merchant_id');
        //     $table->string('public_key');
        //     $table->string('private_key');
        //     $table->boolean('is_paypal_enabled');
            
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('braintrees');
    }
}
