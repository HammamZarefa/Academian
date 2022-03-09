<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->string('staff_invoice_number');          
            $table->unsignedInteger('user_id');        
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('total', 10, 2); 
            $table->string('name');
            $table->string('address')->nullable();
            $table->text('note')->nullable();
            $table->date('paid')->nullable();                     
            $table->timestamps();
            $table->softDeletes();     
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('bills');
    }
}
