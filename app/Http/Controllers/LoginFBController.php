<?php

namespace App\Http\Controllers;

use App\Models\LoginModel;
use App\Models\SocialModel;
use App\Models\SocialCustomerModel;
use App\Models\CustomerModel;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LoginFBController extends Controller
{
    public function login_FB()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_index()
    {
        $getinfoFacebook = Socialite::driver('facebook')->user();
        $loginFirst = SocialModel::where('Provider', 'Facebook')->where('Provider_User_ID', $getinfoFacebook->getId())->first();
        if ($loginFirst) {
            $getInfoIndex = LoginModel::where('Admin_ID', $loginFirst->User)->first();
            Session::put('Admin_Name', $getInfoIndex->Admin_Name);
            Session::put('Admin_ID', $getInfoIndex->Admin_ID);
            return redirect::to('/dashboard');
        } else { // lưu giá trj để đăng nhập lần tiếp theo
            $insertInfoLogin = new SocialModel([
                'Provider_User_ID' => $getinfoFacebook->getId(),
                'Provider' => 'Facebook'
            ]); // khởi tạo giá trị cho 2 trường Provider_User_ID, Provider
            $getEqualToIndex = LoginModel::where('Admin_Email', $getinfoFacebook->getEmail())->first(); //lấy giá trị đầu tiên sao cho email với giá trị trong bảng tbl_table
            if (!$getEqualToIndex) { // nếu địa chỉ email không giống với email trong facebook thì bắt đầu thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
                $getEqualToIndex = LoginModel::create([
                    'Admin_Email' => $getinfoFacebook->getEmail(),
                    'Admin_Name' => $getinfoFacebook->getName(),
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
            return redirect::to('/dashboard');
        }
    }
    public function customer_login_facebook()
    {
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        return Socialite::driver('facebook')->redirect();
    }

    public function customer_callback_facebook()
    {
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        $getinfoFacebook = Socialite::driver('facebook')->stateless()->user();
        $loginFirst = SocialCustomerModel::where('Provider', 'facebook')
            ->where('Provider_User_ID', $getinfoFacebook->getId())->first(); // so sánh điều kiện đăng nhập lần đầu
        if ($loginFirst) {
            $getInfoIndex = CustomerModel::where('Customer_ID', $loginFirst->Customer_User)->first();
            Session::put('Customer_Name', $getInfoIndex->Customer_Name);
            Session::put('Customer_ID', $getInfoIndex->Customer_ID);
        } else { // lưu giá trị để đăng nhập lần tiếp theo
            $insertInfoLogin = new SocialCustomerModel([
                'Provider_User_ID' => $getinfoFacebook->getId(),
                'Provider' => 'facebook'
            ]); // khởi tạo giá trị cho 2 trường Provider_User_ID, Provider
            $getEqualToIndex = CustomerModel::where('Customer_Email', $getinfoFacebook->getEmail())->first(); //lấy giá trị đầu tiên sao cho email với giá trị trong bảng tbl_table
            if (!$getEqualToIndex) { // nếu địa chỉ email không giống với email trong facebook thì bắt đầu thiết lập giá trị cho 4 trường Admin_Email,Admin_Name,Admin_Password,Admin_Phone
                $getEqualToIndex = CustomerModel::create([
                    'Customer_Email' => $getinfoFacebook->getEmail(),
                    'Customer_Name' => $getinfoFacebook->getName(),
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
    }
}