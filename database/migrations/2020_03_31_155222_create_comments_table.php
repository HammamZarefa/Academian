<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->text('body');            
            $table->unsignedInteger('user_id');  
            $table->foreign('user_id')->references('id')->on('users');               
            $table->timestamp('actual_updated_at')->nullable();           
            $table->timestamps();
            $table->softDeletes();     
            
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
        Schema::dropIfExists('comments');
    }
}
