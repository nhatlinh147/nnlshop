<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Model\CarouselModel;
use App\Model\CatePostModel;
use App\Model\GalleryModel;
use Illuminate\Support\Facades\Session;
use Auth;

use Illuminate\Support\Str;
use App\Model\CategoryModel;
use App\Model\BrandModel;
use App\Model\Product;
use App\Model\RatingModel;
use Carbon\Carbon;
use App\Jobs\ControllerQueueJob;
use App\Jobs\QueueJob;
use App\Repository\GalleryInterface;

use Illuminate\Support\Facades\Storage;
use File;
use Event;


class ProductController extends Controller
{
    public function add_product()
    {

        // $category_level_one = CategoryModel::orderby('id', 'desc')->get();
        $all_category_product = DB::table('tbl_category_product')->whereIn('Category_Parent', [0])->orderby('id', 'desc')->get();
        $all_brand_product = DB::table('tbl_brand_product')->orderby('Brand_ID', 'desc')->get();
        return view('backend.product.add-product')->with(compact('all_category_product', 'all_brand_product'));
    }
    public function all_product()
    {
        $all_category_product = DB::table('tbl_category_product')->whereIn('Category_Parent', [0])->orderby('id', 'desc')->get();
        $all_product = Product::join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->get();
        return view('backend.product.all-product')->with(compact('all_product', 'all_category_product'));
    }
    public function save_product(request $request)
    {
        $data = $request->all();

        // $first_product = Product::where('Product_Image', $data['product_id'])->first();

        $request_document =  $request->file('product_document');
        $request_image =  $request->file('product_image');

        $path_product = 'public/upload/product/';
        $path_gallery = 'public/upload/gallery/';
        //Thiết lập tên, địa chỉ lưu ảnh và tài liệu
        if ($request_document) {
            $productDocument = current(explode('.', $request_document->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_document->getClientOriginalExtension();
            $request_document->move('public/upload/document/', $productDocument);
        } else {
            $productDocument = "Không";
        }
        if ($request_image) {
            $productImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();
            $request_image->move($path_product, $productImage);
        } else {
            $productImage = Product::where('Product_ID', $data['product_id'])->first()->Product_Image;
        }

        $productId = $data['product_id'];
        $product  =   Product::updateOrCreate(
            ['Product_ID' => $productId],
            [
                'Product_Name' => $data['product_name'],
                'Category_ID' => $data['category_product_name'],
                'Product_Content' => $data['product_content'],
                'Meta_Keywords_Product' => $data['meta_keywords_product'],
                'Product_Summary' => $data['product_summary'],
                'Product_Desc' => $data['product_desc'],
                'Product_Quantity' => filter_var($data['product_quantity'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Price' => filter_var($data['product_price'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Cost' => filter_var($data['product_cost'], FILTER_SANITIZE_NUMBER_INT),
                'Product_Status' => $data['product_status'],
                'Product_Slug' => $data['product_slug'],
                'Product_Tag' => $data['product_tag'],
                'Product_Document' => $productDocument,
                'Product_Image' => $productImage,
                'Product_View' => 0,
                'Product_Path' => "Tạm thời"
            ]
        );
        // Không nên để so sánh với $data['product_id] vì create thì không có id
        $first_product = Product::where('Product_Image', $productImage)->first();

        //Dành cho trường hợp edit và store
        //Xóa ảnh cũ để thay vào ảnh mới
        if ($request_image) {
            //sao chép ảnh một product sang gallery đồng thời lưu dữ liệu ảnh product này tại gallery
            // File::copy($path_product . $productImage, $path_gallery . $productImage);
            // $gallery = new GalleryModel();
            // $gallery->Gallery_Image = $productImage;
            // $gallery->Gallery_Name = $productImage;
            // $gallery->Product_ID = $first_product->Product_ID;
            // $gallery->save();

            //Xóa đi ảnh trước đó
            if ($data['get_image']) {
                unlink($path_product . $data['get_image']);
                // unlink($path_gallery . $data['get_image']);
            }
        }

        if (pathinfo($data['get_document'], PATHINFO_EXTENSION) == 'pdf') {
            unlink('public/upload/document/' . $data['get_document']);
        } else {
            $detail_one = [
                "controller" => "delete_product_document",
                "get_document" => $data['get_document']
            ];
            dispatch(new ControllerQueueJob($detail_one));
        }

        //Upload product_document lên gooogle drive theo đuôi mở rộng của product_document
        if ($first_product->Product_Document != "Không") {
            $path_document = 'public/upload/document/';
            if ($request_document->getClientOriginalExtension() == 'pdf') {
                $product = Product::updateOrCreate(['Product_ID' => $first_product->Product_ID], ['Product_Path' => "No Path Drive"]);
            } else {
                $filePath = public_path('upload/document/' . $productDocument);
                $fileData = File::get($filePath);
                $details = [
                    "controller" => "savedrive",
                    "setNameDocument" => $productDocument,
                    "fileData" => json_encode($fileData)
                ];

                dispatch(new ControllerQueueJob($details));
                $product = Product::updateOrCreate(['Product_ID' => $first_product->Product_ID], ['Product_Path' => "Path Drive"]);

                // xóa đi dữ liệu lưu trong path_document vì dữ liệu đã được lưu trên google drive
                unlink($path_document . $productDocument);
            }
        } else {
            $product = Product::updateOrCreate(['Product_ID' => $first_product->Product_ID], ['Product_Path' => "No Path Drive"]);
        }

        //Đổi dữ liệu Product_Path thành path google drive
        $detail = [
            "controller" => "doiPath",
            "product_id" => $first_product->Product_ID
        ];
        dispatch(new ControllerQueueJob($detail));

        $get_product = DB::table('tbl_product')->get();
        return response()->json($product);
    }

    public function all_product_data_table(Request $request)
    {

        $info = [
            'data' => [],
        ];

        $product = Product::join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->get();
        $info['data'] = $product;

        return $info;
    }

    public function get_path(Request $request)
    {
        $data = $request->all();
        foreach ($data['product_id'] as $id) {
            $product = Product::where('Product_ID', $id)->first();
            $get_path[] = collect(Storage::cloud()->listContents('/', false))
                ->where('type', '!=', 'dir')->where('name', $product->Product_Document)->first()['path'];
        }
        return response()->json(['get_path' => $get_path, 'product_id' => $data['product_id']]);
    }

    public function edit_product($product_id)
    {
        $where = array('Product_ID' => $product_id);
        $product  = Product::where($where)->first();
        return response()->json($product);
    }

    public function delete_product_selected(Request $request)
    {
        $data = $request->ajax();
        $get_pro = Product::whereIn('Product_ID', $request->ids)->get();

        foreach ($get_pro as $value) {
            //Phân loại điều kiện pdf,doc và không
            if ($value->Product_Document != "Không") {

                if (pathinfo($value->Product_Document, PATHINFO_EXTENSION) == 'pdf') {
                    unlink('public/upload/document/' . $value->Product_Document);
                } else {
                    $details = [
                        "controller" => "delete_product_document",
                        "get_document" => $value->Product_Document
                    ];
                    dispatch(new ControllerQueueJob($details));
                }
            }

            //Xóa ảnh sản phẩm
            unlink('public/upload/product/' . $value->Product_Image);
        }

        $get_gallery = GalleryModel::whereIn('Product_ID', $request->ids)->get();
        foreach ($get_gallery as $value) {
            //Xóa gallery sản phẩm
            unlink('public/upload/gallery/' . $value->Gallery_Image);
        }

        $gallery = GalleryModel::whereIn('Product_ID', $request->ids)->delete();

        $product = Product::whereIn('Product_ID', $request->ids)->delete();


        return response()->json($product);
    }
    public function delete_product_document(request $request) //Xóa file khi click vào button
    {
        $path_document = 'public/upload/document/';
        $data = $request->all();
        $product = Product::find($data['product_document_id']);
        unlink($path_document . $product->Product_Document);
        // Cập nhật lại tên Product_Document.
        $product->Product_Document = '';
        $product->save();
    }

    public function delete_product(request $request, $product_id)
    {
        DB::table('tbl_product')->where('Product_ID', $product_id)->delete();
        Session::flash('message', 'Xóa sản phẩm thành công');
        return redirect::to('/all-product');
    }
    public function details_product(Request $request, $slug_product)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();
        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(4)->get();
        $all_product = DB::table('tbl_product')->where('Product_Status', '1')->get();

        $all_cate_post = CatePostModel::where('Cate_Post_Status', 1)->get();

        //lấy danh mục và thương hiệu con
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();
        $brand_child = BrandModel::whereNotIn('Brand_Parent', [0])->get();

        $product_details =  DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->join('tbl_brand_product', 'tbl_brand_product.Brand_ID', '=', 'tbl_product.Brand_ID')->where('tbl_product.Product_Slug', $slug_product)->get();
        foreach ($product_details as $key => $value) {
            $category_id = $value->Category_ID;
            $product_id = $value->Product_ID;
        }

        //Lưu số lượng view vào database
        $get_product = Product::findOrFail($product_id);
        Event::dispatch('pages.sanpham.show-details', $get_product);

        // lấy hình ảnh tương thích cho từng sản phẩm theo id của sản phẩm đó
        $all_gallery = GalleryModel::where('Product_ID', $product_id)->get();

        //Lấy số liệu đánh số sao
        $all_rating_star = round(RatingModel::where('Rating_Product_ID', $product_id)->avg('Rating_Star'));
        $related_product  =  DB::table('tbl_product')->join('tbl_category_product', 'tbl_category_product.id', '=', 'tbl_product.Category_ID')->where('tbl_category_product.id', $category_id)->join('tbl_brand_product', 'tbl_brand_product.Brand_ID', '=', 'tbl_product.Brand_ID')->whereNotIn('tbl_product.Product_Slug', [$slug_product])->get();
        $add_content_to_title = " | Máy tính xách tay chính hãng, trả góp 0% - Eshopper";
        foreach ($product_details as $key => $product) {
            $title = $product->Product_Name . $add_content_to_title;
            $meta_description = $product->Product_Desc;
            $meta_keyword = $product->Meta_Keywords_Product;
            $meta_canonical = $request->url();
            $meta_image = url('public/upload/' . $product->Product_Image);
        }
        return view('pages.sanpham.show-details')->with(compact('all_category_product', 'all_brand_product', 'product_details', 'related_product', 'title', 'meta_keyword', 'meta_canonical', 'meta_description', 'meta_image', 'all_slide', 'category_child', 'brand_child', 'all_product', 'all_cate_post', 'all_gallery', 'all_rating_star'));
    }
    public function product_tag(Request $request, $tag_product, $slug, $order)
    {
        $all_category_product = DB::table('tbl_category_product')->where('tbl_category_product.Category_Status', '1')->get();
        $all_brand_product = DB::table('tbl_brand_product')->where('tbl_brand_product.Brand_Status', '1')->get();
        $all_slide = CarouselModel::where('Carousel_Status', '2')->take(4)->get();
        $all_product = DB::table('tbl_product')->where('Product_Status', '1')->get();

        $all_cate_post = CatePostModel::where('Cate_Post_Status', 1)->get();

        //lấy danh mục và thương hiệu con
        $category_child = CategoryModel::whereNotIn('Category_Parent', [0])->get();
        $brand_child = BrandModel::whereNotIn('Brand_Parent', [0])->get();

        $get_product_slug = Product::where('Product_Status', '1')->where('Product_Slug', $slug)->first();
        $get_tag_product = explode(",", $get_product_slug->Product_Tag);
        $i = 0;
        foreach ($get_tag_product as $key => $tag) {
            if (Str::slug($tag) == $tag_product && $key == $order) {
                $get_tag = $tag;
            }
        }

        $tag = str_replace("-", " ", $tag_product);
        $product_tag = Product::where('Product_Status', 1)->where('Product_Name', 'LIKE', '%' . $tag . '%')
            ->orWhere('Product_Tag', 'LIKE', '%' . $tag . '%')
            ->orWhere('Meta_Keywords_Product', 'LIKE', '%' . $tag . '%')
            ->get();

        $add_content_to_title = "Tag tìm kiếm: ";

        foreach ($product_tag as $key => $product) {
            $title =  $add_content_to_title . $get_tag;
            $meta_description = $product->Product_Desc;
            $meta_keyword = $product->Meta_Keywords_Product;
            $meta_canonical = $request->url();
        }
        return view('pages.sanpham.tag')->with(compact('all_category_product', 'all_brand_product', 'title', 'meta_keyword', 'meta_canonical', 'meta_description', 'all_slide', 'category_child', 'brand_child', 'all_product', 'all_cate_post', 'product_tag'));
    }
    public function quick_view_ajax(Request $request)
    {
        $data = $request->all();
        $product = Product::find($request->product_id);
        $gallery = GalleryModel::where('Product_ID', $request->product_id)->get();
        $output['quick_view_title'] = $product->Product_Name;
        $item = '';
        foreach ($gallery as $value) {
            $item .= '<p><img width="100%" src="' . asset('public/storage/images/' . $value->Gallery_Image) . '"></p>';
        }
        $output['quick_view_body'] = '
                <div class="row">
                    <div class="col-md-5">
                    <p><img width="100%" src="' . asset('public/storage/images/' . $product->Product_Image) . '"></p>
                            ' . $item . '
                    </div>
                    <div class="col-md-7">
                        <form>
                            ' . csrf_field() . '
                            <input type="hidden" value="' . $product->Product_ID . '" class="getId_' . $product->Product_ID . '"/>
                            <input type="hidden" value="' . $product->Product_Name . '" class="getName_' . $product->Product_ID . '"/>
                            <input type="hidden" value="' . $product->Product_Price . '" class="getPrice_' . $product->Product_ID . '"/>
                            <input type="hidden" value="' . $product->Product_Image . '" class="getImage_' . $product->Product_ID . '"/>
                            <input type="hidden" value="' . $product->Product_Quantity . '" class="getQuantity_' . $product->Product_ID . '"/>
                            <input type="hidden" value="1" class="getQty_' . $product->Product_ID . '"/>

                            <img src="{{asset("public/storage/images/' . $product->Product_Image . '")}}" height="225px" alt="" />
                            <h2>' . $product->Product_Name . '</h2>
                            <p>Mã ID: ' . $product->Product_ID . '</p>
                            <p><b>Giá sản phẩm: </b>' . number_format($product->Product_Price) . ' ₫</p>
                            <p><b>Tình trạng: </b> Còn hàng</p>
                            <p><b>Điều kiện: </b> Mới 100%</p>
                            <p><b>Thương hiệu: </b> ' . $product->brand->Brand_Name . '</p>
                            <p><b>Danh mục: </b>' . $product->category->Category_Name . '</p>

                            <button type="button" class="btn btn-default quick_and_add add-to-cart" data-get-id-product="' . $product->Product_ID . '"><i class="fa fa-shopping-cart"></i>Giỏ hàng</button>

                            <h4 style="font-size: 20px; color: brown;font-weight: bold;">Mô tả sản phẩm</h4>
                            ' . $product->Product_Desc . '
                            <h4 style="font-size: 20px; color: brown;font-weight: bold;">Chi tiết sản phẩm</h4>
                            ' . $product->Product_Content . '
                        </form>
                    </div>
            </div>
        ';
        echo json_encode($output);
    }
    public function save_rating(Request $request)
    {
        $data = $request->all();
        $rating = new RatingModel();
        $rating->Rating_Product_ID = $data['product_id'];
        $rating->Rating_Star = $data['count_star'];
        $rating->save();
        echo 'done';
    }
    public function upload_local_image(Request $request)
    {
        if ($request->hasFile('upload')) {

            // $originName = $request->file('upload')->getClientOriginalName();
            // $fileName = pathinfo($originName, PATHINFO_FILENAME);
            // $extension = $request->file('upload')->getClientOriginalExtension();
            // $fileName = $fileName . '_' . time() . '.' . $extension;
            // $request->file('upload')->move('public/uploads/ckeditor', $fileName);
            $setNameImage = pathinfo($request->file('upload')->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $request->file('upload')->getClientOriginalExtension();
            $request->file('upload')->move('public/upload/ckeditor', $setNameImage);

            // thiết lập đường dẫn chuẩn SEO
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/upload/ckeditor/' . $setNameImage);
            $msg = 'Tải ảnh thành công';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function file_browser(Request $request)
    {
        $paths = glob(public_path('upload/ckeditor/*')); //  tìm kiếm tất cả các đường dẫn phù hợp với partern truyền vào

        $getFile = array();

        foreach ($paths as $path) {
            array_push($getFile, basename($path)); // đẩy từng ảnh vào
        }
        $data = array(
            'fileNames' => $getFile // tạo nên mảng với các phần tử là ảnh được tải lên
        );

        return view('admin.ckeditor-images.file-browser')->with($data);
    }
}