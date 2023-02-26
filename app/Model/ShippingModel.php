<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShippingModel extends Model
{
    public $timestamp = false;
    protected $fillable = [
        'Shipping_Fullname', 'Shipping_Email',
        'Shipping_Address', 'Shipping_Phone',
        'Shipping_Note', 'Shipping_Payment_Select'
    ];
    protected $primaryKey = 'Shipping_ID';
    protected $table = 'tbl_shipping';
}