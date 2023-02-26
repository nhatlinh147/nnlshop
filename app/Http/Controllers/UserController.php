<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Auth;
use Session;
use Faker\Factory;

class UserController extends Controller
{

    public function add_user()
    {
        $all_role = RoleModel::all();
        return view('admin.grant.add_user')->with(compact('all_role'));
    }
    public function save_user(Request $request)
    {
        $faker = Factory::create();
        $data = $request->all();
        $admin = new AdminModel();
        $admin->Admin_Name =  $data['admin_name'];
        $admin->Admin_Phone = $data['admin_phone'];
        $admin->Admin_Email = $data['admin_email'];
        $admin->Admin_Password = md5($data['admin_password']);
        $admin->save();

        $admin->roles()->attach(RoleModel::where('ID_Role_User', $data['role_id'])->first()); // Lưu hoặc tạo rồi mới role
        Session::put('message', 'Thêm users thành công');

        return redirect()->back();
    }
    public function all_user()
    {
        $all_user = AdminModel::orderBy('Admin_ID', 'DESC')->paginate(5);
        return view('admin.grant.all_user')->with(compact('all_user'));
    }
    public function assign_role(Request $request)
    {

        if (Auth::id() == $request->admin_id) {
            return redirect()->back()->with('message', 'Bạn không được phân quyền chính mình');
        }

        $user = AdminModel::where('Admin_Email', $request->admin_email)->first();

        $user->roles()->detach();
        if ($request->author_role) {
            $user->roles()->attach(RoleModel::where('Name_Middleware', 'Author')->first());
        }
        if ($request->user_role) {
            $user->roles()->attach(RoleModel::where('Name_Middleware', 'User')->first());
        }
        if ($request->admin_role) {
            $user->roles()->attach(RoleModel::where('Name_Middleware', 'Admin')->first());
        }

        return redirect()->back()->with('message', 'Cấp quyền thành công');
    }
    public function transfer_user($admin_id) //Route::get('/transfer-user/{admin_id}', 'UserController@transfer_user');
    {
        $user = AdminModel::where('Admin_ID', $admin_id)->first();
        if ($user) {
            Session::put('transferUser', $user->Admin_ID);
        }
        return redirect()->back();
    }
    public function stop_transfer_user() //Route::get('/stop-transfer-user', 'UserController@stop_transfer_user');
    {
        Session::forget('transferUser');
        return redirect()->back();
    }
}