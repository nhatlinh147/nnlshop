<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_table', function (Blueprint $table) {
            $table->increments('Admin_ID');
            $table->string('Admin_Email');
            $table->string('Admin_Name');
            $table->string('Admin_Password');
            $table->string('Admin_Phone');
            $table->string('Admin_Gender');
            $table->string('remember_token');
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
        Schema::dropIfExists('tbl_table');
    }
}