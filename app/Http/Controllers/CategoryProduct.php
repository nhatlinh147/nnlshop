<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Model\CarouselModel;
use App\Model\CategoryModel;
use App\Model\Product;
use Auth;
use DB;
use Session;
use App\Model\CatePostModel;
use App\Support\ResizeImage;

class CategoryProduct extends Controller
{

    public function add_category_product(Request $request)
    {
        // $this->authLogin();
        $getCateParent = CategoryModel::where('Category_Parent', 0)->orderBy('id', 'DESC')->get();
        return view('backend.category.add-category')->with(compact('getCateParent'));
    }
    public function all_category_product(Request $request)
    {
        $all_category_product = CategoryModel::all();

        $category_parent = CategoryModel::where('Category_Parent', 0)->orderBy('id', 'DESC')->get();
        return view('backend.category.all-category')->with(compact('all_category_product', 'category_parent'));
    }
    public function all_cate_pro_json()
    {
        $info = [
            'data' => [],
        ];
        $all_category_product = CategoryModel::all();
        $info['data'] = $all_category_product;

        return $info;
    }
    public function save_category_product(request $request)
    {
        $data = $request->all();
        $cateId = $data['cate_pro_id'];
        $request_image =  $request->file('category_image');

        $path_category = 'public/upload/cate_pro/';

        if ($request_image) {
            $categoryImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();
            $request_image->move($path_category, $categoryImage);

            $resizeObj = new ResizeImage($path_category . $categoryImage);
            $resizeObj->resizeImage(150, 150, 'auto');
            $resizeObj->saveImage($path_category . $categoryImage, 100);
        } else {
            $categoryImage = CategoryModel::find($cateId)->Category_Image;
        }

        $cate_product  =   CategoryModel::updateOrCreate(
            ['id' => $cateId],
            [
                'Category_Name' => $data['category_product_name'],
                'Category_Desc' => $data['category_product_desc'],
                'Category_Parent' => $data["category_parent"],
                'Meta_Keywords_Category' => $data['meta_keywords_category'],
                'Category_Product_Slug' => $data['category_product_slug'],
                'Category_Image' => $categoryImage,
                'Category_Status' => $data["category_status"]
            ]
        );

        if ($data['before_image'] && $request_image) {
            unlink($path_category . $data['before_image']);
        }
        return response()->json($cate_product);
    }
    public function edit_category_product($cate_pro_id)
    {
        $where = array('id' => $cate_pro_id);
        $cate_pro  = CategoryModel::where($where)->first();


        $category_have_child = CategoryModel::groupBy('Category_Parent')
            ->having('Category_Parent', '!=', 0)
            ->get();
        $array_have_child = array_column($category_have_child->toArray(), 'Category_Parent');

        // đề phòng trường hợp xuất hiện mảng lồng (kiểu như danh mục cha (có danh mục con) lại là con của danh mục cha khác)
        if (!in_array($cate_pro->id, $array_have_child)) {
            $array_have_child = [0];
        }

        $category_parent = CategoryModel::where('Category_Parent', 0)
            ->whereNotIn('id', [$cate_pro_id])
            ->whereNotIn('id', $array_have_child)
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json(['cate_pro' => $cate_pro, 'category_parent' => $category_parent]);
    }

    public function delete_category_product(request $request, $cate_pro_id)
    {
        $categoryImage = CategoryModel::find($cate_pro_id);
        unlink('public/upload/cate_pro/' . $categoryImage->Category_Image);
        $cate_pro = CategoryModel::where('id', $cate_pro_id)->delete();

        Session::flash('message', 'Xóa danh danh mục sản phẩm thành công');
        return response()->json($cate_pro);
    }
    // show product portfolio out layout.blade.php
    public function show_category_home(Request $request, $slug_category)
    {
        //lấy danh mục bài viết
        $all_cate_post = CatePostModel::where('Cate_Post_Status', 1)->orderBy('Cate_Post_ID', 'DESC')->get();

        // lấy danh mục con trong toàn bộ danh mục sản phẩm
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();

        //Lấy toàn bộ sản phẩm
        $all_product = Product::where('Product_Status', '1')->get();

        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();
        $category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Product_Slug', $slug_category)->limit(1)->get();

        if (isset($_GET['sort_by'])) {
            $category_id = $_GET['id'];
            $sort_by = $_GET['sort_by'];

            if ($sort_by == 'giam_dan') {
                $category_by_id = Product::with('category')->where('Category_ID', $category_id)->orderBy('Product_Price', 'DESC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'tang_dan') {
                $category_by_id = Product::with('category')->where('Category_ID', $category_id)->orderBy('Product_Price', 'ASC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'kytu_za') {
                $category_by_id = Product::with('category')->where('Category_ID', $category_id)->orderBy('Product_Name', 'DESC')->paginate(6)->appends(request()->query());
            } elseif ($sort_by == 'kytu_az') {
                $category_by_id = Product::with('category')->where('Category_ID', $category_id)->orderBy('Product_Name', 'ASC')->paginate(6)->appends(request()->query());
            }
        } elseif (isset($_GET['begin_price']) && $_GET['end_price']) {

            $min_price = $_GET['begin_price'];
            $max_price = $_GET['end_price'];

            $category_product_id = Product::whereBetween('Product_Price', [$min_price, $max_price])
                ->orderBy('Product_Price', 'ASC')->paginate(6)
                ->appends(request()->query());
        } else {
            $category_product_id = DB::table('tbl_product')
                ->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')
                ->where('tbl_category_product.Category_Product_Slug', $slug_category)->paginate(6);
        }


        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(5)->get();

        // $category_product_id =  DB::table('tbl_product')
        //     ->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')
        //     ->where('tbl_category_product.Category_Product_Slug', $slug_category)->get();
        $add_content_to_title = " | Máy tính xách tay chính hãng, trả góp 0% - Eshopper";
        if (count($category_product_id) == 0) {
            foreach ($category_product as $key => $category) {
                $title = $category->Category_Name . $add_content_to_title;
                $meta_description = $category->Category_Desc;
                $meta_keyword = $category->Meta_Keywords_Category;
                $meta_canonical = $request->url();
            }
        } else {
            foreach ($category_product_id as $key => $category) {
                $title = $category->Category_Name;
                $meta_description = $category->Category_Desc;
                $meta_keyword = $category->Meta_Keywords_Category;
                $meta_canonical = $request->url();
            }
        }
        return view('pages.category.show-category-product')->with(compact(
            'category_product_id',
            'all_category_product',
            'all_brand_product',
            'category_product',
            'title',
            'meta_keyword',
            'meta_canonical',
            'meta_description',
            'all_slide',
            'category_child',
            'all_cate_post',
            'all_product',
        ));
    }
    public function sort_category(Request $request)
    {
        $this->authLogin();
        $data = $request->all();
        $category_id_array = $data["category_id_array"];
        $category_id = CategoryModel::select('Category_Order')->get();
        // foreach ($category_id as $key => $value) {
        //     array_search($value, $data["category_id_array"]);
        // }
        $i = 0;
        foreach ($category_id_array as $key => $value) {
            $i++;
            $category = CategoryModel::find($value);
            $category->Category_Order = $i;
            $category->save();
        }
        echo 'Updated';
    }
    public function category_tabs(Request $request)
    {

        $data = $request->all();

        $output = '';

        //lấy bảng ghi dựa trên sự so sánh giữa Category_Parent và id được lấy từ các Category_Parent
        $subcategory = CategoryModel::where('Category_Parent', $data['cate_tab_id'])->get();

        // lấy id của các category con
        $sub_cate_array = array();
        foreach ($subcategory as $key => $sub) {
            $sub_cate_array[] = $sub->id;
        }
        // array_push($sub_cate_array, $data['cate_tab_id']);
        // print_r($sub_cate_array);

        $product = Product::whereIn('Category_ID', $sub_cate_array)->orderBy('Product_ID', 'DESC')->get();

        $product_count = $product->count();

        if ($product_count > 0) {

            $output .= ' <div class="tab-content">
                <div class="tab-pane fade active in" id="tshirt" >
            ';
            foreach ($product as $key => $val) {
                $output .= '
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <form>
                                        ' . csrf_field() . '
                                        <input type="hidden" value="' . $val->Product_ID . '" class="getId_' . $val->Product_ID . '"/>
                                        <input type="hidden" value="' . $val->Product_Name . '" class="getName_' . $val->Product_ID . '" id="wishlist_name_' . $val->Product_ID . '"/>
                                        <input type="hidden" value="' . $val->Product_Price . '" class="getPrice_' . $val->Product_ID . '" id="wishlist_price_' . $val->Product_ID . '"/>
                                        <input type="hidden" value="' . $val->Product_Image . '" class="getImage_' . $val->Product_ID . '" />
                                        <input type="hidden" value="' . $val->Product_Quantity . '" class="getQuantity_' . $val->Product_ID . '"/>
                                        <input type="hidden" value="1" class="getQty_' . $val->Product_ID . '"/>
                                        <a href="' . url("/chi-tiet-san-pham/" . $val->Product_Slug) . '" id="wishlist_url_' . $val->Product_ID . '">
                                        <img src="' . url('public/storage/images/' . $val->Product_Image) . '" height="225px" alt="' . $val->Product_Name . '" id="wishlist_image_' . $val->Product_ID . '"/>
                                        <h2>' . number_format($val->Product_Price) . " ₫" . '</h2>
                                        <p>' . $val->Product_Name . '</p>
                                        </a>

                                        <button type="button" class="btn btn-default quick_and_add add-to-cart" data-get-id-product="' . $val->Product_ID . '"><i class="fa fa-shopping-cart"></i>Giỏ hàng</button>
                                        <button type="button" class="btn btn-default quick_and_add quick-view" data-get-id-product="' . $val->Product_ID . '" data-toggle="modal" data-target="#Quick_View"><i class="fa fa-bullseye"></i>Xem nhanh</button>
                                    </form>
                                </div>
                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li id="' . $val->Product_ID . '" onclick="product_wishlist(this.id)"><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- END Product Grid -->
                ';
            }

            $output .= '
                </div>
            </div>
            ';
        } else {
            $output .= ' <div class="tab-content">

           <div class="tab-pane fade active in" id="tshirt" >

           <div class="col-sm-12s">
           <p style="color:#b3afa8;text-align:center;font-weight: 1000;font-size:15pt;margin-bottom:30px">Hiện chưa có sản phẩm trong danh mục này</p>
           </div>

           </div>
           </div>

           ';
        }


        echo $output;
    }
    public function filter_by_category($id)
    {
        $all_category_product = DB::table('tbl_category_product')
            ->join('tbl_product', 'tbl_product.Category_ID', '=', 'tbl_category_product.id')
            ->select('tbl_category_product.Category_Product_Slug', 'tbl_category_product.Category_Parent', 'tbl_product.*')
            ->where('Product_Status', 1)
            ->where('Category_Status', 1)
            ->get();

        //lấy id có Category_Parent không giống bất kì phần tử nào trong các Category_Parent còn lại
        $sort_by_category =  DB::table('tbl_category_product')
            ->join('tbl_product', 'tbl_product.Category_ID', '=', 'tbl_category_product.id')
            ->select('tbl_category_product.Category_Product_Slug', 'tbl_category_product.Category_Parent', 'tbl_product.*')
            ->whereRaw('Category_Parent IN (' . $id . ')')
            ->orWhereRaw('id IN (' . $id . ')')
            ->get();

        // $sort_by_category = DB::table('tbl_category_product as category')
        //     ->selectRaw('(Select Product_Image from tbl_product where Category_ID = category.id) as cat_image,  (Select Product_Name from tbl_product where Category_ID = category.id) as cat_title')
        //     ->whereRaw('id IN (' . $id . ')')
        //     ->get();

        if ($id == 0) {
            foreach ($all_category_product as $val) {
                $category[] = array(
                    'product_id' => $val->Product_ID,
                    'product_name' => $val->Product_Name,
                    'product_desc' => $val->Product_Desc,
                    'product_content' => $val->Product_Content,
                    'product_price' => $val->Product_Price,
                    'product_image' => $val->Product_Image,
                    'category_product_slug' => $val->Category_Product_Slug,
                    'product_slug' => $val->Product_Slug,
                );
            }
        } else {
            foreach ($sort_by_category as $val) {
                $category[] = array(
                    'product_id' => $val->Product_ID,
                    'product_name' => $val->Product_Name,
                    'product_desc' => $val->Product_Desc,
                    'product_content' => $val->Product_Content,
                    'product_price' => $val->Product_Price,
                    'product_image' => $val->Product_Image,
                    'category_product_slug' => $val->Category_Product_Slug,
                    'product_slug' => $val->Product_Slug,
                    'product_quantity' => $val->Product_Quantity,
                );
            }
        }


        echo json_encode($category);
    }
}