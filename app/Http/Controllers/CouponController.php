<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CouponModel;
use App\Model\CartModel;
use Illuminate\Support\Facades\Auth;;

class CouponController extends Controller
{
    public function check_coupon(Request $request)
    {
        $data = $request->all();
        $coupon = CouponModel::where('Coupon_Code', $data['get_coupon'])->where('Coupon_Status', 1)->first();
        return response()->json($coupon);
    }
    public function apply_coupon(Request $request)
    {
        $data = $request->all();
        $coupon = CouponModel::where('Coupon_Code', $data['get_coupon'])->where('Coupon_Status', 1)->first();

        //Update lại Coupon_Amount trong CouponModel
        $update = CouponModel::where('Coupon_Code', $data['get_coupon'])->update(['Coupon_Amount' => $data['get_amount'] - 1]);

        //Update lại địa chỉ id coupon trong cart
        $get_cart = CartModel::where("Customer_ID", Auth::guard('customer')->user()->Customer_ID)->get();
        foreach ($get_cart as $value) {
            CartModel::where("Cart_ID", $value->Cart_ID)->update(["Coupon_ID" => $coupon->Coupon_ID]);
        }
        return response()->json($coupon);
    }
}