<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\CustomerModel;
use App\Http\Requests\ValidateFormSignInCustomer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cookie;

class CustomerController extends Controller
{
    public function sign_in_customer()
    {
        Session::put('previous_url_customer', url()->previous());
        return view('frontend.customer.sign-in');
    }
    public function sign_up_customer()
    {
        Session::put('previous_url_customer', url()->previous());
        return view('frontend.customer.sign-up');
    }
    public function check_exist(Request $request)
    {
        $data = $request->all();
        if (!empty($data['customer_name'])) {
            $customer_count = CustomerModel::where('Customer_Name', $data['customer_name'])->count();
        }
        if (!empty($data['customer_email'])) {
            $customer_count = CustomerModel::where('Customer_Email', $data['customer_email'])->count();
        }

        if (!empty($customer_count)) {
            echo 'false'; // false thì hiển thị thông báo
        } else {
            echo 'true';
        }
    }
    public function save_register(Request $request)
    {
        $data = $request->all();
        $name =  $data['customer_name'];
        $path = public_path('upload/avatar/');
        $fontPath = public_path('FrontEnd/fonts/poppins/roboto-condensed-v16-latin-700.ttf');
        $char = substr(ucfirst($name), 0, 2);
        $newAvatarName = rand(12, 34353) . time() . '_ ' . $name . '.png';
        $dest = $path . $newAvatarName;
        $createAvatar = makeAvatar($fontPath, $dest, $char);
        $picture = $createAvatar == true ? $newAvatarName : '';

        $customer = new CustomerModel();
        $customer->Customer_Name = $name;
        $customer->Customer_Email = $data['customer_email'];
        $customer->Customer_Login = 'nnlshop';
        $customer->Customer_Address = $data['customer_address'];
        $customer->Customer_Image = $picture;
        $customer->Customer_Phone = $data['customer_phone'];
        $customer->Customer_Password = md5($data['customer_password']);
        $customer->save();

        Auth::guard('customer')->login($customer);
        return redirect()->route('frontend.index');
    }
    public function check_login(ValidateFormSignInCustomer $request)
    {
        $request->validated();

        $info = [
            'Customer_Name' => $request->customer_name,
            'Customer_Password' => md5($request->customer_password),
        ];

        $remember_me  = (!empty($request->remember_me)) ? TRUE : FALSE;

        if (Auth::guard('customer')->attempt($info)) {
            $customer = CustomerModel::where(["Customer_Name" => $info['Customer_Name']])->first();

            // tiến hành lưu lại user cho lần đăng nhập sau
            Auth::guard('customer')->login($customer, $remember_me);

            //Lưu thông tin với thời gian hạn định là 10 phút
            Cookie::queue('customeruser', $request->customer_name, 10);

            // redirect authenticate
            if (Session::get('previous_url_customer') == route('frontend.sign_in_customer') || Session::get('previous_url_customer') == route('frontend.sign_up_customer')) {
                return redirect()->route('frontend.index');
            } else {
                return Redirect::to(Session::get('previous_url_customer'));
            }
        } else {
            return redirect()->route('frontend.sign_in_customer')->with('message', 'Tên tài khoản hoặc mật khẩu không đúng');
        }
    }
    public function logout_by_auth()
    {
        // Chỉ đăng xuất người dùng khỏi ứng dụng trên thiết bị hiện tại của họ.
        Auth::guard('customer')->logout();
        return redirect()->route('frontend.sign_in_customer')->with('message', 'Đăng xuất thành công');
    }
}