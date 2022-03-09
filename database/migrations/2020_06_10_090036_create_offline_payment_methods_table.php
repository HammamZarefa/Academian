<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflinePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug'); 
            $table->string('name');   
            $table->string('description')->nullable();     
            $table->text('instruction')->nullable();  
            $table->text('settings')->nullable();   
            $table->string('success_message');                     
            $table->boolean('inactive')->nullable();           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offline_payment_methods');
    }
}
