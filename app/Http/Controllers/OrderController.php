<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Models\CouponModel;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\StatisticsModel;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerModel;
use App\Models\ShippingModel;
use Illuminate\Support\Facades\Mail;
use Cart;
use DB;
use PDF;
use Session;
use Carbon\Carbon;


class OrderController extends Controller
{
    public function authLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return redirect::to('/dashboard');
        } else {
            return redirect::to('/login-by-auth')->send();
        }
    }
    public function manage_order()
    {
        $this->authLogin();
        $all_order = DB::table('tbl_order')->join('tbl_customer', 'tbl_customer.Customer_ID', '=', 'tbl_order.Customer_ID')->select('tbl_order.*', 'tbl_customer.Customer_Name')->orderby('tbl_order.Order_ID', 'desc')->get();
        return view('admin.manage-order')->with('manage_order', $all_order);
    }
    public function order_detail(Request $request, $order_detail_id)
    {
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
            ->select('tbl_order_detail.*', 'tbl_shipping.*')
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
        return view('admin.view-order')->with('manage_order', $all_order)->with(compact('customer_info', 'shipping_info', 'coupon_condition', 'coupon_number'));
    }
    public function update_quantity_ajax(Request $request)
    {
        $data = $request->all();
        $order_details = OrderDetailModel::where('Product_ID', $data['product_id'])->where('Order_Code', $data['order_code'])->first();
        $order_details->Product_Sales_Quantity = $data['order_quantity'];
        $order_details->save();
    }
    public function update_order_quantity_ajax(Request $request)
    {
        //update order
        $data = $request->all();
        $order = OrderModel::find($data['order_id']);
        $order->Order_Status = $data['order_status'];
        $order->save();

        if ($order->Order_Status == 2) {
            foreach ($data['order_product_id'] as $key => $product_id) {

                $product = Product::find($product_id);
                $product_quantity = $product->Product_Quantity;
                $product_sold = $product->Product_Sold;

                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key == $key2) { // so sánh có trên cùng hàng hay không
                        $product_remain = $product_quantity - $qty;
                        $product->Product_Quantity = $product_remain;
                        $product->Product_Sold = $product_sold + $qty;
                        $product->save();
                    }
                }
            }
        } elseif ($order->Order_Status == 1) {
            foreach ($data['order_product_id'] as $key => $product_id) {

                $product = Product::find($product_id);
                $product_quantity = $product->Product_Quantity;
                $product_sold = $product->Product_Sold;

                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key == $key2) { // so sánh có trên cùng hàng hay không
                        $product_remain = $product_quantity + $qty;
                        $product->Product_Quantity = $product_remain;
                        $product->Product_Sold = $product_sold - $qty;
                        $product->save();
                    }
                }
            }
        } // end if


        //order date
        $order_date = $order->Order_Date;

        $statistic = StatisticsModel::where('Statistics_Order_Date', $order_date)->get();
        if ($statistic) {
            $statistic_count = $statistic->count();
        } else {
            $statistic_count = 0;
        }

        //Update dữ liệu statistic
        //them
        $total_order = 0;
        $sales = 0;
        $profit = 0;
        $quantity = 0;

        foreach ($data['order_product_id'] as $key => $product_id) {

            $product = Product::find($product_id);
            $product_quantity = $product->Product_Quantity;
            $product_sold = $product->Product_Sold;

            //them
            $product_price = $product->Product_Price;
            $product_cost = $product->Product_Cost;

            $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

            foreach ($data['quantity'] as $key2 => $qty) {

                if ($key == $key2) {
                    $pro_remain = $product_quantity - $qty;
                    $product->Product_Quantity = $pro_remain;
                    $product->Product_Sold = $product_sold + $qty;
                    $product->save();

                    //update doanh thu
                    $quantity += $qty;  //Tổng số sản phẩm đã bán được
                    $total_order += 1;  //Tổng số đơn đặt hàng
                    $sales += $product_price * $qty;
                    $profit = $sales - ($product_cost * $qty);
                }
            }
        }
        if ($order->Order_Status == 2) {
            // //Lấy các dữ liệu đưa vào mail xác nhận đơn hàng
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
            $title_mail = "Đơn hàng đã đặt được xác nhận" . ' ' . $now;

            $customer = CustomerModel::where('Customer_ID', $order->Customer_ID)->first();
            $order_detail = OrderDetailModel::where('Order_Code', $order->Order_Checkout_Code)->first();
            $ship = ShippingModel::where('Shipping_ID', $order->Shipping_ID)->first();

            $data['email'] = $customer->Customer_Email;

            //Lấy phí vận chuyển và mã giảm giá
            $fee_delivery = $order_detail->Product_Fee_Delivery;
            $coupon_code_mail = $order_detail->Product_Coupon_Code;

            //lấy thông tin vận chuyển
            $get_shipping = array(
                'FeeShip' =>  $fee_delivery,
                'Customer_Name' => $customer->Customer_Name,
                'Shipping_FullName' => $ship->Shipping_Fullname,
                'Shipping_Email' => $ship->Shipping_Email,
                'Shipping_Phone' => $ship->Shipping_Phone,
                'Shipping_Address' => $ship->Shipping_Address,
                'Shipping_Note' => $ship->Shipping_Note,
                'Shipping_Payment_Select' => $ship->Shipping_Payment_Select
            );

            foreach ($data['order_product_id'] as $key => $product) {
                $product_mail = Product::find($product);
                foreach ($data['quantity'] as $key2 => $qty) {

                    if ($key == $key2) {

                        $get_cart[] = array(
                            'Product_Name' => $product_mail['Product_Name'],
                            'Product_Price' => $product_mail['Product_Price'],
                            'Product_Qty' => $qty
                        );
                    }
                }
            }

            //lay ma giam gia, lay coupon code
            $get_order = array(
                'coupon_code_mail' => $coupon_code_mail,
                'order_checkout_code' => $order_detail->Order_Code,
            );

            Mail::send('mail.confirm-mail-order',  ['get_cart' => $get_cart, 'get_shipping' => $get_shipping, 'get_order' => $get_order], function ($message) use ($title_mail, $data) {
                $message->to($data['email'])->subject($title_mail); //send this mail with subject
                $message->from($data['email'], $title_mail); //send from this mail
            });
        }

        if ($statistic_count > 0) {
            if ($order->Order_Status == 2) {
                $statistic_update = StatisticsModel::where('Statistics_Order_Date', $order_date)->first();
                $statistic_update->Statistics_Sales = $statistic_update->Statistics_Sales + $sales;
                $statistic_update->Statistics_Profit =  $statistic_update->Statistics_Profit + $profit;
                $statistic_update->Statistics_Quantity =  $statistic_update->Statistics_Quantity + $quantity;
                $statistic_update->Statistics_Total_Order = $statistic_update->Statistics_Total_Order + $total_order;
                $statistic_update->save();
            } else if ($order->Order_Status == 1) {
                $statistic_update = StatisticsModel::where('Statistics_Order_Date', $order_date)->first();
                $statistic_update->Statistics_Sales = $statistic_update->Statistics_Sales - $sales;
                $statistic_update->Statistics_Profit =  $statistic_update->Statistics_Profit - $profit;
                $statistic_update->Statistics_Quantity =  $statistic_update->Statistics_Quantity - $quantity;
                $statistic_update->Statistics_Total_Order = $statistic_update->Statistics_Total_Order - $total_order;
                $statistic_update->save();
            }
        } else {
            $statistic_new = new StatisticsModel();
            $statistic_new->Statistics_Order_Date = $order_date;
            $statistic_new->Statistics_Sales = $sales;
            $statistic_new->Statistics_Profit =  $profit;
            $statistic_new->Statistics_Quantity =  $quantity;
            $statistic_new->Statistics_Total_Order = $total_order;
            $statistic_new->save();
        }
    }
    public function history_order(Request $request)
    {
        $getOrder = OrderModel::where('Customer_ID', Session::get('Customer_ID'))
            ->orderby('Order_ID', 'DESC')
            ->paginate(6);

        $meta_description = 'Lịch sử đơn hàng';
        $meta_keyword = 'Lịch sử đơn hàng';
        $title = 'Lịch sử đơn hàng';
        $meta_canonical = $request->url();

        return view('pages.history.history-order')->with(compact(
            'getOrder',
            'title',
            'meta_keyword',
            'meta_canonical',
            'meta_description',
        ));
    }
    public function view_history_order(Request $request, $order_checkout_code)
    {
        if (!Session::get('Customer_ID')) {
            return redirect('/login-checkout')->with('error', 'Vui lòng đăng nhập để xem lịch sử mua hàng');
        } else {
            //seo
            $meta_description = 'Xem chi tiết đơn hàng';
            $meta_keyword = 'Xem chi tiết đơn hàng';
            $title = 'Xem chi tiết đơn hàng';
            $meta_canonical = $request->url();
            //--seo

            //xem lich sử
            $order_details = OrderDetailModel::where('Order_Code', $order_checkout_code)->get();
            $getOrder = OrderModel::where('Order_Checkout_Code', $order_checkout_code)->first();

            $customer_id = $getOrder->Customer_ID;
            $shipping_id = $getOrder->Shipping_ID;
            $order_status = $getOrder->Order_Status;

            $customer = CustomerModel::where('Customer_ID', $customer_id)->first();
            $shipping = ShippingModel::where('Shipping_ID', $shipping_id)->first();

            foreach ($order_details as $key => $order_d) {

                $product_coupon = $order_d->Product_Coupon_Code;
            }
            if ($product_coupon != 'No') {
                $coupon = CouponModel::where('Coupon_Code', $product_coupon)->first();
                $coupon_condition = $coupon->Coupon_Condition;
                $coupon_number = $coupon->Coupon_Number;
            } else {
                $coupon_condition = 2;
                $coupon_number = 0;
            }

            return view('pages.history.view-history-order')
                ->with(compact(
                    'meta_description',
                    'meta_keyword',
                    'title',
                    'meta_canonical',
                    'order_status',
                    'coupon_condition',
                    'coupon_number',
                    'order_details',
                    'getOrder',
                    'order_checkout_code',
                    'customer',
                    'shipping'
                ));
        }
    }
}