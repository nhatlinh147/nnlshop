@extends('backend.admin-layout')
@section('link')
    <!-- Css dataTables -->
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/dataTables.bootstrap4.css') }}" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <style>
        td.column_description {
            display: -webkit-box;
            -webkit-line-clamp: 6;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 90px;
            padding: 9px 14px;
        }

        /* td.column_description{
                                                                            display: block;
                                                                            display: -webkit-box;
                                                                            max-width: 400px;
                                                                            height: 16px*1.3*3 !important;
                                                                            margin: 0 auto;
                                                                            line-height: 1.3;
                                                                            -webkit-line-clamp: 3;
                                                                            -webkit-box-orient: vertical;
                                                                            overflow: hidden;
                                                                            text-overflow: ellipsis;
                                                                            background: tomato;
                                                                            color: #fff;
                                                                        } */
    </style>
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="my-2 section-title">Quản lý danh mục bài viết</h3>
                    </div>
                    <div class="card-body">

                        <div id="message_cate_post" style="font-weight:bold"></div>

                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-cate-post"
                            style="float: right; margin-bottom:15px;margin-right: 7px"><span class="fas fa-plus"></span>
                            Thêm danh mục bài viết</a>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="add-button-delete">
                                        </td>
                                        <td colspan="8">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ajax-cate-post-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="Title_Cate_Post"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="CatePostForm" name="CatePostForm" class="form-horizontal">
                            <input type="hidden" name="cate_post_id" id="cate_post_id">
                            <div class="form-group">
                                <label class="col-sm-6">Tên slide</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control cate_post_name" name="cate_post_name"
                                        onkeyup="ChangeToSlug()" id="slug" placeholder="Enter Tilte">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Slug danh mục bài viết</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control cate_post_slug" name="cate_post_slug"
                                        id="convert_slug">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Mô tả danh mục bài viết</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control cate_post_desc" name="cate_post_desc" id="Ckeditor_Desc" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Từ khóa tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control meta_keywords_cate_post" name="meta_keywords_cate_post" rows="3" value=""></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Hiển thị</label>
                                <div class="col-sm-12">
                                    <select class="form-control cate_post_status" name="cate_post_status">
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
    @include('backend.cate_post.script-cate-post')
@endsection
