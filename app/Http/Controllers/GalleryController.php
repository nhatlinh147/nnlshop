<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


use App\Repository\GalleryInterface;
use App\Repository\ProductInterface;

use File;
use Carbon\Carbon;


class GalleryController extends Controller
{
    /**
     * @var GalleryInterface
     *  @var ProductInterface
     */
    private $gallery, $product;

    /**
     * GalleryController constructor.
     *
     * @param GalleryInterface $gallery
     * @param ProductInterface $product
     */
    public function __construct(GalleryInterface $gallery, ProductInterface $product)
    {
        $this->gallery = $gallery;
        $this->product = $product;
    }

    public function list_gallery($product_slug)
    {
        $all_product = $this->product->getAll();
        $product_id = $this->product->findBySlug($product_slug)->Product_ID;
        return view('backend.gallery.list-gallery')->with(compact('product_id', 'all_product'));
    }
    public function load_gallery_ajax(Request $request)
    {
        $product_id = $request->product_id;
        // $gallery = GalleryModel::where('Product_ID', $product_id)->get();
        $gallery = $this->gallery->findByProduct($product_id);
        $count_gallery_ = $gallery->count();
        $output = ' <form>
    					' . csrf_field() . '

    					<table class="table table-hover" id="Add_Gallery">
                                    <thead>
                                      <tr>
                                        <th>
                                            <label class="custom-control custom-checkbox">
                                                <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                                                <span class="custom-control-label"></span>
                                            </label>
                                        </th>
                                      	<th>Thứ tự</th>
                                        <th>Tên hình ảnh</th>
                                        <th>Hình ảnh</th>
                                        <th>Thuộc sản phẩm</th>
                                        <th>Xóa</th>
                                      </tr>
                                    </thead>
                                    <tbody>

    	';
        if ($count_gallery_ > 0) {
            $i = 0;
            foreach ($gallery as $key => $item) {
                $i++;
                $output .= '
    				 <tr>
                        <td>
                            <label class="custom-control custom-checkbox">
                                <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_' . $item->Gallery_ID . '" data-gallery_id="' . $item->Gallery_ID . '">
                                <span class="custom-control-label"></span>
                            </label>
                        </td>
                        <td>' . $i . '</td>
                        <td contenteditable class="edit-gallery-name" data-gallery_id="' . $item->Gallery_ID . '">' . $item->Gallery_Name . '</td>
                        <td>

                        <img src="' . url('public/upload/gallery/' . $item->Gallery_Image) . '" class="img-thumbnail" style="height:100px;width:120px">

                        <div class="custom-file mb-3">
                            <input type="file" name="file" class="get_file custom-file-input" data-gallery_id="' . $item->Gallery_ID . '" id="file-image-' . $item->Gallery_ID . '" placeholder="Tên sản phẩm" style="width:100%"/>
                            <label class="custom-file-label label_image_' . $item->Gallery_ID . '">File Input</label>
                        </div>

                        </td>
                        <td>
                            ' . $item->Product->Product_Name . '
                        </td>
                        <td>
                            <button type="button" data-gallery_id="' . $item->Gallery_ID . '" class="btn btn-sm btn-danger" id="Delete_Gallery">Xóa</button>
                        </td>
                    </tr>
    			    ';
            }
        } else {
            $output .= '
                <tr>

                <td colspan="4">Sản phẩm chưa thư viện ảnh</td>

                </tr>
            ';
        }
        $output .= '
    				 </tbody>
                    <tfoot>
                        <tr class="add-button-delete">

                        </tr>
                    </tfoot>
    				 </table>
    				 </form>


    			';
        echo $output;
    }
    public function insert_gallery(Request $request, $product_id)
    {
        $getImage = $request->file('gallery_file');
        if ($getImage) {
            foreach ($getImage as $image) {
                $setNameImage = current(explode('.', $image->getClientOriginalName())) . '-' .  rand(0, 101) . '.' . $image->getClientOriginalExtension();
                $image->move('public/upload/gallery/', $setNameImage); // đường dẫn tới file upload

                // Sao chép hình ảnh từ địa điểm public/storage/images/ đến public/upload/
                // File::copy('public/storage/images/' . $setNameImage, 'public/upload' . $setNameImage);

                $gallery = $this->gallery->newModel();
                $gallery->Gallery_Name = $setNameImage;
                $gallery->Gallery_Image = $setNameImage;
                $gallery->Product_ID = $product_id;
                $gallery->save();
            }
        }
        Session::flash('message', 'Thêm thư viện ảnh thành công');
        return redirect()->back();
    }
    public function delete_gallery_selected(Request $request)
    {
        $data = $request->ajax();
        $get_pro =  $this->gallery->findInGallery($request->ids);
        foreach ($get_pro as $value) {
            unlink('public/upload/gallery/' . $value->Gallery_Image);
        }

        $gallery = $this->gallery->deleteInGallery($request->ids);
        return response()->json($gallery);
    }
    public function update_gallery_name(Request $request)
    {
        $data = $request->all();
        $gallery_id = $data['gallery_id'];
        $gallery_text = $data['gallery_text'];
        $gallery = $this->gallery->find($gallery_id);
        $gallery->gallery_name = $gallery_text;
        $gallery->save();
    }

    public function delete_gallery(Request $request)
    {
        $gallery = $this->gallery->find($request->del_gallery_id);
        unlink('public/upload/gallery/' . $gallery->Gallery_Image);
        $gallery->delete();
    }
    public function update_gallery(Request $request)
    {
        $getImage = $request->file('file-image'); // đọc file
        $gallery_id = $request->gallery_id;
        if ($getImage) {
            $gallery = $this->gallery->find($gallery_id);

            unlink('public/upload/gallery/' . $gallery->Gallery_Image);
            $setNameImage = current(explode('.', $getImage->getClientOriginalName())) . '-' .  rand(0, 101) . '.' . $getImage->getClientOriginalExtension();
            $getImage->move('public/upload/gallery/', $setNameImage); //đường dẫn tới file

            // lưu lại tên ảnh mới cập nhật
            $gallery->Gallery_Image = $setNameImage;
            $gallery->save();
        }
    }
}