<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_comment', function (Blueprint $table) {
            $table->bigIncrements('Comment_ID');
            $table->string('Comment_Content');
            $table->string('Comment_Name');
            $table->timestamp('Comment_Date')->useCurrent();
            $table->integer('Comment_Product_ID');
            $table->integer('Comment_Parent_ID');
            $table->integer('Comment_Status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_comment');
    }
}