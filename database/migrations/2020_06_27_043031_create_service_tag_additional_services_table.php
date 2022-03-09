<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTagAdditionalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_tag_additional_services', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');

            $table->unsignedInteger('additional_service_id');
            $table->foreign('additional_service_id')->references('id')->on('additional_services');

            $table->index('service_id');
            $table->index('additional_service_id');
            $table->index(['service_id', 'additional_service_id'],'service_additional_service');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_tag_additional_services');
    }
}
