@extends('backend.admin-layout')
@section('link')
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/bootstrap-tagsinput.css') }}" type="text/css" />

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
                        <h3 class="my-2 section-title">Quản lý sản phẩm</h3>
                        <div class="text-danger font-weight-bold">
                            <style>
                                .arrow li:before {
                                    color: #ff4646f3;
                                    content: "\f00d";
                                }
                            </style>
                            <div id="get_notify_data">
                                <div class="row">
                                    <div class="col-sm-4 column_notify_one">
                                    </div>
                                    <div class="col-sm-4 column_notify_two">
                                    </div>
                                    <div class="col-sm-4 column_notify_three">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div id="message_product" style="font-weight:bold"></div>
                        <a href="javascript:void(0)" class="btn btn-danger ml-3" id="import_product"
                            style="float: left; margin-bottom:15px;margin-right: 7px;font-family: 'Font Awesome 5 Free';font-weight: 900;"><span
                                class="fas fa-file-excel"></span> Nhập</a>

                        <!-- Modal import start -->
                        @include('backend.product.modal-import')
                        <!-- Modal import end -->

                        <a href="javascript:void(0)" class="btn btn-info ml-3" id="create-product"
                            style="float: right; margin-bottom:15px;margin-right: 7px;font-family: 'Font Awesome 5 Free';font-weight: 900;"><span
                                class="fas fa-plus"></span> Thêm sản phẩm</a>

                        <div class="input-group-append be-addon">
                            <button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle"><span
                                    class="fas fa-file-excel"></span> <span class=" fas fa-file-pdf"></span> Xuất</button>
                            <div class="dropdown-menu">
                                <a href="{{ route('backend.export_excel') }}" class="dropdown-item">Excel</a>
                                <a href="{{ route('backend.export_pdf') }}" class="dropdown-item">PDF</a>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table id="example_one" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>

                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="add-button-delete" colspan="2">
                                        </td>
                                        <td colspan="11">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.product.modal-product')

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
    <script src="{{ asset('public/BackEnd/js/bootstrap-tagsinput.min.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('public/BackEnd/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //Hiện Modal nhập tài liệu sản phẩm
            $('#import_product').click(function() {
                $('#import_modal').modal('show');
            });

        }); // END document ready
    </script>
    @include('backend.include.transfer-slug')
    @include('backend.product.script.notify-product')
    @include('backend.product.script.datatable-product')
    @include('backend.product.script.create-product')
    @include('backend.product.script.edit-product')
    @include('backend.product.script.save&validate-product')
    @include('backend.product.script.delete-product')
    @include('backend.product.script.delete-selected-product')
    @include('backend.product.script.status-product')
    @include('backend.product.script.view-document-image')
@endsection
