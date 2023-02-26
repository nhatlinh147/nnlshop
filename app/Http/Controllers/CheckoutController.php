<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Product;
use App\Http\Requests\ValidateLoginForm;
use App\Models\Ward;
use App\Models\Province;
use App\Models\District;
use App\Models\FeeModel;
use App\Models\ShippingModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\CustomerModel;
use App\Models\CarouselModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\CatePostModel;
use App\Models\CouponModel;
use Illuminate\Support\Facades\Mail;
use Cart;
use DB;
use Carbon\Carbon;

use Session;


class CheckoutController extends Controller
{
    public function confirm_order_ajax(Request $request)
    {
        $data = $request->all();

        if ($data['order_coupon'] != 'No') {
            $coupon = CouponModel::where('Coupon_Code', $data['order_coupon'])->first();
            // $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
            $coupon->Coupon_Amount = $coupon->Coupon_Amount - 1;
            $coupon_code_mail = $coupon->Coupon_Code;
            $coupon->save();
        }

        $shipping = new ShippingModel();
        $shipping->Shipping_Fullname = $data['shipping_fullname'];
        $shipping->Shipping_Email = $data['shipping_email'];
        $shipping->Shipping_Address = $data['shipping_address'];
        $shipping->Shipping_Phone = $data['shipping_phone'];
        $shipping->Shipping_Note = $data['shipping_note'];
        $shipping->Shipping_Payment_Select = $data['shipping_payment_select'];
        $shipping->save();
        $shipping_id = $shipping->Shipping_ID;

        $order_checkout_code = substr(md5(microtime()), rand(0, 26), 5);


        $order = new OrderModel;
        $order->Customer_ID = Session::get('Customer_ID');
        $order->Shipping_ID = $shipping_id;
        $order->Order_Status = 1;
        $order->Order_Date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->Order_Checkout_Code = $order_checkout_code;


        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at = now();
        $order->save();

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetailModel;
                $order_details->Order_Code = $order_checkout_code; //
                $order_details->Product_ID = $cart['Product_ID'];
                $order_details->Product_Name = $cart['Product_Name'];
                $order_details->Product_Price = $cart['Product_Price'];
                $order_details->Product_Sales_Quantity = $cart['Product_Qty'];
                $order_details->Product_Coupon_Code =  $data['order_coupon'];
                $order_details->Product_Fee_Delivery = $data['order_fee'];
                $order_details->save();
            }
        }

        // //Lấy các dữ liệu đưa vào mail xác nhận đơn hàng
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Đơn hàng xác nhận ngày" . ' ' . $now;


        $customer = CustomerModel::find(Session::get('Customer_ID'));
        $data['email'] = $customer->Customer_Email;

        //Lấy phí vận chuyển
        if (Session::get('Fee_Delivery') == true) {
            $fee_delivery = Session::get('Fee_Delivery') . ' đ';
        } else {
            $fee_delivery = 'Chưa điền địa điểm vận chuyển hàng';
        }

        //lấy thông tin vận chuyển
        $get_shipping = array(
            'FeeShip' =>  $fee_delivery,
            'Customer_Name' => $customer->Customer_Name,
            'Shipping_FullName' => $data['shipping_fullname'],
            'Shipping_Email' => $data['shipping_email'],
            'Shipping_Phone' => $data['shipping_phone'],
            'Shipping_Address' => $data['shipping_address'],
            'Shipping_Note' => $data['shipping_note'],
            'Shipping_Payment_Select' => $data['shipping_payment_select']
        );

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart_mail) {
                $get_cart[] = array(
                    'Product_Name' => $cart_mail['Product_Name'],
                    'Product_Price' => $cart_mail['Product_Price'],
                    'Product_Qty' => $cart_mail['Product_Qty']
                );
            }
        }

        //lay ma giam gia, mã đơn hàng
        $get_order = array(
            'coupon_code_mail' => $coupon_code_mail,
            'order_checkout_code' => $order_checkout_code,
        );

        Mail::send('mail.confirm-order',  ['get_cart' => $get_cart, 'get_shipping' => $get_shipping, 'get_order' => $get_order], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail); //send this mail with subject
            $message->from($data['email'], $title_mail); //send from this mail
        });

        Session::forget('coupon');
        Session::forget('Fee_Delivery');
        Session::forget('cart');
    }
    public function login_checkout(Request $request)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();

        $title = "Eshopper bán hàng online";

        $meta_keyword = "";
        for ($i = 0; $i < count($all_category_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_category_product[0]->Category_Name;
            } else {
                $meta_keyword .= "," . $all_category_product[$i]->Category_Name;
            }
        }
        for ($i = 0; $i < count($all_brand_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_brand_product[0]->Brand_Name;
            } else {
                $meta_keyword .= "," . $all_brand_product[$i]->Brand_Name;
            }
        }
        $meta_description = "Các sản phẩm điện tử là những mặt hàng không thể thiếu đối với bất kì ai, bất kì gia đình, cơ sở, doanh nghiệp nào. Chính vì thế, khi lựa chọn các mặt hàng điện tử, khách hàng thường phải cân nhắc lựa chọn các cửa hàng có uy tín để đảm bảo chất lượng của sản phẩm.";
        $meta_canonical = $request->url();

        return view('pages.checkout.login-checkout')->with(compact('all_category_product', 'all_brand_product', 'title', 'meta_keyword', 'meta_canonical', 'meta_description'));
    }
    public function add_customer(Request $request)
    {
        $data = array();
        $data['Customer_Name'] = $request->customer_name;
        $data['Customer_Email'] = $request->customer_email;
        $data['Customer_Password'] = md5($request->customer_password);
        $data['Customer_Phone'] = $request->customer_phone;
        $data['Customer_Address'] = $request->customer_address;

        $Customer_ID = DB::table('tbl_customer')->insertGetId($data);

        Session::put('Customer_ID', $Customer_ID);
        Session::put('Customer_Name', $request->customer_name);

        return redirect::to('/checkout');
    }
    public function checkout(Request $request)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();

        // lấy danh mục con trong toàn bộ danh mục sản phẩm
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();

        $getProvince = Province::orderby('Province_Code', 'DESC')->get();
        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(4)->get();
        // thẻ meta (SEO)
        $title = "Eshopper bán hàng online";

        $meta_keyword = "";
        for ($i = 0; $i < count($all_category_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_category_product[0]->Category_Name;
            } else {
                $meta_keyword .= "," . $all_category_product[$i]->Category_Name;
            }
        }
        for ($i = 0; $i < count($all_brand_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_brand_product[0]->Brand_Name;
            } else {
                $meta_keyword .= "," . $all_brand_product[$i]->Brand_Name;
            }
        }
        $meta_description = "Các sản phẩm điện tử là những mặt hàng không thể thiếu đối với bất kì ai, bất kì gia đình, cơ sở, doanh nghiệp nào. Chính vì thế, khi lựa chọn các mặt hàng điện tử, khách hàng thường phải cân nhắc lựa chọn các cửa hàng có uy tín để đảm bảo chất lượng của sản phẩm.";
        $meta_canonical = $request->url();

        return view('pages.checkout.show-checkout')->with(compact('all_category_product', 'all_brand_product', 'title', 'meta_keyword', 'meta_canonical', 'meta_description', 'getProvince', 'all_slide', 'category_child'));
    }
    public function search(Request $request)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();
        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(4)->get();
        $keyword = $request->keyword_search;
        // Session::put('keyword_current', $keyword);
        $search_product = Product::where('Product_Status', '1')->where('Product_Name', 'like', '%' . $keyword . '%')->get();
        $meta_keyword = "";

        for ($i = 0; $i < count($all_category_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_category_product[0]->Category_Name;
            } else {
                $meta_keyword .= ", " . $all_category_product[$i]->Category_Name;
            }
        }
        for ($i = 0; $i < count($all_brand_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_brand_product[0]->Brand_Name;
            } else {
                $meta_keyword .= ", " . $all_brand_product[$i]->Brand_Name;
            }
        }
        $title = "Kết tìm kiếm: " . $keyword;
        $meta_description = "Các sản phẩm điện tử là những mặt hàng không thể thiếu đối với bất kì ai, bất kì gia đình, cơ sở, doanh nghiệp nào. Chính vì thế, khi lựa chọn các mặt hàng điện tử, khách hàng thường phải cân nhắc lựa chọn các cửa hàng có uy tín để đảm bảo chất lượng của sản phẩm.";
        $meta_canonical = $request->url();

        return view('pages.search.show-search-results')->with(compact('all_category_product', 'all_brand_product', 'search_product', 'keyword', 'title', 'meta_keyword', 'meta_canonical', 'meta_description', 'all_slide'));
    }

    public function save_checkout_customer(Request $request)
    {
        $data = array();
        $data['Shipping_Fullname'] = $request->shipping_fullname;
        $data['Shipping_Email'] = $request->shipping_email;
        $data['Shipping_Address'] = $request->shipping_address;
        $data['Shipping_Phone'] = $request->shipping_phone;
        $data['Shipping_Note'] = $request->shipping_note;

        $Shipping_ID = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('Shipping_ID', $Shipping_ID);

        return redirect::to('payment');
    }
    public function payment(Request $request)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();

        // thẻ meta
        $title = "Eshopper bán hàng online";
        $category_product = DB::table('tbl_category_product')->where('Category_Status', '1')->select('tbl_category_product.Category_Name')->get();

        $meta_keyword = "";
        for ($i = 0; $i < count($all_category_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_category_product[0]->Category_Name;
            } else {
                $meta_keyword .= "," . $all_category_product[$i]->Category_Name;
            }
        }
        for ($i = 0; $i < count($all_brand_product); $i++) {
            if ($i == 0) {
                $meta_keyword .= $all_brand_product[0]->Brand_Name;
            } else {
                $meta_keyword .= "," . $all_brand_product[$i]->Brand_Name;
            }
        }
        $meta_description = "Các sản phẩm điện tử là những mặt hàng không thể thiếu đối với bất kì ai, bất kì gia đình, cơ sở, doanh nghiệp nào. Chính vì thế, khi lựa chọn các mặt hàng điện tử, khách hàng thường phải cân nhắc lựa chọn các cửa hàng có uy tín để đảm bảo chất lượng của sản phẩm.";
        $meta_canonical = $request->url();

        return view('pages.checkout.payment')->with(compact('all_category_product', 'all_brand_product', 'meta_keyword', 'meta_description', 'meta_canonical', 'title'));
    }

    public function order(Request $request)
    {
        $data = array();
        $data['Payment_Method'] = $request->payment_method;
        $data['Payment_Status'] = 'Đang chờ xử lý';
        $Payment_ID = DB::table('tbl_payment')->insertGetId($data);

        $data_order = array();
        $data_order['Customer_ID'] = Session::get('Customer_ID');
        $data_order['Shipping_ID'] = Session::get('Shipping_ID');
        $data_order['Payment_ID'] = $Payment_ID;
        $data_order['Order_Total'] = Cart::total(0);
        $data_order['Order_Status'] = 'Đang chờ xử lý';

        $Order_ID = DB::table('tbl_order')->insertGetId($data_order);

        foreach (Cart::content() as $item) {
            $data_d_order = array();
            $data_d_order['Order_ID'] = $Order_ID;
            $data_d_order['Product_ID'] = $item->id;
            $data_d_order['Product_Name'] = $item->name;
            $data_d_order['Product_Price'] = $item->price;
            $data_d_order['Product_Sales_Quantity'] = $item->qty;

            DB::table('tbl_order_detail')->insert($data_d_order);
        }
        if ($data['Payment_Method'] == 1) {
            echo 'thanh toán bằng thẻ ATM';
        } else if ($data['Payment_Method'] == 2) {
            $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
            $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();

            return view('pages.checkout.handcash')->with('all_category_product', $all_category_product)->with('all_brand_product', $all_brand_product);
        } else {
            echo 'Thanh toán bằng thẻ ghi nợ';
        }
    }
    public function select_delivery_home_ajax(Request $request) // route: add-coupon
    {
        $data = $request->all();
        $output = '';
        if ($data['getId'] == 'Province' && $data['getId'] == true) {
            $select_district = District::where('District_Code_Province', $data['getValue'])->get();
            $output .= '<option>--Chọn quận huyện--</option>';
            foreach ($select_district as $value) {
                $output .= '<option value="' . $value->District_Code . '">' . $value->District_Name . '</option>';
            }
        } else {
            $select_ward = Ward::where('Ward_Code_District', $data['getValue'])->get();
            $output .= '<option>--Chọn xã phường--</option>';
            foreach ($select_ward as $value) {
                $output .= '<option value="' . $value->Ward_ID . '">' . $value->Ward_Name . '</option>';
            }
        }
        echo $output;
    }
    public function calculate_fee_delivery_ajax(request $request) //route: save-coupon
    {
        $data = $request->all();
        if ($data['getProvince']) {
            $getValueFee = FeeModel::Where('Fee_Province_Code', $data['getProvince'])->Where('Fee_District_Code', $data['getDistrict'])->Where('Fee_Ward_ID', $data['getWard'])->get();
            if ($getValueFee) {
                $count = $getValueFee->count();
                if ($count > 0) {
                    foreach ($getValueFee as $key => $value) {
                        Session::put('Fee_Delivery', $value->Fee_Delivery);
                        Session::save();
                    }
                } else {
                    Session::put('Fee_Delivery', 250000);
                    Session::save();
                }
            }
        }
    }
    public function delete_delivery(request $request) //route: save-coupon
    {
        Session::forget('Fee_Delivery');
        return redirect()->back();
    }
    public function logout_checkout()
    {
        // Session::flush();
        Session::flash('Customer_ID');
        Session::flash('Customer_Name');
        return redirect('/login-checkout');
    }

    public function login_customer(Request $request)
    {
        $customer_email = $request->email_account;
        $customer_password = md5($request->password_account);
        $result = DB::table('tbl_customer')->where('Customer_Email', $customer_email)->where('Customer_Password', $customer_password)->first();
        if ($result) {
            Session::put('Customer_ID', $result->Customer_ID);
            return redirect::to('/checkout');
        } else {
            Session::put('message', 'Tài khoản hoặc mật khẩu không đúng');
            return redirect::to('/login-checkout');
        }
    }
}