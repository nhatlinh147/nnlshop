<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cate_post', function (Blueprint $table) {
            $table->Increments('Cate_Post_ID');
            $table->string('Cate_Post_Name');
            $table->string('Cate_Post_Slug');
            $table->longText('Cate_Post_Desc');
            $table->integer('Cate_Post_Status');
            $table->string('Meta_Keywords_Cate_Post');
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
        Schema::dropIfExists('tbl_cate_post');
    }
}