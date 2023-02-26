<?php

namespace App\Http\Controllers;

use App\Model\AdminModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Session;
use Cookie;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ValidateFormSignInAdmin;

session_start();

class LoginController extends Controller
{
    public function register_by_auth()
    {

        $title_login_form = "Đăng ký tài khoản";
        return view('backend.login.sign-up')->with(compact('title_login_form'));
    }
    public function login_by_auth()
    {
        $title_login_form = "Đăng nhập";
        Session::put('previous_url', url()->previous());
        return view('backend.login.sign-in')->with(compact('title_login_form'));
    }

    public function check_login(ValidateFormSignInAdmin $request)
    {
        $request->validated();

        $info = [
            'Admin_Name' => $request->account_name,
            'Admin_Password' => md5($request->account_password),
        ];

        // $remember_me = $request->has('remember_me') ? true : false;
        $remember_me  = (!empty($request->remember_me)) ? TRUE : FALSE;

        if (Auth::guard('admin')->attempt($info)) {
            $user = AdminModel::where(["Admin_Name" => $info['Admin_Name']])->first();

            // tiến hành lưu lại user cho lần đăng nhập sau
            Auth::guard('admin')->login($user, $remember_me);

            //Lưu thông tin với thời gian hạn định là 10 phút
            Cookie::queue('adminuser', $request->account_name, 10);
            Cookie::queue('adminpwd', $request->account_password, 10);

            Session::put('Admin_Name', Auth::guard('admin')->user()->Admin_Name);

            // redirect authenticate
            if (Session::get('previous_url') == route('backend.login_by_auth') || Session::get('previous_url') == route('backend.register_by_auth')) {
                return redirect()->route('backend.dashboard_finance');
            } else {
                return Redirect::to(Session::get('previous_url'));
            }
            // Session::get('previous_url') == route('backend.login_by_auth') || Session::get('previous_url') == route('backend.register_by_auth')
        } else {
            return redirect()->route('backend.login_by_auth')->with('message', 'Tên tài khoản hoặc mật khẩu không đúng');
        }
    }

    public function save_register(Request $request)
    {
        // $this->validation($request);
        $data = $request->all();
        $admin = new AdminModel();
        $admin->Admin_Name = $data['account_name'];
        $admin->Admin_Phone = $data['account_phone'];
        $admin->Admin_Email = $data['account_email'];
        $admin->Admin_Password = md5($data['account_password']);
        $admin->Admin_Gender = $request->input('gender');

        $admin->save();
        return redirect()->route('backend.login_by_auth')->with('message', 'Đăng ký thành công');
    }

    public function logout_by_auth()
    {
        // Chỉ đăng xuất người dùng khỏi ứng dụng trên thiết bị hiện tại của họ.
        Auth::guard('admin')->logout();
        Session::forget('Admin_Name');

        return redirect()->route('backend.login_by_auth')->with('message', 'Đăng xuất trang quản lý thành công');
    }
}