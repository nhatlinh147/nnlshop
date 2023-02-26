<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Model\BrandModel;
use App\Model\CarouselModel;
use DB;
use Session;
use Illuminate\Support\Facades\Auth;

class BrandProduct extends Controller
{
    public function authLogin()
    {
        $admin_id = Auth::id();
        if ($admin_id) {
            return redirect::to('/dashboard');
        } else {
            return redirect::to('/login-by-auth')->send();
        }
    }
    public function add_brand_product()
    {
        $getBrandParent = BrandModel::where('Brand_Parent', 0)->orderBy('Brand_ID', 'DESC')->get();
        return view('backend.brand.add-brand')->with(compact('getBrandParent'));
    }

    public function all_brand_product()
    {
        $all_brand_product = BrandModel::all();
        $brand_parent = BrandModel::where('Brand_Parent', 0)->orderBy('Brand_ID', 'DESC')->get();
        return view('backend.brand.all-brand')->with(compact('all_brand_product', 'brand_parent'));
    }
    public function all_brand_pro_json()
    {
        $info = [
            'data' => [],
        ];
        $all_brand_product = BrandModel::all();
        $info['data'] = $all_brand_product;

        return $info;
    }
    public function save_brand_product(request $request)
    {
        $data = $request->all();
        $brandId = $data['brand_pro_id'];
        // $getCategory = DB::table('tbl_category_product')->where('id', $data['cate_pro_id'])->first();
        $brand_product  =   BrandModel::updateOrCreate(
            ['Brand_ID' => $brandId],
            [
                'Brand_Name' => $data['brand_product_name'],
                'Brand_Desc' => $data['brand_product_desc'],
                'Brand_Parent' => $data["brand_parent"],
                'Meta_Keywords_Brand' => $data['meta_keywords_brand'],
                'Brand_Product_Slug' => $data['brand_product_slug'],
                'Brand_Status' => $data["brand_status"],
            ]
        );

        return response()->json($brand_product);
    }
    public function edit_brand_product($brand_pro_id)
    {
        $where = array('Brand_ID' => $brand_pro_id);
        $brand_pro  = BrandModel::where($where)->first();
        return response()->json($brand_pro);
    }

    public function delete_brand_product($brand_pro_id)
    {
        $brand_pro = BrandModel::where('Brand_ID', $brand_pro_id)->delete();
        return response()->json($brand_pro);
    }
    public function show_brand_home(Request $request, $slug_brand)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();

        $brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Product_Slug', $slug_brand)->limit(1)->get();

        $brand_product_id =  DB::table('tbl_product')->join('tbl_brand_product', 'tbl_brand_product.Brand_ID', '=', 'tbl_product.Brand_ID')->where('tbl_brand_product.Brand_Product_Slug', $slug_brand)->get();

        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(5)->get();

        $add_content_to_title = " | Máy tính xách tay chính hãng, trả góp 0% - Eshopper";
        if (count($brand_product_id) == 0) {
            foreach ($brand_product as $key => $brand) {
                $title = $brand->Brand_Name . $add_content_to_title;
                $meta_description = $brand->Brand_Desc;
                $meta_keyword = $brand->Meta_Keywords_Brand;
                $meta_canonical = $request->url();
            }
        } else {
            foreach ($brand_product_id as $key => $brand) {
                $title = $brand->Brand_Name . $add_content_to_title;
                $meta_description = $brand->Brand_Desc;
                $meta_keyword = $brand->Meta_Keywords_Brand;
                $meta_canonical = $request->url();
            }
        }

        return view('pages.brand.show-brand-product')->with(compact('brand_product_id', 'all_category_product', 'all_brand_product', 'brand_product', 'title', 'meta_keyword', 'meta_canonical', 'meta_description', 'all_slide'));
    }
}