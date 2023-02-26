<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    public $timestamp = false;
    protected $fillable = ['Gallery_Name', 'Gallery_Image', 'Product_ID'];
    protected $table = 'tbl_gallery';
    protected $primaryKey = 'Gallery_ID';
    public function Product_Relation()
    {
        return $this->belongsTo('App\Models\Product', 'Fee_District_Code');
    }
    public function Product()
    {
        return $this->belongsTo('App\Model\Product', 'Product_ID');
    }
}