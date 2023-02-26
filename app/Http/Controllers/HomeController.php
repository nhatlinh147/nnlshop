<?php

namespace App\Http\Controllers;


use App\Model\BrandModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Model\Product;
use App\Model\SlideModel;
use App\Model\CategoryModel;
use App\Model\PostModel;
use App\Model\CatePostModel;
use App\Model\GalleryModel;
use App\Model\SpecialOfferModel;

use DB;

use Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $all_slide = SlideModel::where('Slide_Status', '1')->take(4)->get();
        $special_show = SpecialOfferModel::where('Special_Status', '1')->take(2)->get();
        $latest_product = Product::orderBy('created_at', 'DESC')->take(8)->get();

        $compare_view = Product::avg('Product_View');
        $compare_sold = Product::avg('Product_Sold');
        $filterPopularProduct = Product::where('Product_View', '>', $compare_view)
            ->where('Product_Sold', '>', $compare_sold)
            ->orderby('Product_Sold', 'DESC')
            ->take(8)
            ->get();

        return view('frontend.index.content-index')->with(compact(
            'all_slide',
            'special_show',
            'latest_product',
            'filterPopularProduct'
        ));
    }
    public function search_product(Request $request)
    {
        $data = $request->all();
        $product = Product::where('Product_Name', 'LIKE', "%{$request->input('query')}%")->get();
        return response()->json($product);
    }
}