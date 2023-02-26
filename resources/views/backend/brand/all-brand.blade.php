@extends('backend.admin-layout')
@section('link')
    <!-- Css dataTables -->
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/dataTables.bootstrap4.css') }}" type="text/css" />
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
                        <h3 class="my-2 section-title">Quản lý thương hiệu sản phẩm</h3>
                    </div>
                    <div class="card-body">
                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-brand-pro"
                            style="float: right; margin-bottom:15px;margin-right: 7px"><span class="fas fa-plus"></span>
                            Thêm thương hiệu</a>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ajax-brand-pro-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="Title_Brand_Product"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="BrandForm" name="BrandForm" class="form-horizontal">
                            <input type="hidden" name="brand_pro_id" id="brand_pro_id">
                            <div class="form-group">
                                <label for="name" class="col-sm-6">Tên thương hiệu sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control brand_product_name" name="brand_product_name"
                                        placeholder="Nhập vào tên thương hiệu" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-6">Slug thương hiệu sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control brand_product_slug" name="brand_product_slug"
                                        placeholder="Nhập vào slug" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Mô tả thương hiệu</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control brand_product_desc" name="brand_product_desc" id="Ckeditor_Desc" rows="3"
                                        value=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Từ khóa tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control meta_keywords_brand" name="meta_keywords_brand" rows="3" value=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Các thương hiệu cha</label>
                                <div class="col-sm-12">
                                    <select class="form-control brand_parent" name="brand_parent">
                                        <option value="0">---Chọn thuộc thương hiệu---</option>
                                        @foreach ($brand_parent as $value)
                                            <option value="{{ $value->Brand_ID }}">{{ $value->Brand_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Hiển thị</label>
                                <div class="col-sm-12">
                                    <select class="form-control brand_status" name="brand_status">
                                        <option value="0">Ẩn</option>
                                        <option selected value="1">Hiển thị</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" class="btn btn-primary" id="btn-save" value="Save changes" />
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <style>
            @media screen and (min-width: 768px) {
                .modal-dialog {
                    width: 700px;
                    /* New width for default modal */
                }
            }

            @media screen and (min-width: 992px) {
                .modal-lg {
                    width: 1200px;
                    /* New width for large modal */
                }
            }
        </style>

    </div>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/BackEnd/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        //Làm nổi bật phần menu được chọn
        $("a[data-target='#submenu-2']").addClass('active');
    </script>

    <script>
        $(document).ready(function() {
            var data_brand_pro = $('table.second').DataTable({
                lengthChange: true,
                ajax: {
                    "type": "GET",
                    "url": "{{ route('backend.all_brand_json') }}",
                },
                columns: [{
                        "title": "Id thương hiệu",
                        "data": "Brand_ID",
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
                        "title": "Tên thương hiệu",
                        "data": "Brand_Name",
                        "visible": true,
                        "searchable": true
                    },
                    {
                        "title": "Slug thương hiệu",
                        "data": "Brand_Product_Slug",
                        "visible": true,
                        "searchable": true
                    },
                    {
                        "title": "Thuộc thương hiệu",
                        "data": "Brand_Parent",
                        "visible": true,
                        "searchable": true,
                        render: function(data, type, row) {
                            if (data == 0) {
                                var value = '<span style="color:red;">Thương hiệu cha</span>';
                            } else {
                                @foreach ($brand_parent as $key => $subbrand)

                                    if (data == {{ $subbrand->Brand_ID }}) {
                                        var value =
                                            `<span style="color:green;">{{ $subbrand->Brand_Name }}</span>`;
                                    }
                                @endforeach
                            }
                            return value;
                        }
                    },
                    {
                        "title": "Ẩn/hiển thị",
                        "data": "Brand_Status",
                        "visible": true,
                        "searchable": true,
                        render: function(data, type, row) {
                            if (data == 1) {
                                var value = 'checked';
                            } else {
                                var value = ''
                            }
                            return `<div class="switch-button switch-button-success">
                                    <input type="checkbox" ` + value + ` name="switch` + row['Brand_ID'] +
                                `" id="switch` + row['Brand_ID'] + `" data-id="` + row['Brand_ID'] + `" class="update_status"><span>
                                <label for="switch` + row['Brand_ID'] + `"></label></span>`;
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
                        "title": "Sửa xóa",
                        "data": "Brand_ID",
                        "visible": true,
                        "searchable": true,
                        render: function(data, type, row) {
                            return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-brand-product" data-id="` +
                                data +
                                `">Sửa</a>
                            <a href="javascript:void(0)" class="btn btn-danger btn-xs delete-brand-product" data-id="` +
                                data + `">Xóa</a>`
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
            data_brand_pro.on('order.dt search.dt', function() {
                data_brand_pro.column(1, {
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

            $('#create-brand-pro').click(function() {
                $('#brand_pro_id').val('');
                $('#BrandForm').trigger("reset");
                CKEDITOR.instances['Ckeditor_Desc'].setData('');
                $('#btn-save').val("Thêm thương hiệu");
                $('#Title_Brand_Product').html("Thêm thương hiệu mới");
                $('#ajax-brand-pro-modal').modal('show');
            });

            $('body').on('click', '.edit-brand-product', function() {
                var brand_pro_id = $(this).data('id');
                $.get('sua-thuong-hieu-san-pham/' + brand_pro_id, function(data) {
                    //  $('#title-error').hide();
                    //  $('#product_code-error').hide();
                    //  $('#description-error').hide();
                    $('#Title_Brand_Product').html("Sửa thương hiệu sản phẩm");
                    $('#btn-save').val("Lưu thương hiệu");
                    $('#ajax-brand-pro-modal').modal('show');
                    $('#brand_pro_id').val(data.Brand_ID);
                    $('.brand_product_name').val(data.Brand_Name);
                    $('.brand_product_slug').val(data.Brand_Product_Slug);
                    CKEDITOR.instances['Ckeditor_Desc'].setData(data.Brand_Desc);
                    // CKEDITOR.instances['Ckeditor_Desc'].updateElement();
                    $('.meta_keywords_brand').val(data.Meta_Keywords_Brand);
                    $('.brand_parent option[value="' + data.Brand_Parent + '"]').attr('selected',
                        'selected');
                    $('.brand_status option[value="' + data.Brand_Status + '"]').attr('selected',
                        'selected');
                });
            });

            $('body').on('click', '.delete-brand-product', function() {

                var brand_pro_id = $(this).data("id");
                if (confirm("Bạn có chắc muốn xóa danh mục sản phẩm này không ?")) {
                    $.ajax({
                        type: "get",
                        url: SITEURL + "/xoa-thuong-hieu-san-pham/" + brand_pro_id,
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
        if ($("#BrandForm").length > 0) {
            $("#BrandForm").validate({
                ignore: [],
                rules: {
                    // simple rule, converted to {required:true}
                    brand_product_name: {
                        required: true
                    },
                    // compound rule
                    brand_product_slug: {
                        required: true,
                        minlength: 4
                    },
                    brand_product_desc: {
                        required: function(textarea) {
                            CKEDITOR.instances[textarea.id].updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        }
                    },
                    meta_keywords_brand: {
                        required: true
                    }
                },
                messages: {
                    // simple rule, converted to {required:true}
                    brand_product_name: {
                        required: "Tên danh mục sản phẩm không được để trống"
                    },
                    // compound rule
                    brand_product_slug: {
                        required: "Slug danh mục sản phẩm không được để trống",
                        minlength: "Slug danh mục sản phẩm cần ít nhất 4 ký tự"
                    },
                    brand_product_desc: {
                        required: "Mô tả danh mục sản phẩm không được để trống",
                    },
                    meta_keywords_brand: {
                        required: "Từ khóa tìm kiếm không được để trống"
                    }
                },
                submitHandler: function(form) {
                    var actionType = $('#btn-save').val();
                    $('#btn-save').html('Sending..');

                    $.ajax({
                        data: $('#BrandForm').serialize(),
                        url: SITEURL + "/luu-thuong-hieu-san-pham",
                        type: "POST",
                        dataType: 'json',
                        success: function(data) {
                            $('#BrandForm').trigger("reset");
                            $('#ajax-brand-pro-modal').modal('hide');
                            $('#btn-save').html('Lưu danh mục');
                            var oTable = $('table.second').DataTable();
                            oTable.ajax.reload(null, false);
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
            var brand_id = $(this).data('id');
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '{{ route('backend.brand_status') }}',
                data: {
                    'status': status,
                    'brand_id': brand_id
                },
                success: function(data) {
                    console.log('success');
                }
            });
        });
    </script>
@endsection
