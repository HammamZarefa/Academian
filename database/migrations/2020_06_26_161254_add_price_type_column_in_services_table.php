<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceTypeColumnInServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {

            $table->unsignedInteger('price_type_id')->after('name')->default(3);
            $table->foreign('price_type_id')
                ->references('id')
                ->on('price_types');
            $table->decimal('price', 10, 2)->nullable()->after('price_type_id');            
            $table->unsignedInteger('minimum_order_quantity')->default(1)->nullable();
            $table->decimal('single_spacing_price', 10, 2)->nullable()->change();
            $table->decimal('double_spacing_price', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {      
            $table->dropForeign(['price_type_id']);         
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('price_type_id');
            $table->dropColumn('price');
            $table->dropColumn('minimum_order_quantity');
            $table->decimal('single_spacing_price', 10, 2)->change();
            $table->decimal('double_spacing_price', 10, 2)->change();
        });
    }
}
