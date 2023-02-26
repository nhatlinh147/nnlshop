@extends('backend.admin-layout')
@section('link')
    {{-- Tag input boostrap --}}
    <link rel="stylesheet" href="{{asset('public/BackEnd/css/bootstrap-tagsinput.css')}}" type="text/css"/>
@endsection
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Thêm sản phẩm</h3>
                    {{-- <p>Use custom button styles for actions in forms, dialogs, and more with support for multiple sizes, states, and more.</p> --}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<div class="alert alert-info" style="font-weight:bold">'.$message.'</div>';
                                Session::put('message',null);
                            }
                        ?>
                        <form role="form" action="{{route('backend.save_product')}}" method="POST" id="Form_Product" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="inputText3" class="col-form-label">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="product_name"
                                onkeyup="ChangeToSlug()" id="slug">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Slug sản phẩm</label>
                                <input type="text" class="form-control" name="product_slug" id="convert_slug">
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Số lượng sản phẩm</label>
                                <input type="text" class="form-control format_price" name="product_quantity">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá bán</label>
                                <input type="text" name="product_price" class="form-control format_price"
                                id="product_price"
                                placeholder="Giá bán">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá gốc</label>
                                <input type="text" name="product_cost" class="form-control format_price"
                                id="product_cost"
                                placeholder="Giá gốc">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_image" class="form-control"
                                id="product_image" placeholder="Hình ảnh sản phẩm">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Tài liệu</label>
                                <input type="file" name="product_document" class="form-control"
                                placeholder="Tài liệu">
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
                                <label for="exampleInputEmail1">Tag sản phẩm </label>
                                <input type="text" data-role="tagsinput" name="product_tag" class="form-control" placeholder="Tag sản phẩm">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Mô tả sản phẩm</label>
                                <textarea class="form-control" name="product_desc" id="Ckeditor_Desc" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Nội dung sản phẩm</label>
                                <textarea class="form-control" name="product_content" id="Ckeditor_Content" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Từ khóa tìm kiếm</label>
                                <textarea class="form-control" rows="3" name="meta_keywords_product"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục sản phẩm</label>
                                <select name="category_product_name" class="form-control input-sm m-bot15">
                                    <option value="">Chọn danh mục sản phẩm</option>
                                    @foreach ($all_category_product as $category)
                                        @if (App\Model\CategoryModel::whereIn('Category_Parent',[$category->id])->get()->count() == 0)
                                            <option value="{{$category->id}}">{{$category->Category_Name}}</option>
                                        @else
                                            <optgroup label="{{$category->Category_Name}}">
                                                @foreach (App\Model\CategoryModel::where('Category_Parent',$category->id)->get() as $value)
                                                    <option value="{{$value->id}}">{{$value->Category_Name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Thương hiệu sản phẩm</label>
                                <select name="brand_product_name" class="form-control input-sm m-bot15">
                                    <option value="">Chọn thương hiệu sản phẩm</option>
                                    @foreach ($all_brand_product as $brand)
                                        @if (App\Model\BrandModel::whereIn('Brand_Parent',[$brand->Brand_ID])->get()->count() == 0)
                                            <option value="{{$brand->Brand_ID}}">{{$brand->Brand_Name}}</option>
                                        @else
                                            <optgroup label="{{$brand->Brand_Name}}">
                                                @foreach (App\Model\BrandModel::where('Brand_Parent',$brand->Brand_ID)->get() as $value)
                                                    <option value="{{$value->Brand_ID}}">{{$value->Brand_Name}}</option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-select">Hiển thị</label>
                                <select name="product_status" class="form-control input-sm m-bot15" id="input-select">
                                    <option value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display:flex;justify-content: center">
                                <button class="btn btn-primary" type="submit">Thêm sản phẩm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    {{-- Tag input boostrap --}}
    <script src="{{asset('public/BackEnd/js/bootstrap-tagsinput.min.js')}}"></script>
    <script type="text/javascript">
        function ChangeToSlug()
            {
                var slug;

                //Lấy text từ thẻ input title
                slug = document.getElementById("slug").value;
                slug = slug.toLowerCase();
                //Đổi ký tự có dấu thành không dấu
                    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                    slug = slug.replace(/đ/gi, 'd');
                    //Xóa các ký tự đặt biệt
                    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                    //Đổi khoảng trắng thành ký tự gạch ngang
                    slug = slug.replace(/ /gi, "-");
                    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                    slug = slug.replace(/\-\-\-\-\-/gi, '-');
                    slug = slug.replace(/\-\-\-\-/gi, '-');
                    slug = slug.replace(/\-\-\-/gi, '-');
                    slug = slug.replace(/\-\-/gi, '-');
                    //Xóa các ký tự gạch ngang ở đầu và cuối
                    slug = '@' + slug + '@';
                    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                    //In slug ra textbox có id “slug”
                document.getElementById('convert_slug').value = slug;
            }
            $("#Form_Product").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                product_name: {
                    required: true
                },
                // compound rule
                product_slug: {
                    required: true,
                    minlength: 4
                },
                product_quantity:{
                    required: true
                },
                product_price:{
                    required: true
                },
                product_cost:{
                    required: true
                },
                product_image:{
                    required: true,
                    accept: "image/*"
                },
                product_document:{
                    required: true,
                    extension: "pdf|docx|xlsx|doc"
                },
                product_desc: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                product_content: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                meta_keywords_product : {
                    required: true
                },
                category_product_name: {
                    valueNotEquals: ""// so sánh giá trị trong select-option
                },
                brand_product_name: {
                    valueNotEquals: ""
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                product_name: {
                    required: "Tên danh mục sản phẩm không được để trống"
                },
                // compound rule
                product_slug: {
                    required: "Slug danh mục sản phẩm không được để trống",
                    minlength: "Slug danh mục sản phẩm cần ít nhất 4 ký tự"
                },
                product_quantity:{
                    required: 'Số lượng sản phẩm không được để trống'
                },
                product_price:{
                    required: "Giá bán sản phẩm không được để trống"
                },
                product_cost:{
                    required: "Giá gốc sản phẩm không được để trống"
                },
                product_image:{
                    required: "Hình ảnh sản phẩm không được để trống",
                    accept: "File nhập vào phải là file hình ảnh"
                },
                product_document:{
                    required: "Tài liệu sản phẩm không được để trống",
                    extension: "File nhập vào phải là file tài liệu"
                },
                product_desc: {
                    required: "Mô tả sản phẩm không được để trống",
                },
                product_content: {
                    required: "Nội dung sản phẩm không được để trống",
                },
                meta_keywords_product:{
                    required: "Từ khóa tìm kiếm không được để trống"
                },
                category_product_name: {
                    valueNotEquals: "Cần lựa chọn danh mục sản phẩm"
                },
                brand_product_name: {
                    valueNotEquals: "Cần lựa chọn thương hiệu sản phẩm"
                }
            },
            errorPlacement: function(error, element) {
				if (element.is("textarea[id^='Ckeditor']")){
					error.insertAfter(element.next());
                }else{
                    error.insertAfter(element);
                }
			}
        });
    </script>
@endsection
