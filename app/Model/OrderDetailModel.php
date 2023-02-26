<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetailModel extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'Order_Code', 'Product_ID',
        'Product_Name', 'Product_Price',
        'Product_Sales_Quantity'
    ];
    protected $primaryKey = 'Order_Detail_ID';
    protected $table = 'tbl_order_detail';
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'Product_ID');
    }

    public function coupon()
    {
        return $this->hasOne('App\Model\CouponModel', 'Coupon_Code', 'Product_Coupon_Code');
    }
}