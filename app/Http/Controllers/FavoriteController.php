<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use FuncHelper;
use App\Model\Product;

class FavoriteController extends Controller
{
    function add_session($favorite, $product_id)
    {
        $favorite_id = substr(md5(microtime()), rand(0, 26), 5);
        $price =  number_format(FuncHelper::getValueKeyQuery($product_id, 'Product_Price'), 0, ',', '.') . ' đ';
        $cost =  number_format(FuncHelper::getValueKeyQuery($product_id, 'Product_Cost'), 0, ',', '.') . ' đ';
        $favorite[] = array(
            'Favorite_ID' => $favorite_id,
            'Product_ID' => $product_id,
            'Product_Price' => $price,
            'Product_Name' => FuncHelper::getValueKeyQuery($product_id, 'Product_Name'),
            'Product_Image' => FuncHelper::getValueKeyQuery($product_id, 'Product_Image'),
            'Product_Slug' => FuncHelper::getValueKeyQuery($product_id, 'Product_Slug'),
            'Product_Cost' => $cost
        );
        Session::put('favorite', $favorite);
    }
    public function add_favorite(Request $request)
    {

        $data = $request->all();
        $product_id = $data['product_id'];

        $favorite = Session::get('favorite');
        $is_available = 0;
        if ($favorite == true) {
            foreach ($favorite as $key => $val) {
                if ($val['Product_ID'] == $data['product_id']) {
                    $is_available++;
                }
            }
            // điều kiện lúc tồn tại session cart sau đó thêm vào session cart
            if ($is_available == 0) {
                $this->add_session($favorite, $product_id);
            }
        } else { // điều kiện lúc chưa tồn tại session cart
            $this->add_session($favorite, $product_id);
        }
        return response()->json(Session::get('favorite'));
    }

    public function show_favorite(Request $request)
    {
        $favorites = Session::has('favorite') ?  Session::get('favorite') : [];

        $pro_id = array_map(function ($value) {
            return $value["Product_ID"];
        }, $favorites);
        $category_id = Product::whereIn('Product_ID', $pro_id)->pluck('Category_ID');
        $related_product =  Product::whereIn('Category_ID',  $category_id)->orderby('Product_View', 'DESC')->take(50)->get();

        if ($request->ajax()) {
            return response()->json($favorites);
        }
        return view('frontend.favorite.favorite')->with(compact('favorites', 'related_product'));
    }
    public function cancel_favorite(Request $request)
    {
        $favorites = Session::get('favorite');
        $data = $request->all();
        $product_id = $data['product_id'];

        $new_arr = array_filter($favorites,  function ($array) use ($product_id) {
            return $array["Product_ID"] !=  $product_id;
        });
        Session::put('favorite', array_values($new_arr));
        return response()->json($new_arr);
    }
}