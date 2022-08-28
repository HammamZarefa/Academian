<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('amount');
            $table->unsignedInteger('quantity')->nullable();
            $table->enum('type'  , ['fixed' , 'percent']);
            $table->enum('status'  , ['enable' , 'disable'])->default('disable');
            $table->text('description')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('expired_at');
            $table->timestamps();
        });

        Schema::create('coupon_user', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id');
            $table->unsignedInteger('user_id');

            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
