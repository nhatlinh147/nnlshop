<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\LoginModel;
use App\Models\SocialModel;
use App\Models\SocialCustomerModel;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginGoogle extends Controller
{
    public function login_Google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback_index()
    {
        $getinfoGoogle = Socialite::driver('google')->user();
        $loginFirst = SocialModel::where('Provider', 'Google')->where('Provider_User_ID', $getinfoGoogle->id)->first(); // so sánh điều kiện đăng nhập lần đầu
        if ($loginFirst) {
            $getInfoIndex = LoginModel::where('Admin_ID', $loginFirst->User)->first();
            Session::put('Admin_Name', $getInfoIndex->Admin_Name);
            Session::put('Admin_ID', $getInfoIndex->Admin_ID);
        } else { // lưu giá trị để đăng nhập lần tiếp theo
            $insertInfoLogin = new SocialModel([
                'Provider_User_ID' => $getinfoGoogle->id,
                'Provider' => 'Google'
            ]); // khởi tạo giá trị cho 2 trường Provider_User_ID, Provider
            $getEqualToIndex = LoginModel::where('Admin_Email', $getinfoGoogle->email)->first(); //lấy giá trị đầu tiên sao cho email với giá trị trong bảng tbl_table
            if (!$getEqualToIndex) { // nếu địa chỉ email không giống với email trong facebook thì bắt đầu thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
                $getEqualToIndex = LoginModel::create([
                    'Admin_Email' => $getinfoGoogle->email,
                    'Admin_Name' => $getinfoGoogle->name,
                    'Admin_Phone' => '',
                    'Admin_Password' => ''
                ]);
            }
            // nếu địa chỉ email giống với email trong facebook thì không cần thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
            $insertInfoLogin->Login()->associate($getEqualToIndex); // có thể hiểu được là đối chiếu thông tin từ trường tbl_table.Admin_ID
            $insertInfoLogin->save();

            $getInfoIndex = LoginModel::where('Admin_ID', $insertInfoLogin->User)->first();
            Session::put('Admin_Name', $getInfoIndex->Admin_Name);
            Session::put('Admin_ID', $getInfoIndex->Admin_ID);
        }
        return redirect::to('/dashboard');
        // $user->token;
    }
    public function customer_login_Google()
    {
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }

    public function customer_callback_index()
    {
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        $getinfoGoogle = Socialite::driver('google')->stateless()->user();
        $loginFirst = SocialCustomerModel::where('Provider', 'Google')->where('Provider_User_ID', $getinfoGoogle->id)->first(); // so sánh điều kiện đăng nhập lần đầu
        if ($loginFirst) {
            $getInfoIndex = CustomerModel::where('Customer_ID', $loginFirst->Customer_User)->first();
            Session::put('Customer_Name', $getInfoIndex->Customer_Name);
            Session::put('Customer_ID', $getInfoIndex->Customer_ID);
        } else { // lưu giá trị để đăng nhập lần tiếp theo
            $insertInfoLogin = new SocialCustomerModel([
                'Provider_User_ID' => $getinfoGoogle->id,
                'Provider' => 'Google'
            ]); // khởi tạo giá trị cho 2 trường Provider_User_ID, Provider
            $getEqualToIndex = CustomerModel::where('Customer_Email', $getinfoGoogle->email)->first(); //lấy giá trị đầu tiên sao cho email với giá trị trong bảng tbl_table
            if (!$getEqualToIndex) { // nếu địa chỉ email không giống với email trong facebook thì bắt đầu thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
                $getEqualToIndex = CustomerModel::create([
                    'Customer_Email' => $getinfoGoogle->email,
                    'Customer_Name' => $getinfoGoogle->name,
                    'Customer_Phone' => '',
                    'Customer_Password' => '',
                    'Customer_Address' => '',
                    'Customer_Classify' => 'Normal'
                ]);
            }
            // nếu địa chỉ email giống với email trong facebook thì không cần thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
            $insertInfoLogin->Customer()->associate($getEqualToIndex); // có thể hiểu được là đối chiếu thông tin từ trường tbl_table.Admin_ID
            $insertInfoLogin->save();

            $getInfoIndex = CustomerModel::where('Customer_ID', $insertInfoLogin->Customer_User)->first();
            Session::put('Customer_Name', $getInfoIndex->Customer_Name);
            Session::put('Customer_ID', $getInfoIndex->Customer_ID);
        }
        return redirect::to('/checkout');
        // $user->token;
    }
}