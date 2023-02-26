<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblSpecialProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_special_product', function (Blueprint $table) {
            $table->bigIncrements('Special_Product_ID');
            $table->string('Product_Name');
            $table->integer('Product_ID');
            $table->integer('Special_ID');
            $table->string('Special_Product_Price');
            $table->integer('Special_Product_Form');
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
        Schema::dropIfExists('tbl_special_product');
    }
}