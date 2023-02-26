<?php

namespace App\Http\Controllers;

use App\Models\CatePostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Rules\GoogleCaptcha;
use Validator;
use DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Model\VisitorModel;
use App\Model\PostModel;
use App\Model\Product;
use Faker\Factory;
use App\Model\StatisticsModel;
use App\Model\CustomerModel;

class AdminController extends Controller
{
    public function login_normal()
    {
        return view('admin.login.login-normal');
    }
    public function authLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id || Session::get('Admin_ID')) {
            return redirect::to('/dashboard');
        } else {
            return redirect::to('/login-by-auth')->send();
        }
    }
    public function show() // Route::get('/dashboard', 'AdminController@show');
    {
        $this->authLogin();
        return view('admin-layout');
    }
    public function dashboard(Request $request) // Route::post('/admin-dashboard', 'AdminController@dashboard');
    {
        $Admin_Email = $request->admin_email;
        $Admin_Password = md5($request->admin_password);
        $result = DB::table('tbl_table')->where('Admin_Email', $Admin_Email)->where('Admin_Password', $Admin_Password)->first();
        $validatedData = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
        ]);
        if ($result) {
            Session::put('Admin_Name', $result->Admin_Name); // lưu giá trị lên session để có thể get dữ liệu trong session
            Session::put('Admin_ID', $result->Admin_ID); // lưu giá trị lên session

            return redirect::to('/dashboard'); //Route::get('/dashboard', 'AdminController@show');
        } else {
            session::put('message', 'Tài khoản hoặc mật không đúng');
            return redirect::to('/login-normal'); // Route::get('/admin', 'AdminController@login');
        }
    }
    public function logout()
    {
        $this->authLogin();
        Session::forget('Admin_Name');
        Session::forget('Admin_ID');
        Session::forget('login_by_social');
        // Auth::logout();
        return redirect::to('/login-by-auth');
    }
    public function dashboard_finance()
    {
        return view('backend.dashboard.dashboard');
    }
    public function dashboard_sale()
    {
        return view('backend.dashboard.dashboard-sale');
    }

    public function show_dashboard(Request $request)
    {
        $this->AuthLogin();
        //get ip address
        $user_ip_address = $request->ip();

        $first_day_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString(); // yyyy-mm-dd (example: 2015-04-21)

        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $first_day_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();

        $one_years = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        //total last month //Tính số địa chỉ ip truy cập vào web từ đầu đến cuối tháng trước
        $visitor_of_lastmonth = VisitorModel::whereBetween('Visitor_Date', [$first_day_of_last_month, $end_of_last_month])->get();
        $visitor_last_month_count = $visitor_of_lastmonth->count();

        //total this month //Tính số địa chỉ ip truy cập vào web từ ngày đầu tiên của tháng đến hiện tại
        $visitor_of_this_month = VisitorModel::whereBetween('Visitor_Date', [$first_day_this_month, $now])->get();
        $visitor_this_month_count = $visitor_of_this_month->count();

        //total in one year //Tính số địa chỉ ip truy cập vào web từ ngày thứ ($now - 365) đến $now
        $visitor_of_year = VisitorModel::whereBetween('Visitor_Date', [$one_years, $now])->get();
        $visitor_year_count = $visitor_of_year->count();

        //total visitors
        $visitors = VisitorModel::all();
        $visitors_total = $visitors->count();

        //current online
        $visitors_current = VisitorModel::where('Visitor_Ip_Address', $user_ip_address)->get();
        $visitor_count = $visitors_current->count();

        if ($visitor_count < 1) {
            $visitor = new VisitorModel();
            $visitor->Visitor_Ip_Address = $user_ip_address;
            $visitor->Visitor_Date = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }

        $all_cate_post = CatePostModel::all();

        // //total
        // $product = Product::all()->count();
        // $post = Post::all()->count();
        // $order = Order::all()->count();
        // $video = Video::all()->count();
        // $customer = Customer::all()->count();

        // $product_views = Product::orderBy('product_views', 'DESC')->take(20)->get();
        // // $post_views = Post::orderBy('post_views', 'DESC')->take(20)->get();


        return view('admin.dashboard')->with(compact(
            'visitors_total',
            'visitor_count',
            'visitor_last_month_count',
            'visitor_this_month_count',
            'visitor_year_count',
            'all_cate_post'
        ));
    }
    public function order_statistics_ajax()
    {
        $currentWeek = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subdays(14)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        // // Lấy ngày thống kê từ ngày $now đến $now - 15 ngày trước
        // $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$sub60days, $now])->orderBy('Statistics_Order_Date', 'ASC')->get();
        $get_current_week = StatisticsModel::whereBetween('Statistics_Order_Date', [$currentWeek, $now])->orderBy('Statistics_Order_Date', 'DESC')->get();
        $get_last_week = StatisticsModel::whereBetween('Statistics_Order_Date', [$lastWeek, $currentWeek])->orderBy('Statistics_Order_Date', 'DESC')->get();


        foreach ($get_current_week as $key => $val) {

            $chart_data_one[] = array(
                'period' => $val->Statistics_Order_Date,
                'order' => $val->Statistics_Total_Order,
                'sales' => $val->Statistics_Sales,
                'CoH' => $val->Statistics_CoH,
                'expenses' => $val->Statistics_Expenses,
                'quantity' => $val->Statistics_Quantity
            );
        }
        $all_order_details =  DB::table('tbl_order_detail')
            ->select('Product_Name', DB::raw('SUM(Product_Sales_Quantity) as total_quantity'), DB::raw('SUM(Product_Fee_Delivery) as total_delivery'), DB::raw('max(tbl_order_detail.created_at) as order_time'))
            ->groupBy('Product_Name')
            ->orderBy('total_quantity', 'DESC')
            ->get()
            ->toArray();
        // foreach ($all_order_details as $key => $val) {
        //     foreach (DB::table('tbl_order_detail')->where('')->get() as $key => $val)
        // }

        $sum_sales_today = 0;
        $sum_expenses_today = 0;
        foreach ($get_current_week as $key => $val) {
            if ($val->Statistics_Order_Date ==  date_format(date_create("2021-12-25"), "Y-m-d")) {
                $sum_sales_today += $val->Statistics_Sales;
                $sum_expenses_today += $val->Statistics_Expenses;
            }
        }
        foreach ($get_last_week as $key => $val) {

            $chart_data_two[] = array(
                'period_ago' => $val->Statistics_Order_Date,
                'order_ago' => $val->Statistics_Total_Order,
                'sales_ago' => $val->Statistics_Sales,
                'CoH_ago' => $val->Statistics_CoH,
                'expenses_ago' => $val->Statistics_Expenses,
                'quantity_ago' => $val->Statistics_Quantity
            );
        }
        $chart_data_three = array(
            'nnlshop' => CustomerModel::where('Customer_Login', 'nnlshop')->count(),
            'google' => CustomerModel::where('Customer_Login', 'google')->count(),
            'facebook' => CustomerModel::where('Customer_Login', 'facebook')->count(),
        );
        $chart_data_four[] = array(
            'sum_expenses_today' => $sum_expenses_today,
            'sum_sales_today' => $sum_sales_today
        );
        // $chart_data_three = array(
        //     CustomerModel::where('Customer_Login', 'nnlshop')->count(),
        //     CustomerModel::where('Customer_Login', 'google')->count(),
        //     CustomerModel::where('Customer_Login', 'facebook')->count()
        // );
        $chart_data = [
            "current_week" => $chart_data_one,
            "last_week" => $chart_data_two,
            "customer" => $chart_data_three,
            "statistic_today" => $chart_data_four,
            "all_order_details" => $all_order_details,
        ];
        echo json_encode($chart_data);
    }
    public function filter_by_date_ajax(Request $request)
    {

        $data = $request->all();

        // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        // $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('d-m-Y H:i:s');
        // $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->format('d-m-Y H:i:s');
        // $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(15)->format('d-m-Y H:i:s');
        // $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->format('d-m-Y H:i:s');

        $first_day_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $first_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $oneYearAgo = Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();

        $first_twoMonth_ago = Carbon::now('Asia/Ho_Chi_Minh')->subMonths(3)->startOfMonth()->toDateString();
        // $end_of_twoMonth_ago = Carbon::now('Asia/Ho_Chi_Minh')->endOfMonth()->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['filter_value'] == 'sevenDays') {
            $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$sub7days, $now])->orderBy('Statistics_Order_Date', 'ASC')->get();
        } elseif ($data['filter_value'] == 'lastMonth') {

            $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$first_of_last_month, $end_of_last_month])->orderBy('Statistics_Order_Date', 'ASC')->get();
        } elseif ($data['filter_value'] == 'thisMonth') {

            $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$first_day_this_month, $now])->orderBy('Statistics_Order_Date', 'ASC')->get();
        } elseif ($data['filter_value'] == 'twoMonthsAgo') {
            $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$first_twoMonth_ago, $end_of_last_month])->orderBy('Statistics_Order_Date', 'ASC')->get();
        } elseif ($data['filter_value'] == 'oneYearAgo') {
            $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$oneYearAgo, $now])->orderBy('Statistics_Order_Date', 'ASC')->get();
        }

        if (count($get) < 1) {
            $chart_data[] = array(
                'period' => 'Không có doanh thu trong tháng này',
                'order' => null,
                'sales' => null,
                'profit' => null,
                'quantity' => null
            );
        } else {
            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->Statistics_Order_Date,
                    'order' => $val->Statistics_Total_Order,
                    'sales' => $val->Statistics_Sales,
                    'profit' => $val->Statistics_Profit,
                    'quantity' => $val->Statistics_Quantity
                );
            }
        }


        echo json_encode($chart_data);
    }
    public function filterByDate_input_ajax(Request $request)
    {

        $data = $request->all();

        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = StatisticsModel::whereBetween('Statistics_Order_Date', [$from_date, $to_date])->orderBy('Statistics_Order_Date', 'ASC')->get();


        if (count($get) < 1) {
            $chart_data[] = array(
                'period' => 'Không có doanh thu trong khoảng thời gian từ ' . $from_date . ' đến ' . $to_date,
                'order' => null,
                'sales' => null,
                'profit' => null,
                'quantity' => null
            );
        } else {
            foreach ($get as $key => $val) {
                $chart_data[] = array(
                    'period' => $val->Statistics_Order_Date,
                    'order' => $val->Statistics_Total_Order,
                    'sales' => $val->Statistics_Sales,
                    'profit' => $val->Statistics_Profit,
                    'quantity' => $val->Statistics_Quantity
                );
            }
        }

        echo $data = json_encode($chart_data);
    }
}