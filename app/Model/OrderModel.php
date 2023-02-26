<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'Customer_ID', 'Shipping_ID ', 'Payment_ID',
        'Order_Status', 'Order_Date',
        'Order_Checkout_Code', 'Order_Coupon_Code',
        'Order_Fee_Delivery'
    ];
    protected $primaryKey = 'Order_ID';
    protected $table = 'tbl_order';
    public function order_detail()
    {
        return $this->hasMany('App\Model\OrderDetailModel', 'Order_Code', 'Order_Checkout_Code');
    }
}