<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class StatisticsModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Statistics_Order_Date', 'Statistics_Sales', 'Statistics_Expenses', 'Statistics_CoH', 'Statistics_Quantity', 'Statistics_Total_Order'];
    protected $table = 'tbl_statistics';
    protected $primaryKey = 'Statistics_ID';
}