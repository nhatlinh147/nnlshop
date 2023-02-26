<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_slide', function (Blueprint $table) {
            $table->bigIncrements('Carousel_ID');
            $table->string('Slide_Title');
            $table->integer('Slide_Status');
            $table->string('Slide_Image', 100);
            $table->text('Slide_Desc', 50);
            $table->string('Slide_More', 50);
            $table->string('Meta_Keywords_Slide');
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
        Schema::dropIfExists('tbl_slide');
    }
}