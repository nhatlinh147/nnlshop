<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use FuncHelper;

use App\Model\CartModel;
use App\Model\Product;

class CartController extends Controller
{
    function get_all()
    {
        $price = [];
        $check = Auth::guard('customer')->check();
        $customer = Auth::guard('customer')->user();

        if ($check) {
            $all_cart = CartModel::where('Customer_ID', $customer->Customer_ID)->get();
            foreach ($all_cart as $cart) {
                array_push($price, $cart->product->getOriginal('Product_Price'));
            }
            $get_coupon = CartModel::where('Customer_ID', $customer->Customer_ID)->first();
            $all_favorite = Session::has('favorite') ? Session::get('favorite') :  [];
        } else {
            $all_cart = Session::has('cart') ? Session::get('cart') : [];
            foreach ($all_cart as $cart) {
                array_push($price, $cart['Product_Price']);
            }
            $all_favorite = [];
        }

        if (empty($get_coupon)) {
            $get_coupon = 0;
        } else {
            $get_coupon = $get_coupon->coupon == null ? 0 :  $get_coupon->coupon;
        }

        $get_data = array(
            'all_cart' => $all_cart,
            'all_favorite' => $all_favorite,
            "price" => $price,
            "get_coupon" => $get_coupon
        );
        return $get_data;
    }

    function add_session($cart, $qty, $product_id)
    {
        $cart_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart[] = array(
            'Cart_ID' => $cart_id,
            'Cart_Quantity' => $qty,
            'Product_ID' => $product_id,
            'Product_Price' => FuncHelper::getValueKeyQuery($product_id, 'Product_Price'),
            'Product_Name' => FuncHelper::getValueKeyQuery($product_id, 'Product_Name'),
            'Product_Image' => FuncHelper::getValueKeyQuery($product_id, 'Product_Image')
        );
        Session::put('cart', $cart);
    }

    public function add_cart_guest(Request $request)
    {
        $data = $request->all();

        $qty = $data['cart_quantity'];
        $product_id = $data['product_id'];

        $cart = Session::get('cart');
        $is_available = 0;
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['Product_ID'] == $data['product_id']) {
                    $is_available++;
                }
            }
            // ??i???u ki???n l??c t???n t???i session cart sau ???? th??m v??o session cart
            if ($is_available == 0) {
                $this->add_session($cart, $qty, $product_id);
            }
        } else { // ??i???u ki???n l??c ch??a t???n t???i session cart
            $this->add_session($cart, $qty, $product_id);
        }
        return response()->json([
            'cart' => Session::get('cart'),
            'is_available' => $is_available
        ]);
    }

    public function show_cart(Request $request)
    {
        $get = $this->get_all();
        $all_cart = $get['all_cart'];

        return view('frontend.cart.cart')->with(compact('all_cart'));
    }
    function get_key($key_query, $condition)
    {
        $get = Session::get("cart");
        $array = [];


        foreach ($get as $key => $cart) {
            if (!is_array($condition)) {
                if ($key_query == 'Product_ID') {
                    if ($cart['Product_ID'] == $condition) {
                        return $key;
                    }
                } else if ($key_query == 'Cart_ID') {
                    if ($cart['Cart_ID'] == $condition) {
                        return $key;
                    }
                }
            } else {
                foreach ($condition as $value) {
                    if ($cart['Cart_ID'] == $value) {
                        array_push($array, $key);
                    }
                }
            }
        }
        return $array;
    }
    public function save_cart(Request $request)
    {
        $data = $request->all();
        $product_id =  $data['product_id'];
        $customer_id = $data['customer_id'];
        $cart_query = CartModel::where('Product_ID', $product_id)->where('Customer_ID', $customer_id)->first();
        $session_cart = Session::get("cart");

        // Gi?? tr??? l??u l???n ?????u
        $qty = 1;

        //N???u c?? minus th?? gi???m m???t gi?? tr???  == 0
        //N???u kh??ng c?? minus th?? t??ng m???t gi?? tr???  == 0
        if (!isCheckCustomer()) {
            if ($product_id != 0) {
                $get_key = $this->get_key("Product_ID", $product_id);
                $qty = $session_cart[$get_key]["Cart_Quantity"];
                if ($data['minus'] == 0) {
                    $qty++;
                } else if ($data['minus'] == 1) {
                    $qty--;
                } else if ($data['minus'] == 2) {
                    $qty = $data['cart_quantity'];
                } else if ($data['minus'] == 3) {
                    $qty =  $qty + $data['cart_quantity'];
                }
                if ($product_id != 0) {
                    $session_cart[$get_key]["Cart_Quantity"] =  $qty; // $qty++
                    Session::put('cart', $session_cart);
                }
            }
        } else {
            if (!empty($cart_query)) {

                $qty = $cart_query->Cart_Quantity;

                if ($data['minus'] == 0) {
                    $qty++;
                } else if ($data['minus'] == 1) {
                    $qty--;
                } else if ($data['minus'] == 2) {
                    $qty = $data['cart_quantity'];
                } else if ($data['minus'] == 3) {
                    $qty = $data['cart_quantity'] +  $qty;
                }
            }

            //C???p nh???t ho???c th??m v??o gi??? h??ng
            //X??t t???i tr?????ng h???p t??nh s??? l?????ng s???n ph???m trong cart trong l???n m??? website l???n ?????u
            if ($product_id != 0) {
                $cart_selected = CartModel::updateOrCreate(
                    ['Cart_ID' => empty($cart_query->Cart_ID) ? '' : $cart_query->Cart_ID],
                    [
                        'Product_ID' => $product_id,
                        'Cart_Quantity' =>  $qty,
                        'Customer_ID' => $customer_id
                    ]
                );
            }
        }

        //Li???t k?? ra c??c m???c c???n l???y d??? li???u
        $get = $this->get_all();

        $cart = $get['all_cart'];
        $price = $get['price'];
        $get_coupon =  $get['get_coupon'];
        $first_time_added = (isCheckCustomer() && empty($cart_query) && $product_id != 0) ?  Product::find($product_id)->Product_Name : 0;
        $favorite = $get['all_favorite'];

        return response()->json([
            'cart' => $cart,
            'count_favorite' => count($favorite),
            'price' => $price,
            'get_coupon' => $get_coupon,
            'first_time_added' => $first_time_added
        ]);
    }

    public function delete_cart($cart_id)
    {
        if (isCheckCustomer()) {
            $cart = CartModel::where('Cart_ID', $cart_id)->delete();
        } else {
            $cart = $this->get_all()["all_cart"];
            $get_key = $this->get_key('Cart_ID', $cart_id);

            $new_arr = array_filter($cart,  function ($array) use ($get_key) {
                $get_key = $get_key;
                return $array !=  $get_key;
            }, ARRAY_FILTER_USE_KEY);
            Session::put('cart', $new_arr);
        }
        // var_dump($new_arr);
        return redirect()->back();
    }

    public function delete_selected_cart(Request $request)
    {
        $data = $request->all();
        if (isCheckCustomer()) {
            $cart = CartModel::whereIn('Cart_ID', $data['cart_id'])->delete();
        } else {
            $cart = $this->get_all()["all_cart"];
            $array_key = $this->get_key('ID', $data['cart_id']);

            $new_arr = array_filter($cart,  function ($array) use ($array_key) {
                return !in_array($array, $array_key);
            }, ARRAY_FILTER_USE_KEY);
            Session::put('cart', $new_arr);
        }
    }
}