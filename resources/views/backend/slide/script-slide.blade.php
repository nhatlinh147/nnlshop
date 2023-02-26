<script>
    $("#submenu-5").addClass('active');
</script>
<script>
    $(document).ready(function() {
        var data_cate_pro = $('table.second').DataTable({
            lengthChange: true,
            footer: true,
            ajax: {
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('backend.list_slide_json') }}",
            },
            columns: [{
                    "title": `
                    <label class="custom-control custom-checkbox">
                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                        <span class="custom-control-label"></span>
                    </label>`,
                    "data": "Slide_ID",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {

                        return `<label class="custom-control custom-checkbox">
                                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_` +
                            data + `" data-slide_id ="` + data + `" >
                                        <span class="custom-control-label"></span>
                                    </label>`;
                    }
                },
                {
                    "title": "Id slide",
                    "data": "Slide_ID",
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
                    "title": "Tên slide",
                    "data": "Slide_Title",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Hình ảnh slide",
                    "data": "Slide_Image",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<img src="{{ url('public/upload/slide/`+data+`') }}" height="100" width="100"/>`
                    }
                },
                {
                    "title": "Mô tả slide",
                    "data": "Slide_Desc",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Ẩn/hiển thị",
                    "data": "Slide_Status",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        if (data == 1) {
                            var value = 'checked';
                        } else {
                            var value = ''
                        }
                        return `<div class="switch-button switch-button-success">
                                <input type="checkbox" ` + value + ` name="switch` + row['Slide_ID'] + `" id="switch` +
                            row['Slide_ID'] + `" data-id="` + row['Slide_ID'] + `" class="update_status"><span>
                            <label for="switch` + row['Slide_ID'] + `"></label></span>`;
                    }
                },
                {
                    "title": "Ngày thêm",
                    "data": "created_at",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString("en-GB").replace(new RegExp(
                            '/', 'g'), '-');
                    }
                },
                {
                    "title": "Sửa/xóa",
                    "data": "Slide_ID",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-slide" data-id="` +
                            data + `">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs delete-slide" data-id="` + data +
                            `">Xóa</a>`
                    }
                },
            ],
            columnDefs: [{
                sortable: false,
                "class": "index",
                targets: 0
            }],
            order: [
                [1, 'asc']
            ],
            fixedColumns: true
        }); // END Datatable
        data_cate_pro.on('order.dt search.dt', function() {
            data_cate_pro.column(2, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
<script>
    $.fn.clearValidation = function() {
        var v = $(this).validate();
        $('[name]', this).each(
            function() {
                v.successList.push(this);
                v.showErrors();
            });
        v.resetForm();
        v.reset();
    };

    var SITEURL = '{{ url('/back-end') }}';
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#create-slide').click(function() {
            //Xóa đi toàn bộ dữ liệu validate (trước đó)
            //Thiết lập validate cho slide_image (vì clearValidation không thể xóa đi validation image trước đó)
            $("#slideForm").clearValidation();
            $(".slide_image").rules('add', 'required accept');

            $('.see_slide_image').empty();

            //Hidden
            $('#slide_id').val('');
            $('#Image_Slide_Hidden').val('');

            $('#slideForm').trigger("reset");
            CKEDITOR.instances['Ckeditor_Desc'].setData('');
            $('#btn-save').val("Thêm slide");
            $('#Title_Slide').html("Thêm slide mới");
            $('#ajax-slide-modal').modal('show');
        });

        $('body').on('click', '.edit-slide', function() {
            var slide_id = $(this).data('id');
            $("#slideForm").clearValidation();
            $(".slide_image").rules('remove');
            $.get('sua-slide/' + slide_id, function(data) {
                $('#Title_Slide').html("Sửa slide sản phẩm");
                $('#Image_Slide_Hidden').val(data.Slide_Image);
                $('#btn-save').val("Lưu slide");
                $('#ajax-slide-modal').modal('show');
                $('#slide_id').val(data.Slide_ID);
                $('.slide_title').val(data.Slide_Title);
                CKEDITOR.instances['Ckeditor_Desc'].setData(data.Slide_Desc);
                $('.slide_more').val(data.Slide_More);
                $('.see_slide_image').html(
                    `<img src="{{ url('public/upload/slide/${data.Slide_Image}') }}" height="100" width="100" style="margin-top:6px"/>`
                );
                $('.meta_keywords_slide').val(data.Meta_Keywords_Slide);
                $('.slide_status option[value="' + data.Slide_Status + '"]').attr('selected',
                    'selected');
            });
        });

        $('body').on('click', '.delete-slide', function() {

            var slide_id = $(this).data("id");
            if (confirm("Bạn có chắc muốn xóa slide sản phẩm này không ?")) {
                $.ajax({
                    type: "get",
                    url: SITEURL + "/xoa-slide/" + slide_id,
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
    if ($("#slideForm").length > 0) {
        $("#slideForm").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                slide_title: {
                    required: true
                },
                slide_image: {
                    required: true,
                    accept: "image/*"
                },
                // compound rule
                slide_desc: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                meta_keywords_slide: {
                    required: true
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                slide_title: {
                    required: "Tên slide không được để trống"
                },
                slide_image: {
                    required: "Hình ảnh slide không được để trống",
                    accept: "File nhập vào phải là file hình ảnh"
                },
                slide_desc: {
                    required: "Mô tả slide không được để trống",
                },
                slide_title: {
                    required: "Nút slide more không được để trống"
                },
                meta_keywords_slide: {
                    required: "Từ khóa tìm kiếm không được để trống"
                }
            },
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var get_image = $('#Image_Slide_Hidden').val();
                var data = new FormData($("#slideForm")[0]);
                data.append('get_image', get_image);
                $.ajax({
                    data: data,
                    url: SITEURL + "/luu-slide",
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $('#slideForm').trigger("reset");
                        $('#ajax-slide-modal').modal('hide');
                        $('#btn-save').html('Lưu slide');
                        var oTable = $('#example').DataTable();
                        oTable.ajax.reload(null, false);
                        if (data.Slide_Title) {
                            if (get_image == '') {
                                $('#message_slide').after(
                                    "<div class='alert alert-info message_" + data
                                    .Slide_Id +
                                    "'>Tạo slide: <i class='compareCondition'>" + data
                                    .Slide_Title + "</i> thành công</div>");
                                setTimeout(function() {
                                    $('.message_' + data.Slide_Id).fadeOut().remove();
                                }, 10000);
                            } else {
                                $('#message_slide').after(
                                    "<div class='alert alert-info message_" + data
                                    .Slide_Id +
                                    "'>Lưu slide: <i class='compareCondition'>" + data
                                    .Slide_Title + "</i> thành công</div>");
                                setTimeout(function() {
                                    $('.message_' + data.Slide_Id).fadeOut().remove();
                                }, 10000);
                            }

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
    $(document).on('click', '.title_checkbox', function() {
        var check = $(this).prop('checked') == true ? 1 : 0;
        slide_id = [];
        $('input[class*="checkbox_"]').each(function() {
            slide_id.push($(this).data('slide_id'));
        });
        if (check == 1) {
            for (i = 0; i < slide_id.length; i++) {
                $('.checkbox_' + slide_id[i]).prop('checked', true);
            }
        } else {
            for (i = 0; i < slide_id.length; i++) {
                $('.checkbox_' + slide_id[i]).prop('checked', false);
            }
        }

        if (check == 1 && $('input[class*="checkbox_"]').prop('checked')) {
            $('.add-button-delete').html(
                '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-slide-selected">Xóa</a>'
            );
            $('label.custom-control.custom-checkbox').css({
                'display': 'inline-block'
            });
            $('td.index,th.index').css({
                'text-align': 'center'
            });
        } else {
            $('.add-button-delete').empty();
        }


    }); //End click .delete_slide
    $(document).on('click', 'input[class*="checkbox_"]', function() {
        var check = $(this).prop('checked') == true ? 1 : 0;
        slide_id = [];
        $('input[class*="checkbox_"]').each(function() {
            slide_id.push($(this).data('slide_id'));
        });
        if (check == 0) {
            $('.title_checkbox').prop('checked', false);
        }
        for (i = 0; i < slide_id.length; i++) {
            if ($('.checkbox_' + slide_id[i]).is(':checked')) {
                $('.add-button-delete').html(
                    '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-slide-selected">Xóa</a>'
                );
                $('label.custom-control.custom-checkbox').css({
                    'display': 'inline-block'
                });
                $('td.index,th.index').css({
                    'text-align': 'center'
                });
                break;
            } else {
                $('.add-button-delete').empty();
            }
        }

    });
    $(document).on('click', '.delete-slide-selected', function() {
        var ids = [];

        $('input[class*="checkbox_"]').each(function() {
            if ($(this).is(":checked")) {
                ids.push($(this).data('slide_id'));
            }
        });
        var count_id = ids.length;
        $.ajax({
            url: '{{ route('backend.delete_slide_selected') }}',
            type: 'get',
            dataType: 'json',
            data: {
                ids: ids
            },
            success: function(data) {
                if (data == count_id) {
                    $('.add-button-delete').empty();
                    $('.title_checkbox').prop('checked', false);
                }
                var oTable = $('table.second').DataTable();
                oTable.ajax.reload(null, false);

            } //End Success
        }); //End Ajax
    });
</script>
<script>
    $(document).ready(function() {
        $('.slide_image').on('change', function() {
            var file = $(this)[0].files[0];

            var fileReader = new FileReader();
            fileReader.onload = function() {
                var str =
                    '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                $('.see_slide_image').html(str);

                var imageSrc = event.target.result;

                $('.js-file-image').attr('src', imageSrc);
            };
            fileReader.readAsDataURL(file);
        });
    });
    $(document).on('click', '.update_status', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var slide_id = $(this).data('id');
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{ route('backend.slide_status') }}',
            data: {
                'status': status,
                'slide_id': slide_id
            },
            success: function(data) {
                console.log('Success Update Slide Status');
            }
        });
    });
</script>
