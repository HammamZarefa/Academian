<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->nullable();
            $table->unsignedInteger('wallet_id');
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets');

            $table->string('description');
            $table->string('transactionable_type');
            $table->integer('transactionable_id');           
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['transactionable_type', 'transactionable_id'], 'transactionable');
            $table->index(['wallet_id', 'transactionable_type', 'transactionable_id'], 'wallet_transactionable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
