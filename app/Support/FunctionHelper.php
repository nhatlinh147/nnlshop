<?php

namespace App\Support;

use App\Model\Product;
use App\Model\CategoryModel;

class FunctionHelper
{
    public static function getValueKeyQuery($product_id, $key_product)
    {
        if ($key_product == 'Product_Price') {
            return Product::where('Product_ID', $product_id)->first()->getOriginal('Product_Price');
        } else if ($key_product == 'Product_Cost') {
            return Product::where('Product_ID', $product_id)->first()->getOriginal('Product_Cost');
        } else {
            return Product::where('Product_ID', $product_id)->first()->$key_product;
        }
    }
    public static function get_child($parent)
    {
        $child = CategoryModel::where('Category_Parent', $parent)->get()->toArray();
        $array = array_column($child, 'id');
        return $array;
    }
}