<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblPropProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_prop_product', function (Blueprint $table) {
            $table->bigIncrements('Prop_ID');
            $table->string('Prop_Product_ID');
            $table->string('Prop_Size');
            $table->string('Prop_Color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_prop_product');
    }
}