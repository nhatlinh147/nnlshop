<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropProductModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Prop_Product_ID', 'Prop_Size', 'Prop_Color'];
    protected $table = 'tbl_prop_product';
    protected $primaryKey = 'Prop_ID';
}