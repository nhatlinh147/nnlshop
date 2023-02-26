<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CategoryModel;
use App\Model\CatePostModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use DB;

class CatePostController extends Controller
{
    public function list_cate_post()
    {
        return view('backend.cate_post.list-cate-post');
    }

    public function list_cate_post_json()
    {
        $info = [
            'data' => [],
        ];
        $cate_post = CatePostModel::all();
        $info['data'] = $cate_post;

        return $info;
    }
    public function save_cate_post(request $request)
    {
        $data = $request->all();
        $cate_postId = $data['cate_post_id'];
        $cate_post = CatePostModel::updateOrCreate(
            ['Cate_Post_ID' => $cate_postId],
            [
                'Cate_Post_Name' => $data['cate_post_name'],
                'Cate_Post_Slug' => $data['cate_post_slug'],
                'Cate_Post_Desc' => $data['cate_post_desc'],
                'Meta_Keywords_Cate_Post' => $data['meta_keywords_cate_post'],
                'Cate_Post_Status' => $data["cate_post_status"],
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString(),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString()
            ]
        );
        if ($data['cate_post_id']) {
            DB::table('tbl_cate_post')->where('Cate_Post_ID', $data['cate_post_id'])->update(['updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString()]);
        }
        return response()->json($cate_post);
    }
    public function edit_cate_post($cate_post_id)
    {
        $where = array('Cate_Post_ID' => $cate_post_id);
        $cate_post  = CatePostModel::where($where)->first();
        return response()->json($cate_post);
    }

    public function delete_cate_post(Request $request, $cate_post_id)
    {
        if ($request->ajax()) {
            $cate_post = CatePostModel::where('Cate_Post_ID', $cate_post_id)->delete();
        }
        return response()->json($cate_post);
    }
    public function delete_cate_post_selected(Request $request)
    {
        if ($request->ajax()) {
            $cate_post = CatePostModel::whereIn('Cate_Post_ID', $request->ids)->delete();
        }

        return response()->json($cate_post);
    }
}