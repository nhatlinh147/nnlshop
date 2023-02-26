<?php

namespace App\Http\Controllers;

use App\Model\CategoryModel;
use App\Model\BrandModel;
use Illuminate\Http\Request;
use App\Model\PostModel;
use Carbon\Carbon;
use App\Model\CommentModel;
use App\Model\CatePostModel;
use App\Model\Product;
use Illuminate\Support\Facades\Session;
use App\Jobs\ControllerQueueJob;
use App\Model\SlideModel;
use App\Model\SpecialOfferModel;

use DB;
use Storage;
use File;

class FetchDataController extends Controller
{
    public function active_dropdown(Request $request)
    {
        if ($request->ajax()) {
            $active = $request->active;
            Session::put('active', $active);
            return response()->json(['active' => $active]);
        }
    }

    public function delete_product(Request $request)
    {
        $data = $request->all();
        $info = [
            'data' => [],
        ];
        if ($request->ajax()) {
            $product = Product::where('Product_ID', $data['product_id'])->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->join('tbl_brand_product', 'tbl_brand_product.Brand_ID', '=', 'tbl_product.Brand_ID')->first();
            unlink('public/upload/product/' . $product->Product_Image);

            foreach ($product->gallery as $key => $value) {
                unlink('public/upload/gallery/' . $value->Gallery_Image);
            }
            //Phân loại điều kiện pdf,doc và không
            if ($product->Product_Document != "Không") {
                if (pathinfo($product->Product_Document, PATHINFO_EXTENSION) == 'pdf') {
                    unlink('public/upload/document/' . $product->Product_Document);
                } else {
                    $details = [
                        "controller" => "deletedrive",
                        "get_path" => $data['get_path']
                    ];
                    dispatch(new ControllerQueueJob($details));
                }
            }

            DB::table('tbl_product')->where('Product_ID', $data['product_id'])->delete();
            DB::table('tbl_gallery')->where('Product_ID', $data['product_id'])->delete();

            $info['data'] = $product;

            return $info;
        }
    }

    public function view_product(Request $request)
    {
        $data = $request->all();

        if ($request->ajax()) {
            // $path_image = 'public/upload/temporary/';
            // $getImage = $request->file('product_image');
            // $setNameImage = $data['getName'];
            // $url = Storage::url($data['getName']);
        }
        return response()->json(['setNameImage' => $data['getName']]);
    }

    public function post_user(Request $request)
    {
        $data = $request->all();
        if ($request->ajax()) {

            $post = PostModel::where('Post_Slug', $data['slug'])->firstOrFail();
            // if ($data['status'] == 'Next') {
            //     $post_slug = PostModel::where('Post_Status', 1)->where('Post_ID', '>', $post->Post_ID)->orderBy('Post_ID', 'ASC')->whereNotIn('Post_Slug', [$data['slug']])->take(1)->get();
            // } else if ($data['status'] == 'Previous') {
            //     $post_slug = PostModel::where('Post_Status', 1)->where('Post_ID', '<', $post->Post_ID)->orderBy('Post_ID', 'DESC')->whereNotIn('Post_Slug', [$data['slug']])->take(1)->get();
            // }

            $now_post = Carbon::now('Asia/Ho_Chi_Minh')->format('M d Y - H:i:s');

            if ($data['status'] == 'Next') {
                $post_slug = PostModel::where('Post_Status', 1)->where('Post_ID', '>', $post->Post_ID)->where('Cate_Post_ID', $post->Cate_Post_ID)->orderBy('Post_ID', 'ASC')->whereNotIn('Post_Slug', [$data['slug']])->take(1)->get();
            } else if ($data['status'] == 'Previous') {
                $post_slug = PostModel::where('Post_Status', 1)->where('Post_ID', '<', $post->Post_ID)->where('Cate_Post_ID', $post->Cate_Post_ID)->orderBy('Post_ID', 'DESC')->whereNotIn('Post_Slug', [$data['slug']])->take(1)->get();
            }

            foreach ($post_slug as $key => $post) {
                //seo
                $meta_image = $post->Post_Image;
                $cate_post_id = $post->Cate_Post_ID;
            }


            $post_pagination = PostModel::where('Post_Status', 1)->where('Cate_Post_ID', $post->Cate_Post_ID)->simplePaginate(1);

            $post_related = PostModel::where('Post_Status', 1)->where('Cate_Post_ID', $cate_post_id)->whereNotIn('Post_Slug', [$data['slug']])->take(5)->get();

            return view('pages.include.prevNext-postUser', compact('post_pagination', 'post_slug', 'now_post', 'meta_image', 'post_related'));
        }
    }
    public function category_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $category = CategoryModel::find($data['category_id']);
            $category->Category_Status =  $data['status'];
            $category->save();
        }
    }

    public function brand_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $brand = BrandModel::find($data['brand_id']);
            $brand->Brand_Status =  $data['status'];
            $brand->save();
        }
    }
    public function product_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $product = Product::find($data['product_id']);
            $product->Product_Status =  $data['status'];
            $product->save();
        }
    }
    public function slide_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $product = SlideModel::find($data['slide_id']);
            $product->Slide_Status = $data['status'];
            $product->save();
        }
    }
    public function cate_post_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $cate_post = CatePostModel::find($data['cate_post_id']);
            $cate_post->Cate_Post_Status = $data['status'];
            $cate_post->save();
        }
    }
    public function post_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $post = PostModel::find($data['post_id']);
            $post->Post_Status = $data['status'];
            $post->save();
        }
    }
    public function special_status(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $special = SpecialOfferModel::find($data['special_id']);
            $special->Special_Status = $data['status'];
            $special->save();
        }
        return response()->json($special);
    }

    public function status_comment(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            if ($data['comment_status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $post = CommentModel::where('Comment_ID', $data['comment_id'])->update(['Comment_Status' => $status]);
            return response()->json(['comment_status' => $status, 'comment_id' => $data['comment_id']]);
        }
    }
}