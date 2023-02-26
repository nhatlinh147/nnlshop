<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_category_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Meta_Keywords_Category');
            $table->string('Category_Name');
            $table->string('Category_Product_Slug');
            $table->string('Category_Image');
            $table->integer('Category_Parent');
            $table->text('Category_Desc');
            $table->integer('Category_Status');
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
        Schema::dropIfExists('tbl_category_product');
    }
}