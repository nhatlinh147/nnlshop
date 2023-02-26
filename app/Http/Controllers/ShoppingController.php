<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Model\Product;
use App\Model\PropProductModel;
use App\Model\CategoryModel;
use App\Support\GetIdBy;

class ShoppingController extends Controller
{
    function getArrayProductId($array_color, $key_query)
    {
        $getById = new GetIdBy($array_color, $key_query);
        return $getById->getIdBySize();
    }
    // Kiểm tra xem có danh mục con sau đó tiến hành lấy lênh truy vấn danh mục theo id
    function checkChildGetCate($data_have_child, $data_category, $query)
    {
        $get_id = CategoryModel::where('Category_Product_Slug', $data_category)->first()->id;
        if ($data_have_child == 'false') {
            // Nếu không có thì query danh mục theo id như bình thường
            $query = $query->where('Category_ID', $get_id);
        } else {
            // Nếu có thì query danh mục theo các id con của nó
            $get_id = CategoryModel::where('Category_Parent', $get_id)->pluck('id');
            $query = $query->whereIn('Category_ID', $get_id);
        }
        return $query;
    }

    // Kiểm tra xem có danh mục con sau đó tiến hành lấy lênh truy vấn danh mục theo id
    function paginateByIndex($data_paginate, $query)
    {
        if ($data_paginate == 10) {
            $query = $query->paginate(10);
        } else if ($data_paginate == 15) {
            $query = $query->paginate(15);
        } else if ($data_paginate == 20) {
            $query = $query->paginate(20);
        }
        return $query;
    }

    //Hiển thị sản phẩm dựa trên filter
    public function show_product(Request $request)
    {
        $data = $request->all();
        if (isset($data['filter'])) {
            if ($data['filter'] == 'latest') {
                $query = Product::orderBy('created_at', 'DESC');
            } else if ($data['filter'] == 'sell_well') {
                $query = Product::orderby('Product_Sold', 'DESC');
            } else if ($data['filter'] == 'view') {
                $query = Product::orderBy('Product_View', 'DESC');
            } else if ($data['filter'] == 'price_asc') {
                $query = Product::orderBy('Product_Price', 'ASC');
            } else if ($data['filter'] == 'price_desc') {
                $query = Product::orderBy('Product_Price', 'DESC');
            }
        } else {
            // query load ban đầu
            $query = Product::orderBy('created_at', 'DESC');
        }

        //Lưu ý do có 2 trường hợp paginate khác nhau nên cần
        // truyền biến get qua ajax
        if (!$request->ajax()) {
            //Load dữ liệu ban đầu khi lọc theo danh sách
            if (isset($_GET['have_child'])) {
                $show_product = $this->checkChildGetCate($_GET['have_child'], $_GET['category'], $query);
            } else if (!empty($_GET['Search_Product'])) {
                $show_product = $query->where('Product_Name', 'LIKE', "%{$_GET['Search_Product']}%");
            }
            // Trường hợp web mới được bật
            $show_product = $query->paginate(10);
        } else {
            //Lọc theo danh sách sản phẩm
            if (!empty($data['have_child'])) {
                $show_product = $this->checkChildGetCate($data['have_child'], $data['category'], $query);
            } else if (!empty($data['Search_Product'])) {
                $show_product = $query->where('Product_Name', 'LIKE', "%{$data['Search_Product']}%");
            }

            //Lọc theo giá trị lớn nhất và nhỏ nhất
            if (isset($data['array_min'])) {
                $array_min = $data['array_min'];
                $array_max = $data['array_max'];
                $query_other = Product::orderby('Product_Price', 'DESC');
                for ($i = 0; $i < count($array_min); $i++) {
                    $get_id_product = $query_other->orWhereBetween('Product_Price', [$array_min[$i], $array_max[$i]])->get();
                }
                $show_product = $query->whereIn('Product_ID', $get_id_product->pluck('Product_ID'));
            }

            //Lọc theo màu
            if (isset($data['colors'])) {
                $colors = $data['colors'];
                $show_product = $query->whereIn('Product_ID', $this->getArrayProductId($colors, 'Prop_Color'));
            }

            //Lọc theo kích thước
            if (isset($data['sizes'])) {
                $sizes = $data['sizes'];
                $show_product = $query->whereIn('Product_ID', $this->getArrayProductId($sizes, 'Prop_Size'));
            }

            // sau khi filter left thì cần paginate lại vì show_product lúc này chỉ mới lấy dữ liệu thông qua câu lệnh truy vấn
            //Paginate trước chỉ là của load dữ liệu ban đầu thôi
            // Paginate trong ajax lúc này chưa được thành lập nên cần paginate lại
            //Paginate lại show product
            if (isset($data['paginate'])) {
                $show_product = $this->paginateByIndex($data['paginate'], $query);
            }
            $index = $show_product->pluck('Product_ID')->count();
            return view('frontend.shop.show', compact('show_product', 'index'));
        }
        $index = $show_product->pluck('Product_ID')->count();
        return view('frontend.shop.shop-list-product')->with(compact('show_product', 'index'));
    }
    public function filter_price()
    {
        $show_product = Product::orderBy('created_at', 'DESC')->paginate(18);
        return response()->json();
    }

    //Lấy những phần tử con phụ thuộc vào phần tử cha
    function get_child($parent)
    {
        $child = CategoryModel::where('Category_Parent', $parent)->get()->toArray();
        $array = array_column($child, 'id');
        return $array;
    }
    public function show_detail_product(Request $request, $product_slug)
    {
        $show_product = Product::where('Product_Slug', $product_slug)->first();
        $child = $this->get_child($show_product->Category_ID);
        if (empty($child)) {
            $related_product = Product::where('Category_ID', $show_product->Category_ID)->take(8)->get();
        } else {
            $related_product = Product::whereIn('Category_ID', $child)->take(8)->get();
        }
        return view('frontend.detail.detail')->with(compact('show_product', 'related_product'));
    }
}