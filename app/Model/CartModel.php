<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'Product_ID',
        'Cart_Quantity',
        'Customer_ID',
        'Coupon_ID'
    ];
    protected $primaryKey = 'Cart_ID';
    protected $table = 'tbl_cart';
    public function product()
    {
        return $this->belongsTo('App\Model\Product', 'Product_ID');
    }
    public function coupon()
    {
        return $this->belongsTo('App\Model\CouponModel', 'Coupon_ID');
    }
}