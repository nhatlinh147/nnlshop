@extends('backend.admin-layout')
@section('link')
    <!-- Css dataTables -->
    <link rel="stylesheet" href="{{asset('public/BackEnd/css/dataTables.bootstrap4.css')}}" type="text/css"/>
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
                        <p>This example shows DataTables and the Buttons extension being used with the Bootstrap 4 framework providing the styling.</p>
                    </div>
                    <div class="card-body">

                        <div id="message_slide" style="font-weight:bold"></div>

                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-slide" style="float: right; margin-bottom:15px;margin-right: 7px"><span class="fas fa-plus"></span>  Thêm slide</a>
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

        <div class="modal fade" id="ajax-slide-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-small">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="Title_Slide"></h4>
                    </div>
                    <div class="modal-body">
                        <form id="slideForm" name="slideForm" class="form-horizontal">
                        <input type="hidden" name="slide_id" id="slide_id">
                        <input type="hidden" id="Image_Slide_Hidden"/>
                            <div class="form-group">
                                <label class="col-sm-6">Tiêu đề slide</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control slide_title" name="slide_title" placeholder="Enter Tilte">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Hình ảnh slide</label>
                                <div class="col-sm-12">
                                    <input type="file" name="slide_image" class="form-control slide_image"
                                id="slide_image" placeholder="Hình ảnh slide">
                                    <div class="see_slide_image">

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Mô tả slide</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control slide_desc" name="slide_desc" id="Ckeditor_Desc" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Nội dung nút slide more</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control slide_more" name="slide_more" placeholder="Enter Tilte">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-6">Từ khóa tìm kiếm</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control meta_keywords_slide" name="meta_keywords_slide" rows="3" value=""></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-6">Hiển thị</label>
                                <div class="col-sm-12">
                                    <select class="form-control slide_status" name="slide_status">
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
                    width: 700px; /* New width for default modal */
                }
            }

            @media screen and (min-width: 992px) {
                .modal-lg {
                    width: 1200px; /* New width for large modal */
                }
            }
        </style>

    </div>
@endsection
@section('script')
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/BackEnd/js/dataTables.bootstrap4.min.js')}}"></script>
    @include('backend.slide.script-slide')
@endsection
