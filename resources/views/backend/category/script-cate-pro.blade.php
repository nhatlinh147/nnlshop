@include('backend.include.transfer-slug')

<script>
    $(document).ready(function() {
        var data_cate_pro = $('table.second').DataTable({
            lengthChange: true,
            ajax: {
                "type": "GET",
                "url": "{{ route('backend.all_cate_pro_json') }}",
            },
            columns: [{
                    "title": "Id danh mục",
                    "data": "id",
                    "visible": false,
                    "searchable": false
                },
                {
                    "title": "Thứ tự",
                    "data": null,
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Tên danh mục",
                    "data": "Category_Name",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Slug danh mục",
                    "data": "Category_Product_Slug",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Hình ảnh sản phẩm",
                    "data": "Category_Image",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<img src="{{ url('public/upload/cate_pro/`+data+`') }}" height="100" width="100"/>`
                    }
                },
                {
                    "title": "Thuộc danh mục",
                    "data": "Category_Parent",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        if (data == 0) {
                            var value = '<span style="color:red;">Danh mục cha</span>';
                        } else {
                            @foreach ($category_parent as $key => $subcate)

                                if (data == {{ $subcate->id }}) {
                                    var value =
                                        `<span style="color:green;">{{ $subcate->Category_Name }}</span>`;
                                }
                            @endforeach
                        }
                        return value;
                    }
                },
                {
                    "title": "Ẩn/hiển thị",
                    "data": "Category_Status",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        if (data == 1) {
                            var value = 'checked';
                        } else {
                            var value = ''
                        }
                        return `<div class="switch-button switch-button-success">
                                <input type="checkbox" ` + value + ` name="switch` + row['id'] + `" id="switch` + row[
                            'id'] + `" data-id="` + row['id'] + `" class="update_status"><span>
                            <label for="switch` + row['id'] + `"></label></span>`;
                    }
                },
                {
                    "title": "Ngày thêm",
                    "data": "created_at",
                    "visible": true,
                    "searchable": true,
                    "width": "10%",
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString("en-GB").replace(new RegExp(
                            '/', 'g'), '-');
                    }
                },
                {
                    "title": "Sửa/xóa",
                    "data": "id",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-category-product" data-id="` +
                            data + `">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs delete-category-product" data-id="` +
                            data + `">Xóa</a>`
                    }
                },
            ],
            // columnDefs: [{
            //     sortable: false,
            //     "class": "index",
            //     targets: 0
            // }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: true
        }); // END Datatable
        data_cate_pro.on('order.dt search.dt', function() {
            data_cate_pro.column(1, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
<script>
    var SITEURL = '{{ url('/back-end') }}';
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-cate-pro').click(function() {
            $("#categoryForm").clearValidation();
            $('#cate_pro_id').val('');
            $('#Image_Product').val('');
            $('#categoryForm').trigger("reset");
            CKEDITOR.instances['Ckeditor_Desc'].setData('');
            $('#btn-save').val("Thêm danh mục");
            $('#Title_Category_Product').html("Thêm danh mục mới");
            $('#ajax-cate-pro-modal').modal('show');
            $('.see_category_image').empty();
        });

        $('body').on('click', '.edit-category-product', function() {
            var cate_pro_id = $(this).data('id');
            $("#categoryForm").clearValidation();
            $.get('sua-danh-muc-san-pham/' + cate_pro_id, function(data) {
                // console.log(data.category_parent);
                data_one = data.cate_pro;
                data_two = data.category_parent;

                $('#Title_Category_Product').html("Sửa danh mục sản phẩm");
                $('#btn-save').val("Lưu danh mục");
                $('#ajax-cate-pro-modal').modal('show');
                $('#cate_pro_id').val(data_one.id);
                $('#Category_Image').val(data_one.Category_Image);
                $('.category_product_name').val(data_one.Category_Name);
                $('.category_product_slug').val(data_one.Category_Product_Slug);
                CKEDITOR.instances['Ckeditor_Desc'].setData(data_one.Category_Desc);

                $('.meta_keywords_category').val(data_one.Meta_Keywords_Category);
                $('.category_parent option[value="' + data_one.Category_Parent + '"]').attr(
                    'selected', 'selected');
                $('.category_status option[value="' + data_one.Category_Status + '"]').attr(
                    'selected', 'selected');


                //Thêm danh mục cha (bao gồm category_parent == 0 ngoại trừ chính element được click đó))
                var stri = '<option value="0">---Chọn thuộc danh mục---</option>';
                console.log(data_two);
                data_two.forEach(element => {
                    var selected = element.id == data_one.Category_Parent ?
                        'selected="selected"' :
                        '';
                    stri += '<option ' + selected + ' value="' + element.id + '">' +
                        element
                        .Category_Name + '</option>';
                });
                $('select.category_parent').html(stri);

                //bắt đầu reset lại input
                $('.see_category_image').html(
                    `<img src="{{ url('public/upload/cate_pro/${data_one.Category_Image}') }}" height="100" width="100" class="get_image"/>`
                );
            });
        });

        $('body').on('click', '.delete-category-product', function() {

            var cate_pro_id = $(this).data("id");
            if (confirm("Bạn có chắc muốn xóa danh mục sản phẩm này không ?")) {
                $.ajax({
                    type: "get",
                    url: SITEURL + "/xoa-danh-muc-san-pham/" + cate_pro_id,
                    success: function(data) {
                        var oTable = $('table.second').DataTable();
                        oTable.ajax.reload(null, false);
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            }

        });

    }); // END document ready
    if ($("#categoryForm").length > 0) {
        $("#categoryForm").validate({
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
                meta_keywords_category: {
                    required: "Từ khóa tìm kiếm không được để trống"
                }
            },
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var data = new FormData($("#categoryForm")[0]);

                var before_image = $('#Category_Image').val();
                data.append('before_image', before_image);

                $.ajax({
                    data: data,
                    url: SITEURL + "/luu-danh-muc-san-pham",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#categoryForm').trigger("reset");
                        $('#ajax-cate-pro-modal').modal('hide');
                        $('#btn-save').html('Lưu danh mục');
                        var oTable = $('#example').DataTable();
                        oTable.ajax.reload(null, false);
                        if (data.Product_Name) {
                            $('#message_cate_pro').after(
                                "<div class='alert alert-info message_" + data.id +
                                "'>Lưu sản phẩm: <i class='compareCondition'>" + data
                                .Category_Name + "</i> thành công</div>");
                            setTimeout(function() {
                                $('.message_' + data.id).fadeOut().remove();
                            }, 10000);
                        }
                    }, // END success
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    } // END error
                }); // END ajax
            } // END submitHandler
        })
    }
</script>
<script>
    $(document).on('click', '.update_status', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var category_id = $(this).data('id');
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{ route('backend.category_status') }}',
            data: {
                'status': status,
                'category_id': category_id
            },
            success: function(data) {
                console.log('success');
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.category_image').on('change', function() {
            var file = $(this)[0].files[0];

            var fileReader = new FileReader();
            fileReader.onload = function() {
                var str =
                    '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                $('.see_category_image').html(str);

                var imageSrc = event.target.result;

                $('.js-file-image').attr('src', imageSrc);
            };
            fileReader.readAsDataURL(file);
        });
    });
</script>
