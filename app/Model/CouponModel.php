<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponModel extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'Coupon_Name', 'Coupon_Number',
        'Coupon_Code', 'Coupon_Amount',
        'Coupon_Condition', 'Coupon_Date_Start',
        'Coupon_Date_End', 'Coupon_Status'
    ];
    protected $table = 'tbl_coupon';
    protected $primaryKey = 'Coupon_ID';
}