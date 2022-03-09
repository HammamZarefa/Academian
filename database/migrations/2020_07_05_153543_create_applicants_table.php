<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->nullable();
            $table->unsignedInteger('applicant_status_id');
            $table->foreign('applicant_status_id')
                ->references('id')
                ->on('applicant_statuses');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->text('about')->nullable();           
            $table->text('note')->nullable();
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('referral_source_id')->nullable();
            $table->string('attachment');
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
        Schema::dropIfExists('applicants');
    }
}
