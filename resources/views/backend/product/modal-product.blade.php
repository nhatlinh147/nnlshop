<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-small">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="Title_Product"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id" />
                    <input type="hidden" id="Image_Product" />
                    <input type="hidden" id="Document_Product" />
                    <div class="form-group">
                        <label for="inputText3" class="col-sm-6">Tên sản phẩm</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control product_name" name="product_name"
                                onkeyup="ChangeToSlug()" id="slug">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-6">Slug sản phẩm</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control product_slug" name="product_slug"
                                id="convert_slug">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-6">Số lượng sản phẩm</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control format_price product_quantity"
                                name="product_quantity">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-6">Giá bán</label>
                        <div class="col-sm-12">
                            <input type="text" name="product_price" class="form-control format_price product_price"
                                id="product_price" placeholder="Giá bán">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-6">Giá gốc</label>
                        <div class="col-sm-12">
                            <input type="text" name="product_cost" class="form-control format_price product_cost"
                                id="product_cost" placeholder="Giá gốc">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-6">Hình ảnh sản phẩm</label>
                        <div class="col-sm-12">
                            <input type="file" name="product_image" class="form-control product_image"
                                id="product_image" placeholder="Hình ảnh sản phẩm">
                            <div class="see_product_image">

                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-6">Tài liệu</label>
                        <div class="col-sm-12">
                            <input type="file" name="product_document" class="form-control product_document"
                                placeholder="Tài liệu">
                            <div class="see_product_document">

                            </div>
                        </div>
                    </div>
                    <style>
                        span.label-info {
                            color: whitesmoke !important;
                            background-color: #5969ff !important;
                            font-size: 9pt;

                        }

                        .bootstrap-tagsinput input {
                            height: 15px;
                            font-size: 9pt;
                        }
                    </style>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-6">Tag sản phẩm </label>
                        <div class="col-sm-12">
                            <input type="text" data-role="tagsinput" name="product_tag"
                                class="form-control product_tag" placeholder="Tag sản phẩm">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="col-sm-6" class="col-sm-6">Tóm tắt sản
                            phẩm</label>
                        <div class="col-sm-12">
                            <textarea class="form-control product_summary" name="product_summary" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="col-sm-6" class="col-sm-6">Mô tả sản
                            phẩm</label>
                        <div class="col-sm-12">
                            <textarea class="form-control product_desc" name="product_desc" id="Ckeditor_Desc" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="col-sm-6">Nội dung sản phẩm</label>
                        <div class="col-sm-12">
                            <textarea class="form-control product_content" name="product_content" id="Ckeditor_Content" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1" class="col-sm-6">Từ khóa tìm kiếm</label>
                        <div class="col-sm-12">
                            <textarea class="form-control meta_keywords_product" rows="3" name="meta_keywords_product"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6">Danh mục sản phẩm</label>
                        <div class="col-sm-12">
                            <select name="category_product_name"
                                class="form-control input-sm m-bot15 category_product_name">
                                <option value="">Chọn danh mục sản phẩm</option>
                                @foreach ($all_category_product as $category)
                                    @if (App\Model\CategoryModel::whereIn('Category_Parent', [$category->id])->get()->count() == 0)
                                        <option value="{{ $category->id }}">{{ $category->Category_Name }}
                                        </option>
                                    @else
                                        <optgroup label="{{ $category->Category_Name }}">
                                            @foreach (App\Model\CategoryModel::where('Category_Parent', $category->id)->get() as $value)
                                                <option value="{{ $value->id }}">{{ $value->Category_Name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-6">Hiển thị</label>
                        <div class="col-sm-12">
                            <select name="product_status" class="form-control input-sm m-bot15 product_status"
                                id="input-select">
                                <option value="0">Ẩn</option>
                                <option selected value="1">Hiển thị</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                        style="display:flex;justify-content: center">
                        <input type="submit" class="btn btn-primary" id="btn-save" value="Lưu thay đổi" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
