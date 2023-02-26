<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpecialProductModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Product_Name', 'Product_ID', 'Special_ID', 'Special_Product_Price', 'Special_Product_Form'];
    protected $table = 'tbl_special_product';
    protected $primaryKey = 'Special_Product_ID';
}