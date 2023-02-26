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
                        <h3 class="my-2 section-title">Quản lý bài viết</h3>
                    </div>
                    <div class="card-body">

                        <div id="message_post" style="font-weight:bold"></div>

                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-post"
                            style="float: right; margin-bottom:15px;margin-right: 7px"><span class="fas fa-plus"></span>
                            Thêm bài viết</a>
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

        <div class="modal fade" id="ajax-post-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="Title_Post"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="postForm" name="postForm" class="form-horizontal">
                            <input type="hidden" name="post_id" id="post_id">
                            <input type="hidden" id="Image_Post_Hidden" />
                            <div class="form-group">
                                <label class="col-sm-6">Tên bài viết</label>
                                <div class="col-sm-12">
                                    <input type="text" name="post_title" class="form-control post_title"
                                        autocomplete="off" onkeyup="ChangeToSlug()" id="slug"
                                        placeholder="Tên sản phẩm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Slug bài viết</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control post_slug" name="post_slug" class="post_slug"
                                        id="convert_slug" placeholder="Slug sản phẩm">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Mô tả bài viết</label>
                                <div class="col-sm-12">
                                    <textarea style="resize: none" rows="8" class="form-control" name="post_desc" class="post_desc" id="Ckeditor_Desc"
                                        placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Nội dung bài viết</label>
                                <div class="col-sm-12">
                                    <textarea style="resize: none" rows="6" class="form-control post_content" name="post_content"
                                        id="Ckeditor_Content" placeholder="Nội dung bài viết"></textarea>
                                    <p class="error"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Từ khóa tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea style="resize: none" rows="8" class="form-control meta_keywords_post" name="meta_keywords_post"
                                        placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Mô tả tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea style="resize: none" rows="8" class="form-control meta_desc_post" name="meta_desc_post"
                                        id="Ckeditor_Desc_Meta" placeholder="Mô tả sản phẩm"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Hình ảnh sản phẩm</label>
                                <div class="col-sm-12">
                                    <input type="file" name="post_image" class="form-control post_image"
                                        id="post_image" placeholder="Tên sản phẩm">
                                    <div class="see_post_image">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Danh mục bài viết</label>
                                <div class="col-sm-12">
                                    <select name="cate_post_id" class="form-control cate_post_id">
                                        <option value="">Chọn danh mục bài viết</option>
                                        @foreach ($category_post as $key => $post)
                                            <option value="{{ $post->Cate_Post_ID }}">{{ $post->Cate_Post_Name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Hiển thị</label>
                                <div class="col-sm-12">
                                    <select name="post_status" class="form-control post_status">
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
    @include('backend.post.script-post')
@endsection
