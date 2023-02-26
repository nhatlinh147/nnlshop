@extends('backend.admin-layout')
@section('content')

    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
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
                        <form role="form" action="{{route('backend.save_category')}}" method="post" id="Form_Category_Product">
                            @csrf
                            <div class="form-group">
                                <label for="inputText3" class="col-form-label">Tên danh mục sản phẩm</label>
                                <input type="text" class="form-control" name="category_product_name"
                                onkeyup="ChangeToSlug()" id="slug">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Slug danh mục sản phẩm</label>
                                <input type="text" class="form-control category_product_slug" name="category_product_slug" id="convert_slug">
                            </div>
                            {{-- <div class="form-group">
                                <label for="inputEmail">Hình ảnh sản phẩm</label>
                                <div class="custom-file mb-3">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">File Input</label>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Mô tả danh mục</label>
                                <textarea class="form-control" name="category_product_desc" id="Ckeditor_Desc" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Từ khóa tìm kiếm</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="meta_keywords_category"></textarea>
                            </div>
                            @if ($getCateParent->count() > 0 )
                                <div class="form-group">
                                    <label for="input-select">Các danh mục cha</label>
                                    <select class="form-control" id="input-select" name="category_parent">
                                        <option value="0">---Chọn thuộc danh mục---</option>
                                        @foreach ($getCateParent as $value)
                                            <option value="{{$value->id}}">{{$value->Category_Name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="category_parent" value="0"/>
                            @endif
                            <div class="form-group">
                                <label for="input-select">Hiển thị</label>
                                <select name="category_status" class="form-control input-sm m-bot15" id="input-select">
                                    <option value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display:flex;justify-content: center">
                                <button class="btn btn-primary" type="submit">Tạo danh mục</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
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
    </script>
    <script>
        $("#Form_Category_Product").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                category_product_name: {
                required: true
                },
                // compound rule
                category_product_slug: {
                required: true,
                minlength: 4
                },
                category_product_desc: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                meta_keywords_category: {
                    required: true
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                category_product_name: {
                required: "Tên danh mục sản phẩm không được để trống"
                },
                // compound rule
                category_product_slug: {
                required: "Slug danh mục sản phẩm không được để trống",
                minlength: "Slug danh mục sản phẩm cần ít nhất 4 ký tự"
                },
                category_product_desc: {
                required: "Mô tả danh mục sản phẩm không được để trống",
                },
                meta_keywords_category:{
                required: "Từ khóa tìm kiếm không được để trống"
                }
            },
        });
    </script>
@endsection
