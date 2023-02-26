<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_post', function (Blueprint $table) {
            $table->bigIncrements('Post_ID');
            $table->string('Post_Title');
            $table->string('Post_Slug');
            $table->integer('Post_Views')->default(0);
            $table->longText('Post_Desc');
            $table->mediumText('Post_Content');
            $table->string('Meta_Keywords_Post');
            $table->mediumText('Meta_Desc_Post');
            $table->integer('Post_Status');
            $table->string('Post_Image');
            $table->integer('Cate_Post_ID');
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
        Schema::dropIfExists('tbl_post');
    }
}