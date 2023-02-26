@extends('backend.admin-layout')
@section('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Data Tables - Print, Excel, CSV, PDF Buttons</h5>
                        <p>This example shows DataTables and the Buttons extension being used with the Bootstrap 4 framework
                            providing the styling.</p>
                    </div>
                    <div class="card-body">
                        <form role="form" action="{{ url('back-end/them-anh', ['product_id' => $product_id]) }}"
                            method="POST" enctype="multipart/form-data" id="Add_Gallery">
                            @csrf
                            <div id="Error_Gallery"></div>
                            <style>
                                label.custom-file-label {
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                }
                            </style>
                            <div class="row" style="justify-content:center">
                                <div class="custom-file mb-3 col-md-6">
                                    <input type="file" name="gallery_file[]" class="gallery_file custom-file-input"
                                        id="customFile" placeholder="Tên sản phẩm" multiple />
                                    <label class="custom-file-label" for="customFile">File Input</label>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-info" id="Button_Click">Thêm sản phẩm</button>
                                </div>
                            </div>

                            <div class="see_gallery row" style="justify-content: center">

                            </div>

                        </form>
                        <?php
                        $message = Session::get('message');
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            Session::put('message', null);
                        }
                        ?>
                        <input type="hidden" value="{{ $product_id }}" name="product_id" class="product_id">

                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="Message_Gallery">

                        </div>
                        <form>
                            @csrf
                            <div id="Load_Gallery">

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on('click', '.title_checkbox', function() {
            var check = $(this).prop('checked') == true ? 1 : 0;
            gallery_id = [];
            $('input[class*="checkbox_"]').each(function() {
                gallery_id.push($(this).data('gallery_id'));
            });
            if (check == 1) {
                for (i = 0; i < gallery_id.length; i++) {
                    $('.checkbox_' + gallery_id[i]).prop('checked', true);
                }
            } else {
                for (i = 0; i < gallery_id.length; i++) {
                    $('.checkbox_' + gallery_id[i]).prop('checked', false);
                }
            }

            if (check == 1 && $('input[class*="checkbox_"]').prop('checked')) {
                $('.add-button-delete').html(
                    '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-product-selected">Xóa</a>'
                );
            } else {
                $('.add-button-delete').empty();
            }


        }); //End click .delete_product
        $(document).on('click', 'input[class*="checkbox_"]', function() {
            var check = $(this).prop('checked') == true ? 1 : 0;
            gallery_id = [];
            $('input[class*="checkbox_"]').each(function() {
                gallery_id.push($(this).data('gallery_id'));
            });
            if (check == 0) {
                $('.title_checkbox').prop('checked', false);
            }
            for (i = 0; i < gallery_id.length; i++) {
                if ($('.checkbox_' + gallery_id[i]).is(':checked')) {
                    $('.add-button-delete').html(
                        '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-product-selected">Xóa</a>'
                    );
                    break;
                } else {
                    $('.add-button-delete').empty();
                }
            }

        });
    </script>
    <script type="text/javascript">
        load_gallery();

        //function load lại table
        function load_gallery() {
            var product_id = $('.product_id').val();
            var _token = $('input[name="_token"]').val();
            // alert(pro_id);
            $.ajax({
                url: "{{ route('backend.load_gallery_ajax') }}",
                method: "POST",
                data: {
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    $('#Load_Gallery').html(data);
                }
            }); // END ajax
        } // END function load_gallery

        //Xóa các ảnh đã chọn
        $(document).on('click', '.delete-product-selected', function() {
            var ids = [];

            $('input[class*="checkbox_"]').each(function() {
                if ($(this).is(":checked")) {
                    ids.push($(this).data('gallery_id'));
                }
            });
            var count_id = ids.length;
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('backend.delete_gallery_selected') }}',
                type: 'post',
                dataType: 'json',
                data: {
                    ids: ids,
                    _token: _token
                },
                success: function(data) {
                    if (data == count_id) {
                        $('.add-button-delete').empty();
                        $('.title_checkbox').prop('checked', false);
                    }

                    load_gallery()

                } //End Success
            }); //End Ajax
        });

        $(document).on('change', '.get_file', function() {
            var gallery_id = $(this).data('gallery_id');
            var file = $('#file-image-' + gallery_id)[0].files[0];

            $('.label_image_' + gallery_id).html(file.name);
            $('.label_image_' + gallery_id).css({
                'white-space': 'nowrap',
                'overflow': 'hidden',
                'text-overflow': 'ellipsis'
            });
        });

        $('.gallery_file').change(function() {
            var error = '';
            var files = $(this)[0].files; // truy cập tệp của phần tử class .gallery_file HTML đầu tiên

            if (files.length > 5) {
                error += '<label class="error-gallery">Một sản phẩm chỉ nên chọn tối đa 5 ảnh</label>';
            } else if (files.length == '') {
                error += '<label class="error-gallery">Bạn không được bỏ trống ảnh</label>';
            }

            // Kiểm tra xem có hình ảnh nào trong các tệp thêm nào có dung lượng lớn hơn 2M hay không
            var test = [];
            for (i = 0; i < files.length; i++) {
                tests = test.push(files[i].size);
            }
            for (i = 0; i < files.length; i++) {
                if (test[i] > 2000000) {
                    // alert(files[i].name+' Tệp này không hợp lệ');
                    error += '<label class="error-gallery">Dung lượng tệp ' + files[i].name +
                        ' không được lớn hơn 2MB</label>'
                }
            }

            if (error != '') {
                $('.gallery_file').val();
                $('#Error_Gallery').html(error);
                $('#Error_Gallery label').css({
                    'font-size': '10pt',
                    'margin': '10px 0px',
                    'font-weight': '500',
                    'font-style': 'normal'
                });
                $('.see_gallery').empty();
                return false;
            }
            if (files) {
                $('.see_gallery').empty();
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var fileReader = new FileReader();
                    fileReader.onload = (function(fileParams) {
                        return function(event) {
                            var str = '<div class="col-md-2 view_gallery">' +
                                '<div class="js-file-name"></div>' +
                                '<div class="js-file-size"></div>' +
                                '<img class="img-thumbnail js-file-image">' +
                                '</div>';
                            $('.see_gallery').append(str);

                            var imageSrc = event.target.result;
                            var fileName = fileParams.name;
                            var fileSize = fileParams.size;

                            $('.js-file-name').last().text(fileName);

                            $('.js-file-size').last().text(fileSize + ' (Byte)');
                            $('.js-file-image').last().attr('src', imageSrc);
                            $('.js-file-image').css({
                                'width': '100px',
                                'height': '100px'
                            });
                            $('.js-file-name').css({
                                'height': '68px',
                                'display': 'flex',
                                'align-items': 'flex-end',
                                'word-break': 'break-word'
                            });
                            $('.view_gallery').css({
                                'height': '220px',
                                'width': '100px'
                            })
                        };
                    })(file);
                    fileReader.readAsDataURL(file);
                }
            }

        }); // END change .gallery_file

        $(document).on('blur', '.edit-gallery-name', function() {
            var gallery_id = $(this).data('gallery_id');
            var gallery_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('backend.update_gallery_name') }}",
                method: "POST",
                data: {
                    gallery_id: gallery_id,
                    gallery_text: gallery_text,
                    _token: _token
                },
                success: function(data) {
                    load_gallery();
                    $('#Message_Gallery').html(
                        '<label class="alert alert-success w-100" style="font-size:10pt">Cập nhật tên hình ảnh thành công</label>'
                    );
                } //END success
            }); //END ajax
        }); //END blur .edit_gal_name

        $(document).on('click', '#Delete_Gallery', function() {
            var del_gallery_id = $(this).data('gallery_id');
            var _token = $('input[name="_token"]').val();
            if (confirm('Bạn muốn xóa hình ảnh này không?')) {
                $.ajax({
                    url: "{{ route('backend.delete_gallery') }}",
                    method: "POST",
                    data: {
                        del_gallery_id: del_gallery_id,
                        _token: _token
                    },
                    success: function(data) {
                        load_gallery();
                        $('#Message_Gallery').html(
                            '<label class="alert alert-success w-100" style="font-size:10pt">Xóa hình ảnh thành công</label>'
                        );
                    }
                });
            }
        });

        $(document).on('change', '.get_file', function() {

            var gallery_id = $(this).data('gallery_id');
            // var image = document.getElementById("file-image-"+gallery_id).files[0];

            var form_data = new FormData();
            // chèn thêm một cặp key => value vào trong FormData
            form_data.append("file-image", document.getElementById("file-image-" + gallery_id).files[0]);
            form_data.append("gallery_id", gallery_id);

            $.ajax({
                url: "{{ route('backend.update_gallery') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType: false, // Loại nội dung được sử dụng khi gửi dữ liệu đến máy chủ. Mặc định là: "application/x-www-form-urlencoded"
                cache: false, //  Giá trị Boolean cho biết liệu trình duyệt có nên lưu vào bộ nhớ cache các trang được yêu cầu hay không. Mặc định là true
                processData: false, // Set giá trị này là false nếu bạn không muốn dữ liệu được truyền vào thiết lập data sẽ được xử lý và biến thành một query kiểu chuỗi.
                success: function(data) {
                    load_gallery();
                    $('#Message_Gallery').html(
                        '<label class="alert alert-success w-100" style="font-size:10pt">Cập nhật hình ảnh thành công</label>'
                    );
                }
            });

        });
    </script>
@endsection
