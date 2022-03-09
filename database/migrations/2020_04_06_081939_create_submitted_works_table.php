<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_works', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');            
            $table->text('message')->nullable();
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedInteger('user_id');  
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('needs_revision')->nullable();
            $table->text('customer_message')->nullable();
            
            $table->timestamps();

            $table->index('order_id');         
            $table->index('user_id');            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitted_works');
    }
}
