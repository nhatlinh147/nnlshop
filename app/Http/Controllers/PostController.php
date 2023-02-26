<?php

namespace App\Http\Controllers;

use App\Model\BrandModel;
use App\Model\CarouselModel;
use App\Model\CategoryModel;
use App\Model\CatePostModel;
use App\Model\PostModel;
use App\Model\PostViewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Carbon\Carbon;

use Event;

class PostController extends Controller
{

    public function list_post()
    {
        $category_post = CatePostModel::orderBy('Cate_Post_ID', 'DESC')->get();
        return view('backend.post.list-post')->with(compact('category_post'));
    }

    public function list_post_json()
    {
        $info = [
            'data' => [],
        ];
        $post = PostModel::all();
        $info['data'] = $post;

        return $info;
    }
    public function save_post(Request $request)
    {
        $data = $request->all();

        $request_image =  $request->file('post_image');
        $path_post = 'public/upload/post/';

        if ($request_image) {
            $postImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();
            $request_image->move($path_post, $postImage);
        } else {
            $postImage = PostModel::where('Post_ID', $data['post_id'])->first()->Post_Image;
        }

        $postId = $data['post_id'];
        $post = PostModel::updateOrCreate(
            ['Cate_Post_ID' => $postId],
            [
                'Post_Title' => $data['post_title'],
                'Post_Slug' => $data['post_slug'],
                'Post_Image' => $postImage,
                'Post_Desc' => $data['post_desc'],
                'Post_Content' => $data['post_content'],
                'Meta_Desc_Post' => $data['meta_desc_post'],
                'Meta_Keywords_Post' => $data['meta_keywords_post'],
                'Cate_Post_ID' => $data['cate_post_id'],
                'Post_Status' => $data['post_status'],
                'Post_Views' => 0,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString(),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString()
            ]
        );
        if ($data['get_image'] && $request_image) {
            unlink($path_post . $data['get_image']);
        }
        return response()->json($post);
    }

    public function delete_post($post_id)
    {
        $get_post = PostModel::where('Post_ID', $post_id)->first();
        unlink('public/upload/post/' . $get_post->Post_Image);

        $post = PostModel::where('Post_ID', $post_id)->delete();
        return response()->json($post);
    }
    public function delete_post_selected(Request $request)
    {
        if ($request->ajax()) {
            $get_post = PostModel::whereIn('Post_ID', $request->ids)->get();

            foreach ($get_post as $value) {
                unlink('public/upload/post/' . $value->Post_Image);
            }

            $post = PostModel::whereIn('Post_ID', $request->ids)->delete();
        }


        return response()->json($post);
    }

    public function edit_post($post_id)
    {
        $where = array('Post_ID' => $post_id);
        $post  = PostModel::where($where)->first();
        return response()->json($post);
    }


    public function category_blog_user(Request $request, $post_slug)
    {
        // Danh mục bài viết
        $all_post = CatePostModel::orderBy('Cate_Post_ID', 'DESC')->get();

        //lấy danh mục và thương hiệu con
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();
        $brand_child = BrandModel::whereNotIn('Brand_Parent', [0])->get();

        $all_product = Product::where('Product_Status', '1')->paginate(3);

        //lấy thương hiệu và danh mục sản phẩm
        $all_category_product = CategoryModel::where('Category_Status', '1')->get();
        $all_brand_product = BrandModel::where('Brand_Status', '1')->get();

        // chuyển slug nhận được thành id // thông qua id first database
        $post_slug = CatePostModel::where('Cate_Post_Slug', $post_slug)->take(1)->get();

        foreach ($post_slug as $key => $cate) {
            //seo
            $meta_description = $cate->Cate_Post_Desc;
            $meta_keyword = $cate->Cate_Post_Slug;
            $title = $cate->Cate_Post_Name;
            $post_id = $cate->Cate_Post_ID;
            $meta_canonical = $request->url();
            $meta_image = url('public/upload/category-blog.png');
            //--seo
        }

        $now_post = Carbon::now('Asia/Ho_Chi_Minh')->format('M d Y - H:i:s');
        $all_post = PostModel::where('Post_Status', 1)->where('Cate_Post_ID', $post_id)->paginate(5);

        // $post_cate = PostModel::with('post')->where('post_status', 0)->where('Cate_Post_ID', $cate_id)->paginate(5);

        return view('pages.post-index.cate-post-user')->with(compact(
            'all_post',
            'category_child',
            'brand_child',
            'all_category_product',
            'all_brand_product',
            'post_slug',
            'meta_description',
            'meta_keyword',
            'title',
            'post_id',
            'meta_canonical',
            'title',
            'meta_image',
            'all_product',
            'now_post',
            'all_post',
        ));
    }
    public function blog_user(Request $request, $post_slug_link)
    {
        // Danh mục bài viết
        $all_post = CatePostModel::orderBy('Cate_Post_ID', 'DESC')->get();

        //lấy danh mục và thương hiệu con
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();
        $brand_child = BrandModel::whereNotIn('Brand_Parent', [0])->get();

        $all_product = Product::where('Product_Status', '1')->paginate(3);

        //lấy thương hiệu và danh mục sản phẩm
        $all_category_product = CategoryModel::where('Category_Status', '1')->get();
        $all_brand_product = BrandModel::where('Brand_Status', '1')->get();


        $post_slug = PostModel::where('Post_Status', 1)->where('Post_Slug', $post_slug_link)->get();

        foreach ($post_slug as $key => $post) {
            //seo
            $meta_description = $post->Post_Desc;
            $meta_keyword = $post->Post_Meta_Keywords;
            $title = $post->Post_Title;
            $meta_canonical = $request->url();
            $meta_image = $post->Post_Image;
            $post_id = $post->Post_ID;
            $post_id = $post->Cate_Post_ID;
            //--seo
        }

        $post_pagination = PostModel::where('Post_Status', 1)->where('Cate_Post_ID', $post_id)->simplePaginate(1); // lấy dữ liệu để pagination
        $post_related = PostModel::where('Post_Status', 1)->where('Cate_Post_ID', $post_id)->whereNotIn('Post_Slug', [$post_slug_link])->take(5)->get();

        $get_post = PostModel::findOrFail($post_id);

        Event::dispatch('pages.post-index.post-user', $get_post);

        $now_post = Carbon::now('Asia/Ho_Chi_Minh')->format('M d Y - H:i:s');

        // $get_post = PostModel::findOrFail($post_id);
        // $expiresAt = now()->addMinutes(1);
        // views($get_post)->cooldown($expiresAt)->record();


        return view('pages.post-index.post-user')->with(compact(
            'all_post',
            'category_child',
            'brand_child',
            'all_category_product',
            'all_brand_product',
            'meta_description',
            'meta_keyword',
            'title',
            'meta_canonical',
            'title',
            'meta_image',
            'all_product',
            'now_post',
            'post_slug',
            'post_pagination',
            'post_related'
        ))->withPost($get_post);
    }
}