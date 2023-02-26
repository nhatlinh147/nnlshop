<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SpecialOfferModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Special_Title', 'Special_Slug', 'Special_Image', 'Special_Product_Json', 'Special_Start', 'Special_End', 'Special_Status'];
    protected $table = 'tbl_special_offer';
    protected $primaryKey = 'Special_ID';
}