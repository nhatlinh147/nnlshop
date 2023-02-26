<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    public $timestamps = false;
    protected $fillable = ['Meta_Keywords_Category', 'Category_Name', 'Category_Product_Slug', 'Category_Image', 'Category_Parent', 'Category_Desc', 'Category_Status'];
    protected $table = 'tbl_category_product';
    protected $primaryKey = 'id';

    public function product()
    {
        return $this->hasMany('App\Model\Product', 'Category_ID');
    }
}