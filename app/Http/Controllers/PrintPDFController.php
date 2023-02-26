<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\OrderDetailModel;
use App\Models\Product;
use App\Models\CouponModel;

use Cart;
use DB;

use PDF;
use Session;

class PrintPDFController extends Controller
{
    public function printf_order_pdf(Request $request, $order_detail_id)
    {
        $title = "Thông tin đơn hàng";
        $all_order = OrderDetailModel::with('product')
            ->join('tbl_order', 'tbl_order.Order_Checkout_Code', '=', 'tbl_order_detail.Order_Code')
            ->where('tbl_order.Order_Checkout_Code', $order_detail_id)
            ->orderby('tbl_order_detail.Order_Detail_ID', 'desc')->get();
        $customer_info = DB::table('tbl_order_detail')
            ->join('tbl_order', 'tbl_order.Order_Checkout_Code', '=', 'tbl_order_detail.Order_Code')
            ->join('tbl_customer', 'tbl_customer.Customer_ID', '=', 'tbl_order.Customer_ID')
            ->select('tbl_order_detail.*', 'tbl_customer.*') //
            ->where('tbl_order.Order_Checkout_Code', $order_detail_id)
            ->limit(1)->get();
        $shipping_info = DB::table('tbl_order_detail')
            ->join('tbl_order', 'tbl_order.Order_Checkout_Code', '=', 'tbl_order_detail.Order_Code')
            ->join('tbl_shipping', 'tbl_shipping.Shipping_ID', '=', 'tbl_order.Shipping_ID')
            ->select('tbl_order_detail.*', 'tbl_shipping.*', 'tbl_order.created_at') //
            ->where('tbl_order.Order_Checkout_Code', $order_detail_id)
            ->limit(1)->get();
        foreach ($all_order as $key => $order) {
            $product_coupon_code = $order->Product_Coupon_Code;
        }
        if ($product_coupon_code != 'No') {
            $coupon = CouponModel::where('Coupon_Code', $product_coupon_code)->first();
            $coupon_condition = $coupon->Coupon_Condition;
            $coupon_number = $coupon->Coupon_Number;
        } else {
            $coupon_condition = 3;
            $coupon_number = 0;
        }
        // $pdf = PDF::loadView('admin.view-order')->with('manage_order', $all_order)->with(compact('customer_info', 'shipping_info', 'coupon_condition', 'coupon_number'));
        $view = \View::make('print.order')->with('manage_order', $all_order)->with(compact('customer_info', 'shipping_info', 'coupon_condition', 'coupon_number', 'title'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf = \PDF::loadHTML($view);
        return $pdf->stream("printf_order.pdf");
    }
    public function printf_product_pdf(Request $request)
    {
        //Lấy dữ liệu
        $title = "Thông tin các sản phẩm";
        $all_product = DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->join('tbl_brand_product', 'tbl_brand_product.Brand_ID', '=', 'tbl_product.Brand_ID')->get();
        $manager_product = view('admin.all-product');

        // In ra pdf
        $view = \View::make('print.product')->with(compact('all_product', 'title'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf = \PDF::loadHTML($view);
        return $pdf->stream("printf_product.pdf");
    }
}