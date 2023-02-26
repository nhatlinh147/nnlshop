<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BrandProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_brand_product', function (Blueprint $table) {
            $table->bigIncrements('Brand_ID');
            $table->string('Meta_Keywords_Brand');
            $table->string('Brand_Name');
            $table->string('Brand_Product_Slug');
            $table->integer('Brand_Parent');
            $table->text('Brand_Desc');
            $table->integer('Brand_Status');
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
        Schema::dropIfExists('tbl_brand_product');
    }
}