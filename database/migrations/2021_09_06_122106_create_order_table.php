<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_order', function (Blueprint $table) {
            $table->bigIncrements('Order_ID');
            $table->integer('Customer_ID');
            $table->integer('Shipping_ID');
            $table->integer('Payment_ID');
            $table->integer('Order_Status');
            $table->date('Order_Date');
            $table->char('Order_Checkout_Code');
            $table->char('Order_Coupon_Code');
            $table->double('Order_Fee_Delivery');
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
        Schema::dropIfExists('tbl_order');
    }
}