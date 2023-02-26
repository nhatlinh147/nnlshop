<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use DB;
use App\Model\SpecialOfferModel;
use App\Model\SpecialProductModel;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Image;

class SpecialOfferController extends Controller
{
    public function combineSearchWithSort($query, $condition)
    {
        $products = 0;
        if ($condition == 1) {
            $products =  $query->orderby('Product_Name', 'ASC')->get();
        } else if ($condition == 2) {
            $products =  $query->orderby('Product_Name', 'DESC')->get();
        } else if ($condition == 3) {
            $products =  $query->orderby('Product_Price', 'ASC')->get();
        } else if ($condition == 4) {
            $products =  $query->orderby('Product_Price', 'DESC')->get();
        } else {
            $products =  $query->get();
        }
        return $products;
    }
    public function findByProductName($query)
    {
        return Product::where('Product_Name', $query)->first()->Product_ID;
    }
    public function findBySpecialTitle($query)
    {
        return SpecialOfferModel::where('Special_Title', $query)->first()->Special_ID;
    }

    public function add_special(Request $request)
    {
        return view('backend.special_offer.add-special-offer');
    }
    public function all_special(Request $request)
    {
        $all_special = SpecialOfferModel::all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');

        return view('backend.special_offer.all-special-offer')->with(compact('all_special', 'now'));
    }
    public function edit_special($special_id)
    {
        $edit_special = SpecialOfferModel::find($special_id);
        // $edit_special = SpecialOfferModel::where('Special_ID', $special_id)->first();
        return view('backend.special_offer.edit-special-offer')->with(compact('edit_special'));
    }

    public function update_special(Request $request, $special_id)
    {
        $data = $request->all();
        $image = SpecialOfferModel::find($special_id)->Special_Image;

        $specialImage = '';
        if (empty($data['special_image'])) {
            $specialImage = $image;
        } else {
            $request_image =  $request->file('special_image');
            $path_special = 'public/upload/special/';

            $specialImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();
            $img = Image::make($request_image->path());
            $img->resize(1000, 430, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path_special . $specialImage);

            unlink('public/upload/special/' . $image);
        }

        SpecialOfferModel::updateOrCreate(
            ['Special_ID' => $special_id],
            [
                'Special_Title' => $data['special_title'],
                'Special_Slug' => $data['special_slug'],
                'Special_Image' => $specialImage,
                'Special_Start' => $data['special_start'],
                'Special_End' => $data['special_end'],
            ]
        );
        return redirect::route('backend.all_special');
    }

    public function save_special(request $request)
    {
        $data = $request->all();

        $request_image =  $request->file('special_image');
        $path_special = 'public/upload/special/';

        $specialImage = current(explode('.', $request_image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' .  $request_image->getClientOriginalExtension();
        $img = Image::make($request_image->path());
        $img->resize(1000, 430, function ($constraint) {
            $constraint->aspectRatio();
        })->save($path_special . $specialImage);

        $special  =  SpecialOfferModel::updateOrCreate(
            [
                'Special_Title' => $data['special_title'],
                'Special_Slug' => $data['special_slug'],
                'Special_Image' => $specialImage,
                'Special_Product_Json' => $data['special_product_json'],
                'Special_Start' => $data['special_start'],
                'Special_End' => $data['special_end'],
                'Special_Status' => $data["special_status"]
            ]
        );

        $associative_array = json_decode($data['special_product_json'], true);

        if (count($associative_array['keyPercent']) > 0) {
            foreach ($associative_array["keyPercentChecked"] as $key1 => $check) {
                foreach ($associative_array["keyPercentPrice"] as $key2 => $price) {
                    if ($key1 == $key2) {
                        foreach (json_decode($check, true) as $product) {

                            SpecialProductModel::firstOrCreate(
                                [
                                    'Product_Name' => $product,
                                    'Product_ID' => $this->findByProductName($product),
                                    'Special_ID' => $this->findBySpecialTitle($data['special_title']),
                                    'Special_Product_Price' => $price,
                                    'Special_Product_Form' => 1
                                ]
                            );
                        }
                    }
                }
            }
        }

        if (count($associative_array['keyReduce']) > 0) {
            foreach ($associative_array["keyReduceChecked"] as $key1 => $check) {
                foreach ($associative_array["keyReducePrice"] as $key2 => $price) {
                    if ($key1 == $key2) {
                        foreach (json_decode($check, true) as $product) {
                            SpecialProductModel::firstOrCreate(
                                [
                                    'Product_Name' => $product,
                                    'Product_ID' => $this->findByProductName($product),
                                    'Special_ID' => $this->findBySpecialTitle($data['special_title']),
                                    'Special_Product_Price' => $price,
                                    'Special_Product_Form' => 2
                                ]
                            );
                        }
                    }
                }
            }
        }

        return redirect::route('backend.all_special');
    }

    public function search_product(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $arrayPercent = json_decode($data['getMediatePercent'], true);
            $arrayReduce = json_decode($data['getMediateReduce'], true);
            $output = 0;
            $output_one = 0;
            $output_two = 0;

            if ($data['getMediateReduce'] == 0) {
                $query = Product::Where('Product_Name', 'LIKE', '%' . $data['search'] . '%');
                $output = $this->combineSearchWithSort($query, $data['get_change']);
            } else {
                $query_one = DB::table('tbl_product')
                    ->Where('Product_Name', 'LIKE', '%' . $data['search'] . '%')
                    ->whereNotIn('Product_Name', $arrayPercent);

                $query_two = DB::table('tbl_product')
                    ->Where('Product_Name', 'LIKE', '%' . $data['search'] . '%')
                    ->whereNotIn('Product_Name', $arrayReduce);

                $output_one = $this->combineSearchWithSort($query_one, $data['get_change']);
                $output_two = $this->combineSearchWithSort($query_two, $data['get_change']);
            }
            return response()->json(['output' => $output, 'output_one' => $output_one, 'output_two' => $output_two]);
        }
    }
    public function all_product_special(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $arrayPercent = json_decode($data['getMediatePercent'], true);
            $arrayReduce = json_decode($data['getMediateReduce'], true);
            $output = 0;
            $output_one = 0;
            $output_two = 0;
            if ($data['getMediatePercent'] == 0 && $data['getMediateReduce'] == 0) {
                $output = Product::all();
            } else {
                $output_one = DB::table('tbl_product')
                    // ->whereRaw('Product_Name NOT IN (' . $data['array_checked'] . ')')
                    ->whereNotIn('Product_Name', $arrayPercent)
                    ->get();
                $output_two = DB::table('tbl_product')
                    // ->whereRaw('Product_Name NOT IN (' . $data['array_checked'] . ')')
                    ->whereNotIn('Product_Name', $arrayReduce)
                    ->get();
            }
        }
        return response()->json(['output' => $output, 'output_one' => $output_one, 'output_two' => $output_two]);
    }
    public function show_after_exclusion(Request $request)
    {
        $data = $request->all();
        if (empty($data['array_checked'])) {
            $data['array_checked'] = [];
        }
        $show =  DB::table('tbl_product')
            // ->whereRaw('Product_Name NOT IN (' . $data['array_checked'] . ')')
            ->whereNotIn('Product_Slug', $data['array_checked'])
            ->get();
        return json_encode($show);
    }

    public function special_list_checked(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $associative_array = json_decode($data['jsonStr'], true);
            $head = '';
            $open = '
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giảm giá</th>
                        </tr>
                    </thead>
                    <tbody>
    	    ';
            $close = '
                    </tbody>
                </table>
            ';

            $output_one = '';
            $output_two = '';

            if (count($associative_array['keyPercent']) > 0) {
                $head = '<h4 class="Reduce_Style">Giảm theo phần trăm</h4>';
                $content_percent = '';
                $i = 0;
                foreach ($associative_array["keyPercentChecked"] as $key1 => $check) {
                    foreach ($associative_array["keyPercentPrice"] as $key2 => $price) {
                        if ($key1 == $key2) {
                            foreach (json_decode($check, true) as $product) {
                                $i++;
                                $content_percent .= '
                                    <tr>
                                        <td>' . $product . '</td>
                                        <td>' . $price . ' %' . '</td>
                                    <tr>
                            ';
                            }
                        }
                    }
                }
                $output_one = $head . $open . $content_percent . $close;
            }
            if (count($associative_array['keyReduce']) > 0) {
                $head = '<h4 class="Reduce_Style">Giảm theo số tiền</h4>';
                $content_reduce = '';
                $j = 0;
                foreach ($associative_array["keyReduceChecked"] as $key1 => $check) {
                    foreach ($associative_array["keyReducePrice"] as $key2 => $price) {
                        if ($key1 == $key2) {
                            foreach (json_decode($check, true) as $product) {
                                $j++;
                                $content_reduce .= '
                                    <tr>
                                        <td>' . $product . '</td>
                                        <td>' . number_format($price, 0, ',', '.') . " đ" . '</td>
                                    <tr>
                                ';
                            }
                        }
                    }
                }
                $output_two = $head . $open . $content_reduce . $close;
            }
        }
        return response()->json(['output_one' => $output_one, 'output_two' => $output_two]);
    }

    public function all_special_list_checked(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $special = SpecialOfferModel::find($data['special_id']);
            $special_product = SpecialProductModel::where('Special_ID', $data['special_id'])->get();
            // $associative_array = json_decode($special->Special_Product_Json, true);
            $head = '';
            $open = '
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Sản phẩm</th>
                            <th>Giảm giá</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
    	    ';
            $close = '
                    </tbody>
                </table>
            ';

            $output_one = '';
            $output_two = '';

            $head = '';
            $content_percent = '';
            $content_reduce = '';
            $orderPercent = 0;
            $orderReduce = 0;

            foreach ($special_product as $key => $product) {
                if ($product->Special_Product_Form == 1) {
                    $orderPercent++;
                    $head = '<h4 class="Reduce_Style">Giảm theo phần trăm</h4>';
                    $content_percent .= '
                                    <tr>
                                        <td>' . $orderPercent . '</td>
                                        <td>' . $product->Product_Name . '</td>
                                        <td contenteditable="true" class="editTablePrice" id="' . $product->Special_Product_ID . '__' . $product->Special_ID . '__' . $product->Special_Product_Form . '" data-price="' . $product->Special_Product_Price . '">' . $product->Special_Product_Price . ' %' . '</td>
                                        <td><a href="javascript:void(0)" class="btn btn-danger btn-xs deleteSpecialProduct" id="' . $product->Special_Product_ID . '=' . $product->Special_ID . '">Xóa</a></td>
                                    <tr>
                            ';
                }
            }
            $output_one = $orderPercent > 0 ? $head . $open . $content_percent . $close : '';

            foreach ($special_product as $key => $product) {
                if ($product->Special_Product_Form == 2) {
                    $orderReduce++;
                    $head = '<h4 class="Reduce_Style">Giảm theo tiền</h4>';
                    $content_reduce .= '
                                <tr>
                                    <td>' . $orderReduce . '</td>
                                    <td>' . $product->Product_Name . '</td>
                                    <td contenteditable="true" class="editTablePrice" id="' . $product->Special_Product_ID . '__' . $product->Special_ID . '__' . $product->Special_Product_Form . '" data-price="' . $product->Special_Product_Price . '">' . number_format($product->Special_Product_Price, 0, ',', '.') . " đ" . '</td>
                                    <td><a href="javascript:void(0)" class="btn btn-danger btn-xs deleteSpecialProduct" id="' . $product->Special_Product_ID . '=' . $product->Special_ID . '">Xóa</a></td>
                                <tr>
                        ';
                }
            }
            $output_two = $orderReduce > 0 ? $head . $open . $content_reduce . $close : '';
        }
        return response()->json(['output_one' => $output_one, 'output_two' => $output_two, 'special_title' => $special->Special_Title]);
    }
    public function delete_special_product(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $special = SpecialProductModel::where('Special_Product_ID', $data['speProId'])->delete();
        }
        return  response()->json($special);
    }
    public function delete_special(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $special = SpecialOfferModel::find($data['special_id']);
            unlink('public/upload/special/' . $special->Special_Image);

            SpecialProductModel::where('Special_ID', $data['special_id'])->delete();
            SpecialOfferModel::where('Special_ID', $data['special_id'])->delete();
        }
    }
    public function special_product_change_price(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $special = SpecialProductModel::updateOrCreate(
                ['Special_Product_ID' => $data['speProId']],
                [
                    'Special_Product_Price' => $data['contentedit']
                ]
            );
        }
    }
    // public function sort_by(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = $request->all();

    //         $arrayPercent = json_decode($data['getMediatePercent'], true);
    //         $arrayReduce = json_decode($data['getMediateReduce'], true);
    //         $output = 0;
    //         $output_one = 0;
    //         $output_two = 0;

    //         if ($data['getMediateReduce'] == 0) {
    //             $query = DB::table('tbl_product');
    //             $output = $this->combineSearchWithSort($query, $data['get_change']);
    //         } else {
    //             $query_one = DB::table('tbl_product')
    //                 ->whereNotIn('Product_Name', $arrayPercent);
    //             $query_two = DB::table('tbl_product')
    //                 ->whereNotIn('Product_Name', $arrayReduce);
    //             $output_one = $this->combineSearchWithSort($query_one, $data['get_change']);
    //             $output_two = $this->combineSearchWithSort($query_two, $data['get_change']);
    //         }
    //     }
    //     return response()->json(['output' => $output, 'output_one' => $output_one, 'output_two' => $output_two]);
    // }
}