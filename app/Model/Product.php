<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'tbl_product';
    protected $fillable = [
        'Meta_Keywords_Product', 'Product_Name', 'Product_View',
        'Product_Slug', 'Category_ID', 'Product_Desc',
        'Product_Content', 'Product_Price', 'Product_Cost',
        'Product_Image', 'Product_Status', 'Product_Tag',
        'Product_Document', 'Product_Path', 'Product_Quantity',
        'Product_Fee_Delivery', 'Product_Summary'
    ];
    protected $primaryKey = 'Product_ID';

    public function getProductPriceAttribute($value)
    {
        return is_int($value) ? $this->attributes['Product_Price'] = number_format($value, 0, ',', '.') . ' đ' : $this->attributes['Product_Price'];
    }

    public function getProductCostAttribute($value)
    {
        return is_int($value) ? $this->attributes['Product_Cost'] = number_format($value, 0, ',', '.') . ' đ' : $this->attributes['Product_Cost'];
    }

    // public function brand()
    // {
    //     return $this->belongsTo('App\Model\BrandModel', 'Brand_ID');
    // }

    public function category()
    {
        return $this->belongsTo('App\Model\CategoryModel', 'Category_ID');
    }
    public function gallery()
    {
        return $this->hasMany('App\Model\GalleryModel', 'Product_ID');
    }
    // public function cart()
    // {
    //     return $this->hasMany('App\Model\CartModel', 'Product_ID');
    // }
}