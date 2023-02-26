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
                    <h4 class="card-header text-center font-weight-bold text-uppercase">Toàn bộ chiến lược khuyến mãi</h4>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Số thứ tự</th>
                                        <th scope="col">Tên chiến dịch</th>
                                        <th scope="col">Hình ảnh chiến dịch</th>
                                        <th scope="col" class="text-center">Thời hạn còn lại</th>
                                        <th scope="col">Ẩn/hiển thị</th>
                                        <th scope="col">Sửa/xóa</th>
                                        <th scope="col">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('backend.special_offer.content_all_special')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="ajax-special-offer-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-small">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="Title_Special_Offer">
                            </h3>
                        </div>
                        <div class="modal-body">
                            <form id="specialForm" name="specialForm" action="javascript:void(0)">
                                @csrf
                                <style>
                                    .modal-title {
                                        color: #71748d;
                                        text-align: center;
                                        width: 100%;
                                        font-weight: normal;
                                        text-transform: uppercase;
                                        font-weight: 600;
                                    }
                                </style>
                                <div id="Add_Special">
                                </div>
                            </form>
                        </div>
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
        function loadAllSpecialProduct(special_id) {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '{{ route('backend.all_special_list_checked') }}',
                data: {
                    'special_id': special_id,
                    '_token': _token
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log('Status special offer is fail');
                    console.log(textStatus + ': ' + errorThrown);
                },
                success: function(data) {
                    $('#specialForm').trigger("reset");
                    $('#ajax-special-offer-modal').modal('show');
                    $('#Title_Special_Offer').html('Chiến dịch: ' + data['special_title']);
                    if (data['output_one'] == '' || data['output_two'] == '') {
                        $('#Add_Special').html(`<div class="card row">
                            <div class="card-body">
                                ${data['output_one'] ? data['output_one'] : data['output_two']}
                                </div>
                        </div>
                        `);
                    } else {
                        $('#Add_Special').html(`<div class="card">
                            <div class="card-body row">
                                <div class="col-sm-6 table-responsive">
                                    ${data['output_one']}
                                </div>
                                <div class="col-sm-6 table-responsive">
                                    ${data['output_two']}
                                </div>
                            </div>
                        </div>
                        `);
                    }
                    if ($('h4.Reduce_Style').length > 0) {
                        $('h4.Reduce_Style').css({
                            'text-align': 'center',
                            'font-weight': '600',
                            'color': '#71748d',
                            'text-transform': 'uppercase'
                        });
                    }
                }
            });
        }

        $(document).on('click', '#SpecialOfferDetail', function() {
            var special_id = $(this).data('id');
            loadAllSpecialProduct(special_id);
        });
        $(document).on('click', '.update_status', function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var special_id = $(this).data('id');
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: '{{ route('backend.special_status') }}',
                data: {
                    'status': status,
                    'special_id': special_id
                },
                success: function(data) {
                    console.log('Success Update Special Status');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log('Status special offer is fail');
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $(document).on('click', 'a.deleteSpecialProduct', function() {
            var pid = $(this).attr('id');
            var arr_pid = pid.split('=');
            var _token = $('input[name="_token"]').val();
            var speProId = arr_pid[0];
            var speId = arr_pid[1];
            var message = 0;
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '{{ route('backend.delete_special_product') }}',
                data: {
                    'speProId': speProId,
                    '_token': _token
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log('Thất bại');
                    console.log(textStatus + ': ' + errorThrown);
                },
                success: function(data) {
                    console.log('Xóa sản phẩm chiến dịch khuyến mãi thành công');
                    loadAllSpecialProduct(speId);
                }
            });

        });
        $(document).on('click', 'a.deleteSpecial', function() {
            var special_id = $(this).data('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '{{ route('backend.delete_special') }}',
                data: {
                    'special_id': special_id,
                    '_token': _token
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log('Thất bại');
                    console.log(textStatus + ': ' + errorThrown);
                },
                complete: function(data) {
                    console.log('Xóa chiến dịch khuyến mãi thành công');
                    location.reload();
                }
            });

        });
        $(document).on('focus', 'td.editTablePrice', function() {
            var special_price = $(this).data('price');
            var special_id = $(this).attr('id');
            $('#' + special_id).text(special_price);
        });

        $(document).on('blur', 'td.editTablePrice', function() {
            var contentedit = $(this).text();
            var arr_pid = $(this).attr('id').split('__');
            var speProId = arr_pid[0];
            var speId = arr_pid[1];
            var form = Number(arr_pid[2]);
            var mess_done = 0;
            var _token = $('input[name="_token"]').val();

            var reg_one = /^[1-9]?[0-9]{1}$|^100$/; // số nằm trong khoảng 1 hoặc 100
            var reg_two = /^[1-9][0-9]{3,7}$/; //// số có 4 đến 8 chữ số và không có số 0 ở phần đầu
            if (form == 1 && reg_one.test(contentedit) == false) {
                contentedit = $(this).data('price');
                alert("Phần trăm giảm chỉ được nằm trong khoảng từ 1 đến 100. Xin nhập lại");
            } else if (form == 2 && reg_two.test(contentedit) == false) {
                contentedit = $(this).data('price');
                alert("Phần trăm giảm là chỉ được có 4 đến 8 chữ số và không có số 0 ở phần đầu. Xin nhập lại !");
            } else {
                alert("Cập nhật thành công");
            }

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '{{ route('backend.special_product_change_price') }}',
                data: {
                    'contentedit': contentedit,
                    'speProId': speProId,
                    '_token': _token
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log('Thất bại');
                    console.log(textStatus + ': ' + errorThrown);
                },
                complete: function(data) {
                    loadAllSpecialProduct(speId);
                }
            });

        });

        // $(document).on('blur', 'td.editTablePrice', function() {
        //     var special_price = $(this).data('price');
        //     var special_id = $(this).attr('id');
        //     $('#' + special_id).text(special_price);
        //     // $.ajax({
        //     //     type: 'post',
        //     //     dataType: 'json',
        //     //     url: '{{ route('backend.delete_special') }}',
        //     //     data: {
        //     //         'special_id': special_id,
        //     //         '_token': _token
        //     //     },
        //     //     error: function(jqXHR, textStatus, errorThrown) {
        //     //         // When AJAX call has failed
        //     //         console.log('Thất bại');
        //     //         console.log(textStatus + ': ' + errorThrown);
        //     //     },
        //     //     complete: function(data) {
        //     //         console.log('Xóa chiến dịch khuyến mãi thành công');
        //     //         location.reload();
        //     //     }
        //     // });

        // });
    </script>
@endsection
