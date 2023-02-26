<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableFeeShipping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_fee_shipping', function (Blueprint $table) {
            $table->Increments('Fee_Shipping_ID');
            $table->integer('Fee_Province_ID');
            $table->integer('Fee_District_ID');
            $table->integer('Fee_Ward_ID');
            $table->integer('Fee_Delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_fee_shipping');
    }
}