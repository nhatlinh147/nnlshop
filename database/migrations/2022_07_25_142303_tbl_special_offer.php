<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblSpecialOffer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_special_offer', function (Blueprint $table) {
            $table->Increments('Special_ID');
            $table->string('Special_Title');
            $table->string('Special_Slug');
            $table->string('Special_Image');
            $table->json('Special_Product_Json');
            $table->string('Special_Start');
            $table->string('Special_End');
            $table->integer('Special_Status');
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
        Schema::dropIfExists('tbl_special_offer');
    }
}