<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Meta_Keywords_Brand', 'Brand_Name', 'Brand_Product_Slug', 'Brand_Parent', 'Brand_Desc', 'Brand_Status'];
    protected $table = 'tbl_brand_product';
    protected $primaryKey = 'Brand_ID';

    public function product()
    {
        return $this->hasMany('App\Model\Product', 'Brand_ID');
    }
}