<?php

namespace App\Http\Controllers;

use App\Mail\Send_Mail;
use App\Model\CarouselModel;
use App\Model\CouponModel;
use App\Model\CustomerModel;
use Google\Service\Directory\Resource\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Jobs\ControllerQueueJob;
use App\Model\AdminModel;
use Session;

class MailController extends Controller
{
    public function send_mail()
    {
        // $to_name = "Customer Name";
        // $to_email = "obito123@gmail.com"; //send to this email
        // $from_email = "madara123@gmail.com";
        // $from_name = "Admin Name";

        // $data = ["name" => "noi dung ten", "body" => "noi dung body"]; //body of mail.blade.php
        // Mail::send('backend.mail.send-mail', $data, function ($message) use ($to_name, $to_email, $from_email, $from_name) {
        //     $message->to($to_email, $to_name)->subject('Test Sending Mail using Laravel Queue'); //send this mail with subject
        // });
        $admin = AdminModel::all();
        $data = [];
        foreach ($admin as $key => $value) {
            $data['email'][] = $value->Admin_Email;
            $data['name'][] = $value->Admin_Name;
        }
        $details = [
            "controller" => "sendmail",
            "to_name" => "Customer Name",
            "to_email" => $data['email'],
            "name" => "Tiêu đề của mail lần 7",
            "body" => "Nội dung của mail lần 7"
        ];

        dispatch(new ControllerQueueJob($details));
        return "Gửi mail thành công";
    }
    public function send_coupon($coupon_amount, $coupon_condition, $coupon_number, $coupon_code)
    {
        //get customer
        $customer = CustomerModel::where('Customer_Classify', '=', 'Normal')->get();

        $coupon = CouponModel::where('Coupon_Code', $coupon_code)->first();
        $start_coupon = $coupon->Coupon_Date_Start;
        $end_coupon = $coupon->Coupon_Date_End;

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Mã khuyến mãi ngày" . ' ' . $now;

        $data = [];
        foreach ($customer as $normal) {
            $data['email'][] = $normal->Customer_Email;
        }

        $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon' => $end_coupon,
            'coupon_amount' => $coupon_amount,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('mail.send-coupon',  ['coupon' => $coupon], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail); //send this mail with subject
            $message->from($data['email'], $title_mail); //send from this mail
        });
        Session::flash('message', 'Gửi mã khuyến mãi khách thường thành công');
        return redirect()->back();
    }
    public function send_coupon_vip($coupon_amount, $coupon_condition, $coupon_number, $coupon_code)
    {
        //get customer
        $customer = CustomerModel::where('Customer_Classify', '=', 'VIP')->get();

        $coupon = CouponModel::where('Coupon_Code', $coupon_code)->first();
        $start_coupon = $coupon->Coupon_Date_Start;
        $end_coupon = $coupon->Coupon_Date_End;

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Mã khuyến mãi ngày" . ' ' . $now;

        $data = [];
        foreach ($customer as $normal) {
            $data['email'][] = $normal->Customer_Email;
        }

        $coupon = array(
            'start_coupon' => $start_coupon,
            'end_coupon' => $end_coupon,
            'coupon_amount' => $coupon_amount,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('mail.send-coupon',  ['coupon' => $coupon], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail); //send this mail with subject
            $message->from($data['email'], $title_mail); //send from this mail
        });
        Session::flash('message', 'Gửi mã khuyến mãi khách VIP thành công');
        return redirect()->back();
    }
    public function forgot_password(Request $request)
    {
        //seo
        $title = "Quên mật khẩu";
        $meta_description = "Quên mật khẩu";
        $meta_keyword = "Quên mật khẩu";
        $meta_canonical = $request->url();

        return view('pages.checkout.forget-password')
            ->with(compact('title', 'meta_description', 'meta_keyword', 'meta_canonical')); //1

    }
    public function recover_pass(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu Lshopper.com.vn" . ' ' . $now;
        $customer = CustomerModel::where('Customer_Email', '=', $data['account_email'])->get();
        foreach ($customer as $key => $value) {
            $customer_id = $value->Customer_ID;
        }

        if ($customer) {
            $count = $customer->count();
            if ($count == 0) {
                return redirect()->back()->with('error', 'Email chưa được đăng ký để khôi phục mật khẩu');
            } else {
                $create_token = Str::random(25);
                $customer = CustomerModel::find($customer_id);
                $customer->remember_token = $create_token;
                $customer->save();
                //send mail

                $to_email = $data['account_email']; //send to this email
                $link_reset_pass = url('/cap-nhat-mat-khau-moi?email=' . $to_email . '&token=' . $create_token);

                $data = array("name" => $title_mail, "body" => $link_reset_pass, 'email' => $data['account_email']); //body of mail.blade.php

                Mail::send('mail.get-password', ['data' => $data], function ($message) use ($title_mail, $data) {
                    $message->to($data['email'])->subject($title_mail); //send this mail with subject
                    $message->from($data['email'], $title_mail); //send from this mail
                });
                //--send mail
                return redirect()->back()->with('message', 'Gửi mail thành công,vui lòng vào email để reset password');
            }
        }
    }
    public function update_new_pass(Request $request)
    {
        //seo
        $title = "Quên mật khẩu";
        $meta_description = "Quên mật khẩu";
        $meta_keyword = "Quên mật khẩu";
        $meta_canonical = $request->url();
        //--seo

        return view('pages.checkout.update-password')
            ->with(compact('title', 'meta_description', 'meta_keyword', 'meta_canonical')); //1
    }
    public function input_new_pass(Request $request)
    {
        $data = $request->all();
        $create_token = Str::random(25);

        $customer = CustomerModel::where('Customer_Email', '=', $data['email'])->where('remember_token', '=',  $data['token'])->get();
        $count = $customer->count();
        if ($count > 0) {
            foreach ($customer as $key => $cus) {
                $customer_id = $cus->Customer_ID;
            }
            $reset = CustomerModel::find($customer_id);
            $reset->Customer_Password = md5($data['account_password']);
            $reset->remember_token = $create_token;
            $reset->save();
            return redirect('login-checkout')->with('message', 'Mật khẩu đã cập nhật mới. Bạn có thể đăng nhập');
        } else {
            return redirect('quen-mat-khau')->with('error', 'Vui lòng nhập lại email vì link đã quá hạn');
        }
    }
}