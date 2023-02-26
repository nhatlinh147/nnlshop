<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FeeShippingModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Fee_Province_ID', 'Fee_District_ID', 'Fee_Ward_ID', 'Fee_Shipping'];
    protected $primaryKey = 'Fee_Shipping_ID';
    protected $table = "tbl_fee_shipping";
    public function province()
    {
        return $this->belongsTo('App\Model\Province', 'Fee_Province_ID');
    }
    public function district()
    {
        return $this->belongsTo('App\Model\District', 'Fee_District_ID');
    }
    public function ward()
    {
        return $this->belongsTo('App\Model\Ward', 'Fee_Ward_ID');
    }
}