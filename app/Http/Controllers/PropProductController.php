<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Model\Product;
use App\Model\PropProductModel;

class PropProductController extends Controller
{
    public function all_prop_product(Request $request)
    {
        return view('backend.prop.all-prop-product');
    }
    public function products_selected_prop(Request $request)
    {
        $haveProp = PropProductModel::groupBy('Prop_Product_ID')
            ->whereNotIn('Prop_Size', ['Không'])
            ->orWhereNotIn('Prop_Color', ['Không'])
            ->get();
        $array_product_id = array_column($haveProp->toArray(), 'Prop_Product_ID');
        $product = Product::whereNotIn('Product_ID', $array_product_id)->get();
        return response()->json([
            'tag' => array_column($product->toArray(), 'Product_Name'),
            'value' => array_column($product->toArray(), 'Product_ID'),
        ]);
    }
    public function save_prop(Request $request)
    {
        // $this->validation($request);
        $data = $request->all();

        $sizes = '';
        $colors = '';
        if (isset($data['edit_prop_id'])) {
            $prop_id = $data['edit_prop_id'];
            $tagsInput = PropProductModel::find($data['edit_prop_id'])->Prop_Product_ID;
            $array_size = $request->input('edit_prop_size');
            $array_color = $request->input('edit_prop_color');
        } else {
            $prop_id = NULL;
            $tagsInput = $data['prop_tagsInput'];
            $array_size = $request->input('prop_size');
            $array_color = $request->input('prop_color');
        }

        if (!empty($array_size)) {
            foreach ($array_size as $size) {
                $sizes .= $size . ',';
            }
        } else {
            $sizes .=  "Không";
        }

        if (!empty($array_color)) {
            foreach ($array_color as $color) {
                $colors .= $color . ',';
            }
        } else {
            $colors .=  "Không";
        }

        $prop = PropProductModel::updateOrCreate(
            ['Prop_ID' => $prop_id],
            [
                'Prop_Product_ID' => $tagsInput,
                'Prop_Size' => trim($sizes, ","),
                'Prop_Color' => trim($colors, ",")
            ]
        );

        return response()->json($prop);
    }
    function list_product($array)
    {
        $output = '';
        $index = 0;
        foreach ($array as $value) {
            $index++;
            $comma =   $index > 1 ? ' , ' : '';
            $output .= $comma . Product::find($value)->Product_Name;
        }
        return $output;
    }
    function color_Vi($colors)
    {
        $array_color = [
            'blue' => 'xanh da trời', 'cyan' => 'xanh lơ', 'green' => 'xanh lá', 'yellow' => 'vàng',
            'red' => 'đỏ', 'magenta' => 'hồng sẫm', 'purple' => 'tím', 'orange' => 'cam', 'black' => 'đen',
            'white' => 'trắng', 'pink' => 'hồng', 'brown' => 'nâu'
        ];
        $output = '';
        $index = 0;
        if ($colors[0] != "Không") {
            foreach ($colors as $color) {
                $index++;
                $comma =   $index > 1 ? ' , ' : '';
                $output .= $comma . "Màu " . $array_color[$color];
            }
        } else {
            $output = "Không";
        }

        return $output;
    }
    public function list_prop(Request $request)
    {
        $data = $request->all();
        $from = ($data['active_page'] - 1) * $data['limit_page'];
        $all_prop = PropProductModel::skip($from)->take($data['limit_page'])->get();

        //Làm tròn lên (Cập nhật lại số lượng trang)
        $count_page  = ceil(count(PropProductModel::all()) / $data['limit_page']);

        $output = '';

        if (count($all_prop) == 0) {
            $output .= '
            <tr>
                <th colspan="5" class="text-center font-weight-normal">Không có dữ liệu</th>
            </tr>
        ';
        } else {
            foreach ($all_prop as $prop) {
                $from++;
                $output .= '
                    <tr>
                        <th scope="row">' . $from . '</th>
                        <td>' . $this->list_product(explode(',', $prop->Prop_Product_ID)) . '</td>
                        <td>' . implode(' , ', explode(',',  $prop->Prop_Size)) . '</td>
                        <td>' . $this->color_Vi(explode(',', $prop->Prop_Color)) . '</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="Edit_Prop" data-prop_id="' . $prop->Prop_ID . '">
                            <i class="fas fa-pen-square fa-2x text-success"></i>
                            </a>
                            &nbsp&nbsp
                            <a href="javascript:void(0)"  id="Delete_Prop" data-prop_id="' . $prop->Prop_ID . '">
                            <i class="fas fa-window-close fa-2x text-danger"></i>
                            </a>
                        </td>
                    </tr>
                ';
            }
        }

        return response()->json([
            'output' => $output,
            'count_page' => $count_page
        ]);
    }

    public function edit_prop(Request $request)
    {
        $data = $request->all();
        $query = PropProductModel::find($data['prop_id']);
        $prop_product_id = $query->Prop_Product_ID;
        $prop_size = $query->Prop_Size;
        $prop_color = $query->Prop_Color;

        return response()->json([
            'prop_product_id' => $this->list_product(explode(",", $prop_product_id)),
            'prop_size' => explode(",", $prop_size),
            'prop_color' => explode(",", $prop_color),

        ]);
    }
    public function delete_prop(Request $request)
    {
        $data = $request->all();
        $prop = PropProductModel::where('Prop_ID', $data['prop_id'])->delete();
        return $prop;
    }
}