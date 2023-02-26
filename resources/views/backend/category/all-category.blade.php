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
                        <h3 class="my-2 section-title">Quản lý danh mục sản phẩm</h3>
                    </div>
                    <div class="card-body">

                        <div id="message_cate_pro" style="font-weight:bold"></div>

                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-cate-pro"
                            style="float: right; margin-bottom:15px;margin-right: 7px"><span class="fas fa-plus"></span>
                            Thêm danh mục</a>
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

        <div class="modal fade" id="ajax-cate-pro-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="Title_Category_Product"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="categoryForm" name="categoryForm" class="form-horizontal" enctype="multipart/form-data">
                            <input type="hidden" name="cate_pro_id" id="cate_pro_id">
                            <input type="hidden" id="Category_Image" />
                            <div class="form-group">
                                <label for="name" class="col-sm-6">Tên danh mục sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control category_product_name"
                                        name="category_product_name" placeholder="Enter Tilte" value=""
                                        onkeyup="ChangeToSlug()" id="slug">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-6">Slug danh mục sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control category_product_slug"
                                        name="category_product_slug" placeholder="Enter Tilte" id="convert_slug"
                                        value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-sm-6">Hình ảnh danh mục sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="file" name="category_image" class="form-control category_image"
                                        id="category_image" placeholder="Hình ảnh sản phẩm">
                                    <div class="see_category_image">

                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Mô tả danh mục</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control category_product_desc" name="category_product_desc" id="Ckeditor_Desc" rows="3"
                                        value=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Từ khóa tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control meta_keywords_category" name="meta_keywords_category" rows="3" value=""></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Các danh mục cha</label>
                                <div class="col-sm-12">
                                    <select class="form-control category_parent" name="category_parent">
                                        <option value="0">---Chọn thuộc danh mục---</option>
                                        @foreach ($category_parent as $cateogry)
                                            <option value="{{ $cateogry->id }}">{{ $cateogry->Category_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Hiển thị</label>
                                <div class="col-sm-12">
                                    <select class="form-control category_status" name="category_status">
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
    @include('backend.category.script-cate-pro')
@endsection
