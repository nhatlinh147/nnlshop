<script>
    $("a[data-target='#submenu-3']").addClass('active');
</script>
@include('backend.include.transfer-slug')
<script>
    $(document).ready(function() {
        var data_cate_pro = $('table.second').DataTable({
            lengthChange: true,
            footer: true,
            language: {
                "emptyTable": "Không có dữ liệu danh mục bài viết"
            },
            ajax: {
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('backend.list_cate_post_json') }}",
            },
            columns: [{
                    "title": `
                    <label class="custom-control custom-checkbox">
                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                        <span class="custom-control-label"></span>
                    </label>`,
                    "data": "Cate_Post_ID",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {

                        return `<label class="custom-control custom-checkbox">
                                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_` +
                            data + `" data-cate_post_id ="` + data + `" >
                                        <span class="custom-control-label"></span>
                                    </label>`;
                    }
                },
                {
                    "title": "Id danh mục bài viết",
                    "data": "Cate_Post_ID",
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
                    "title": "Tên danh mục bài viết",
                    "data": "Cate_Post_Name",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Slug danh mục bài viết",
                    "data": "Cate_Post_Slug",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Mô tả danh mục bài viết",
                    "data": "Cate_Post_Desc",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Ẩn/hiển thị",
                    "data": "Cate_Post_Status",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        if (data == 1) {
                            var value = 'checked';
                        } else {
                            var value = ''
                        }
                        return `<div class="switch-button switch-button-success">
                                <input type="checkbox" ` + value + ` name="switch` + row['Cate_Post_ID'] +
                            `" id="switch` + row['Cate_Post_ID'] + `" data-id="` + row[
                                'Cate_Post_ID'] + `" class="update_status"><span>
                            <label for="switch` + row['Cate_Post_ID'] + `"></label></span>`;
                    }
                },
                {
                    "title": "Ngày thêm",
                    "data": "created_at",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return new Date(data).toLocaleDateString("en-IN");
                    }
                },
                {
                    "title": "Sửa/xóa",
                    "data": "Cate_Post_ID",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-cate-post" data-id="` +
                            data + `">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs delete-cate-post" data-id="` + data +
                            `">Xóa</a>`
                    }
                },
            ],
            columnDefs: [{
                    sortable: false,
                    "class": "index",
                    targets: 0
                },
                {
                    "orderable": true,
                    "targets": 5,
                    'createdCell': function(td, cellData, rowData, row, col) {
                        $(td).addClass('column_description');
                        // $(td).parent('tr').attr('data-id', rowData[0]); // adds the data attribute to the parent this cell row
                    }
                }
            ],
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

        $('#create-cate-post').click(function() {
            $("#CatePostForm").clearValidation();
            //Hidden
            $('#cate_post_id').val('');

            $('#CatePostForm').trigger("reset");
            CKEDITOR.instances['Ckeditor_Desc'].setData('');
            $('#btn-save').val("Thêm danh mục bài viết");
            $('#Title_Cate_Post').html("Thêm danh mục bài viết mới");
            $('#ajax-cate-post-modal').modal('show');
        });

        $('body').on('click', '.edit-cate-post', function() {
            var cate_post_id = $(this).data('id');
            $.get('sua-danh-muc-bai-viet/' + cate_post_id, function(data) {
                $("#CatePostForm").clearValidation();
                $('#Title_Cate_Post').html("Sửa danh mục bài viết");
                $('#Image_Cate_Post_Hidden').val(data.Slide_Image);
                $('#btn-save').val("Lưu danh mục bài viết");
                $('#ajax-cate-post-modal').modal('show');
                $('#cate_post_id').val(data.Cate_Post_ID);
                $('.cate_post_name').val(data.Cate_Post_Name);
                $('.cate_post_slug').val(data.Cate_Post_Slug);
                CKEDITOR.instances['Ckeditor_Desc'].setData(data.Cate_Post_Desc);

                $('.meta_keywords_cate_post').val(data.Meta_Keywords_Cate_Post);
                $('.cate_post_status option[value="' + data.Cate_Post_Status + '"]').attr(
                    'selected', 'selected');
            });
        });

        $('body').on('click', '.delete-cate-post', function() {

            var cate_post_id = $(this).data("id");
            if (confirm("Bạn có chắc muốn xóa danh mục bài viết này không ?")) {
                $.ajax({
                    type: "get",
                    url: SITEURL + "/xoa-danh-muc-bai-viet/" + cate_post_id,
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
    if ($("#CatePostForm").length > 0) {
        $("#CatePostForm").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                cate_post_name: {
                    required: true
                },
                cate_post_slug: {
                    required: true
                },
                // compound rule
                cate_post_desc: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                meta_keywords_cate_post: {
                    required: true
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                cate_post_name: {
                    required: "Tên danh mục bài viết không được để trống"
                },
                cate_post_slug: {
                    required: "Slug danh mục bài viết không được để trống"
                },
                cate_post_desc: {
                    required: "Mô tả danh mục bài viết không được để trống",
                },
                meta_keywords_cate_post: {
                    required: "Từ khóa tìm kiếm không được để trống"
                }
            },
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                $.ajax({
                    data: $("#CatePostForm").serialize(),
                    url: SITEURL + "/luu-danh-muc-bai-viet",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#CatePostForm').trigger("reset");
                        $('#ajax-cate-post-modal').modal('hide');
                        $('#btn-save').html('Lưu slide');
                        var oTable = $('#example').DataTable();
                        oTable.ajax.reload(null, false);
                        if (data.Cate_Post_Name) {
                            if ($('#cate_post_id').val() == false) {
                                $('#message_cate_post').after(
                                    "<div class='alert alert-info message_" + data
                                    .Cate_Post_ID +
                                    "'>Tạo danh mục bài viết: <i class='compareCondition'>" +
                                    data.Cate_Post_Name + "</i> thành công</div>");
                                setTimeout(function() {
                                    $('.message_' + data.Cate_Post_ID).fadeOut()
                                    .remove();
                                }, 10000);
                            } else {
                                $('#message_cate_post').after(
                                    "<div class='alert alert-info message_" + data
                                    .Cate_Post_ID +
                                    "'>Lưu danh mục bài viết: <i class='compareCondition'>" +
                                    data.Cate_Post_Name + "</i> thành công</div>");
                                setTimeout(function() {
                                    $('.message_' + data.Cate_Post_ID).fadeOut()
                                    .remove();
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
        cate_post_id = [];
        $('input[class*="checkbox_"]').each(function() {
            cate_post_id.push($(this).data('cate_post_id'));
        });
        if (check == 1) {
            for (i = 0; i < cate_post_id.length; i++) {
                $('.checkbox_' + cate_post_id[i]).prop('checked', true);
            }
        } else {
            for (i = 0; i < cate_post_id.length; i++) {
                $('.checkbox_' + cate_post_id[i]).prop('checked', false);
            }
        }

        if (check == 1 && $('input[class*="checkbox_"]').prop('checked')) {
            $('.add-button-delete').html(
                '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-cate-post-selected">Xóa</a>'
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
        cate_post_id = [];
        $('input[class*="checkbox_"]').each(function() {
            cate_post_id.push($(this).data('cate_post_id'));
        });
        if (check == 0) {
            $('.title_checkbox').prop('checked', false);
        }
        for (i = 0; i < cate_post_id.length; i++) {
            if ($('.checkbox_' + cate_post_id[i]).is(':checked')) {
                $('.add-button-delete').html(
                    '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-cate-post-selected">Xóa</a>'
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
    $(document).on('click', '.delete-cate-post-selected', function() {
        var ids = [];

        $('input[class*="checkbox_"]').each(function() {
            if ($(this).is(":checked")) {
                ids.push($(this).data('cate_post_id'));
            }
        });
        var count_id = ids.length;
        $.ajax({
            url: '{{ route('backend.delete_cate_post_selected') }}',
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
    $(document).on('click', '.update_status', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var cate_post_id = $(this).data('id');
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{ route('backend.cate_post_status') }}',
            data: {
                'status': status,
                'cate_post_id': cate_post_id
            },
            success: function(data) {
                console.log('Success Update Category Post Status');
            }
        });
    });
</script>
