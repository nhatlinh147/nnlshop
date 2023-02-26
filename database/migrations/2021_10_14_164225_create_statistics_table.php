<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_statistics', function (Blueprint $table) {
            $table->bigIncrements('Statistics_ID');
            $table->string('Statistics_Order_Date', 100);
            $table->string('Statistics_Sales');
            $table->string('Statistics_Expenses');
            $table->string('Statistics_CoH');
            $table->integer('Statistics_Quantity');
            $table->integer('Statistics_Total_Order');
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
        Schema::dropIfExists('tbl_statistics');
    }
}