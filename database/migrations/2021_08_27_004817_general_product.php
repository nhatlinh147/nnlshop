<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GeneralProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_product', function (Blueprint $table) {
            $table->Increments('Product_ID');
            $table->string('Meta_Keywords_Product');
            $table->string('Product_Name');
            $table->string('Product_Slug');
            $table->integer('Category_ID');
            $table->integer('Brand_ID');
            $table->text('Product_Desc');
            $table->text('Product_Content');
            $table->string('Product_View', 50);
            $table->string('Product_Price', 50);
            $table->string('Product_Cost', 50);
            $table->string('Product_Image');
            $table->integer('Product_Status');
            $table->string('Product_Tag');
            $table->string('Product_Document');
            $table->string('Product_Path');
            $table->integer('Product_Quantity');
            $table->string('Product_Sold', 50);
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
        Schema::dropIfExists('tbl_product');
    }
}