@extends('backend.admin-layout')
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <h3 class="my-2 section-title">Tạo chiến dịch khuyến mãi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <form role="form" action="#" method="get" id="Form_Special_Offer"> --}}
                        <form role="form" action="{{ route('backend.save_special') }}" method="post"
                            id="Form_Special_Offer" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="Count_Percent" value="0" />
                            <input type="hidden" class="Count_Reduce" value="0" />
                            <input type="hidden" class="Mediate_Checked_Percent" value="0" />
                            <input type="hidden" class="Mediate_Checked_Reduce" value="0" />
                            <input type="hidden" class="special_product_json" name="special_product_json" value="0" />

                            <div class="form-group">
                                <label for="inputText3" class="col-form-label font-weight-bold">Tiêu đề chiến dịch khuyến
                                    mãi</label>
                                <input type="text" class="form-control" name="special_title" class="special_title"
                                    onkeyup="ChangeToSlug()" id="slug">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-form-label font-weight-bold">Slug chiến dịch khuyến
                                    mãi</label>
                                <input type="text" class="form-control special_slug" name="special_slug"
                                    id="convert_slug">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-form-label font-weight-bold">Hình ảnh sản
                                    phẩm</label>
                                <input type="file" name="special_image" class="form-control special_image"
                                    id="special_image" placeholder="Hình ảnh sản phẩm">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-form-label font-weight-bold">Ngày bắt đầu</label>
                                <input type="text" name="special_start" class="form-control" id="special_start"
                                    placeholder="Ngày bắt đầu">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="col-form-label font-weight-bold">Ngày kết
                                    thúc</label>
                                <input type="text" name="special_end" class="form-control" id="special_end"
                                    placeholder="Ngày kết thúc">
                            </div>

                            <div class="form-group">
                                <label class="col-form-label font-weight-bold">Chọn theo điều kiện</label>
                                <select name="special_number" class="form-control input-sm m-bot15 special_number">
                                    <option value="" selected>---Chọn---</option>
                                    <option id="Reduce_Percent" value="1">Giảm theo phần trăm</option>
                                    <option id="Reduce_Money" value="2">Giảm theo tiền</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-select" class="col-form-label font-weight-bold">Ẩn/Hiển thị</label>
                                <select name="special_status" class="form-control input-sm m-bot15" id="input-select">
                                    <option value="0">Ẩn</option>
                                    <option selected value="1">Hiển thị</option>
                                </select>
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                style="display:flex;justify-content: center">
                                <button class="btn btn-primary" type="submit">Tạo chiến dịch</button>
                            </div>
                        </form>

                        <div class="modal fade" id="ajax-special-offer-modal" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-small">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="Title_Special_Offer">
                                        </h3>
                                    </div>
                                    <div id="overlay">
                                        <div class="cv-spinner">
                                            <span class="spinner"></span>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <form id="specialForm" name="specialForm" action="javascript:void(0)"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="special_condition" id="special_condition" />

                                            <style>
                                                @media (min-width: 992px) {
                                                    .modal-dialog {
                                                        max-width: 1000px;
                                                    }
                                                }

                                                .modal-title {
                                                    color: #71748d;
                                                    text-align: center;
                                                    width: 100%;
                                                    font-weight: normal;
                                                    text-transform: uppercase;
                                                    font-weight: 600;
                                                }
                                            </style>

                                            <div class="row _others" style="margin: 10px 25px;align-items: end">
                                            </div>
                                            <div class="row" style="margin: 0px 25px">
                                                <div class="col-sm-6">
                                                    {{-- @php
                                                        $column_one = App\Model\Product::count()/2;
                                                        $column_two = App\Model\Product::count();
                                                    @endphp --}}
                                                    {{-- @foreach (DB::table('tbl_product')->offset(0)->limit($column_one)->get() as $value)
                                                        <input type="checkbox" id="{{$value->Product_Slug}}" data-chkbox-shiftsel="checkbox" name="checkbox[]" value="">
                                                        <label for="{{$value->Product_Slug}}">{{$value->Product_Name}}</label><br>
                                                        <input type="hidden" id="Price_{{$value->Product_Slug}}" value="{{$value->Product_Price}}"/>
                                                    @endforeach --}}
                                                </div>
                                                <div class="col-sm-6">
                                                    {{-- @foreach (DB::table('tbl_product')->offset($column_one)->limit($column_two)->get() as $value)
                                                        <input type="checkbox" id="{{$value->Product_Slug}}" data-chkbox-shiftsel="checkbox" name="checkbox[]" value="">
                                                        <label for="{{$value->Product_Slug}}">{{$value->Product_Name}}</label><br>
                                                        <input type="hidden" id="Price_{{$value->Product_Slug}}" value="{{$value->Product_Price}}"/>
                                                    @endforeach --}}
                                                </div>
                                                <div class="SubmitSpecialConditionDiv"></div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="Add_Special">
                </div>

            </div>
            <div id="Wait">
                <!-- Place at bottom of page -->
            </div>
        @endsection
        @section('script')
            <script src="{{ asset('public/BackEnd/js/jquery.checkbox-shift-selector.js?update=17012022') }}"></script>
            @include('backend.include.transfer-slug')

            <script>
                $.validator.addMethod("checkedProductSelect", function() {
                    return localStorage.getItem('Mediate_Checked_Percent') !== null && localStorage.getItem(
                        'Mediate_Checked_Reduce') !== null
                }, "Bạn phải sản phẩm theo hình thức khuyến mãi. Xin hãy lựa chọn lại");

                $("#Form_Special_Offer").validate({
                    rules: {
                        special_title: {
                            required: true
                        },
                        special_slug: {
                            required: true,
                        },
                        special_image: {
                            required: true,
                            accept: "image/*"
                        },
                        special_start: {
                            required: true,
                            dateITA: true
                        },
                        special_end: {
                            required: true,
                            dateITA: true
                        },
                        special_number: {
                            checkedProductSelect: true
                        }
                    },
                    messages: {
                        special_title: {
                            required: "Tiêu đề chiến dịch khuyến mãi không được để trống"
                        },
                        special_slug: {
                            required: "Slug chiến dịch khuyến mãi không được để trống"
                        },
                        special_image: {
                            required: "Hình ảnh chiến dịch khuyến mãi không được để trống",
                            accept: "File nhập vào phải là file hình ảnh"
                        },
                        special_start: {
                            required: "Ngày bắt đầu chiến dịch khuyến mãi không được để trống",
                            dateITA: "Ngày bắt đầu không là định dạng ngày. Xin nhập lại"
                        },
                        // compound rule
                        special_end: {
                            required: "Ngày kết thúc chiến dịch khuyến mãi không được để trống",
                            dateITA: "Ngày kết thúc không là định dạng ngày. Xin nhập lại"
                        }
                    }
                });
            </script>
            <script>
                $('#ajax-special-offer-modal').on('hidden.bs.modal', function() {
                    $('select.special_number').val('');
                    //Xóa đi PRODUCT_CHECK để phòng trường hợp [checked Product] chạy ẩn các sản phẩm đã chọn
                    localStorage.removeItem('PRODUCT_CHECK');
                });
                $(document).ready(function() {
                    localStorage.clear();
                    // fuction show content when button is [Xác Nhận]
                    function _function_one_(get_change) {
                        var content_one = get_change == 1 ? "Phần trăm giảm" : "Số tiền giảm";
                        var class_id = get_change == 1 ? "Percent_Money" : "Reduce_Money_";
                        var _string = `<div class="col-md-4 form-group">
                        <label class="font-weight-bold">${content_one}: </label>
                        <input type="number" class="form-control" placeholder="Nhập ${content_one.toLowerCase()}" name="${class_id}" id="${class_id}" class="${class_id}"/>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Tìm kiếm: </label>
                        <input type="text" class="form-control searchByName" id="SEARCH_${get_change}" placeholder="Tìm kiếm sản phẩm"/>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="font-weight-bold">Sắp xếp</label>
                        <select class="form-control" id="sort_by">
                            <option value="0">Sắp xếp theo</option>
                            <option value="1">Theo A-Z</option>
                            <option value="2">Theo Z-A</option>
                            <option value="3">Theo giá tăng</option>
                            <option value="4">Theo giá giảm</option>
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="display:flex;justify-content: center">
                        <button class="btn btn-primary" type="submit" id="ConfirmOfferButton" data-status="1">Thêm vào</button>
                    </div>
                    <div class="js-errors"></div>
                    `;
                        if (get_change == 1) {
                            $('#ajax-special-offer-modal').modal('show');
                            $('#specialForm').trigger("reset");
                            $('#special_condition').val(get_change);
                            $('._others').html(_string);
                        } else if (get_change == 2) {
                            $('#ajax-special-offer-modal').modal('show');
                            $('#specialForm').trigger("reset");
                            $('#special_condition').val(get_change);
                            $('._others').html(_string);
                        }
                        $('#Title_Special_Offer').text('Lựa chọn sản phẩm khuyến mãi');
                    }
                    // fuction show content when button is [Thêm vào]

                    function load_product(data) {
                        $('.modal-body .col-sm-6').eq(0).empty();
                        $('.modal-body .col-sm-6').eq(1).empty();
                        var str1 = ``;
                        var str2 = ``;
                        for (let i = 0; i < data.length; i++) {
                            if (i >= 0 && i < Math.floor(data.length / 2)) {
                                str1 += `
                        <input type="checkbox" class="regular-checkbox" id="${data[i].Product_Slug}" data-chkbox-shiftsel="checkbox" name="checkbox[]" value="">
                        <label for="${data[i].Product_Slug}" class="checkbox-label">${data[i].Product_Name}</label>
                        <input type="hidden" id="Price_${data[i].Product_Slug}" value="${data[i].Product_Price}"/><br>
                        `;
                            } else {
                                str2 += `
                        <input type="checkbox" class="regular-checkbox" id="${data[i].Product_Slug}" data-chkbox-shiftsel="checkbox" name="checkbox[]" value="">
                        <label for="${data[i].Product_Slug}" class="checkbox-label">${data[i].Product_Name}</label>
                        <input type="hidden" id="Price_${data[i].Product_Slug}" value="${data[i].Product_Price}"/><br>
                        `;
                            }

                        }
                        $('.modal-body .col-sm-6').eq(0).html(str1);
                        $('.modal-body .col-sm-6').eq(1).html(str2);
                    }

                    function declare_variable() {
                        var getMediatePercent = localStorage.getItem('Mediate_Checked_Percent') === null ? 0 :
                            localStorage.getItem('Mediate_Checked_Percent');
                        var getMediateReduce = localStorage.getItem('Mediate_Checked_Reduce') === null ? 0 :
                            localStorage.getItem('Mediate_Checked_Reduce');
                        var get_condition = $('input#special_condition').val();
                        var include = {
                            ["getCondition_Selected"]: get_condition,
                            ["getLocal_CheckedPercent"]: getMediatePercent,
                            ["getLocal_CheckedReduce"]: getMediateReduce
                        };
                        return include;
                    }

                    function checked_product() {
                        var new_arr = [];
                        $('input[type="checkbox"]').each(function() {
                            if ($(this).is(':checked')) {
                                var get_id = $(this).attr('id');
                                new_arr.push(get_id);
                            }
                        });
                        return new_arr;
                    }
                    $(document).on('click', '#ajax-special-offer-modal input[type="checkbox"]', function() {
                        localStorage.setItem('PRODUCT_CHECK', JSON.stringify(checked_product()));
                    });
                    $(".special_number").on('change', function() {
                        sessionStorage.clear(); //Xóa toàn bộ session
                        var get_change = $(this).val();

                        var declare = declare_variable();
                        var getMediatePercent = declare["getLocal_CheckedPercent"];
                        var getMediateReduce = declare["getLocal_CheckedReduce"];

                        $('#specialForm').on('reset', function() {
                            $('.special_price_product').remove(); //Xóa giá sản phẩm ở điều kiện thứ 3.
                            var _token = $('input[name="_token"]').val();
                            $body = $("body");
                            //Load toàn bộ sản phẩm
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                async: false,
                                url: '{{ route('backend.all_product_special') }}',
                                beforeSend: function() {
                                    $body.addClass("loading");
                                },
                                complete: function() {
                                    $body.removeClass("loading");
                                },
                                data: {
                                    '_token': _token,
                                    'getMediatePercent': getMediatePercent,
                                    'getMediateReduce': getMediateReduce
                                },
                                success: function(data) {
                                    setTimeout(function() {
                                        if (get_change == 1) {
                                            getMediatePercent == 0 ? load_product(data[
                                                    'output']) :
                                                load_product(data['output_one']);
                                        } else if (get_change == 2) {
                                            getMediateReduce == 0 ? load_product(data[
                                                    'output']) :
                                                load_product(data['output_two']);
                                        }
                                        $("#overlay").fadeOut(400);
                                    }, 800);
                                }
                            });
                        });
                        _function_one_(get_change);
                    });

                    //Tìm kiếm bằng ajax
                    $(document).on('keyup', '.searchByName', function() {
                        var search = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        var get_change = $('#sort_by').val();

                        var declare = declare_variable();
                        var get_condi = declare["getCondition_Selected"];
                        var getMediatePercent = declare["getLocal_CheckedPercent"];
                        var getMediateReduce = declare["getLocal_CheckedReduce"];

                        $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: '{{ route('backend.search_product_special') }}',
                            data: {
                                'search': search,
                                '_token': _token,
                                'get_change': get_change,
                                'getMediatePercent': getMediatePercent,
                                'getMediateReduce': getMediateReduce
                            },
                            success: function(data) {
                                if (get_condi == 1) {
                                    getMediatePercent == 0 ? load_product(data['output']) :
                                        load_product(data['output_one']);
                                } else if (get_condi == 2) {
                                    getMediateReduce == 0 ? load_product(data['output']) :
                                        load_product(data['output_two']);
                                }
                                var parsePRODUCT_CHECK = JSON.parse(localStorage.getItem(
                                    'PRODUCT_CHECK'));
                                parsePRODUCT_CHECK.forEach(element => {
                                    $('input#' + element).prop('checked', true);
                                });
                            }
                        });

                    });

                    $(document).on('change', '#sort_by', function() {
                        var get_change = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        var search = $('input.searchByName').val();

                        var declare = declare_variable();
                        var get_condi = declare["getCondition_Selected"];
                        var getMediatePercent = declare["getLocal_CheckedPercent"];
                        var getMediateReduce = declare["getLocal_CheckedReduce"];

                        $.ajax({
                            type: 'post',
                            dataType: 'json',
                            url: '{{ route('backend.search_product_special') }}',
                            data: {
                                'get_change': get_change,
                                'search': search,
                                '_token': _token,
                                'getMediatePercent': getMediatePercent,
                                'getMediateReduce': getMediateReduce
                            },
                            success: function(data) {
                                if (get_condi == 1) {
                                    getMediatePercent == 0 ? load_product(data['output']) :
                                        load_product(data['output_one']);
                                } else if (get_condi == 2) {
                                    getMediateReduce == 0 ? load_product(data['output']) :
                                        load_product(data['output_two']);
                                }
                                var parsePRODUCT_CHECK = JSON.parse(localStorage.getItem(
                                    'PRODUCT_CHECK'));
                                parsePRODUCT_CHECK.forEach(element => {
                                    $('input#' + element).prop('checked', true);
                                });
                            }
                        });
                    });

                    $("#specialForm").validate({
                        errorLabelContainer: $("#specialForm div.js-errors"),
                        ignore: [],
                        rules: {
                            // simple rule, converted to {required:true}
                            Percent_Money: {
                                required: true,
                                range: [0, 100]
                            },
                            Reduce_Money_: {
                                required: true,
                                number: true
                            }
                        },
                        messages: {
                            // simple rule, converted to {required:true}
                            Percent_Money: {
                                required: "Phần trăm giảm không được để trống",
                                range: "Phần trăm tiền giảm phải là chuỗi số trong khoảng khoảng 0% - 100%"
                            },
                            Reduce_Money_: {
                                required: "Số tiền giảm không được để trống",
                                number: "Số tiền giảm giá phải là kiểu số"
                            }
                        }
                    });

                    $(document).on('click', '#ConfirmOfferButton', function() {
                        if ($('#specialForm').valid()) {
                            var new_arr = [];
                            var array_checked = [];
                            var local_checked = [];
                            var session_checked = [];
                            var get_change = $('#special_condition').val();
                            var get_status = $(this).attr('data-status');
                            var style_contentOrbutton = 'w-100 d-block my-3 text-center';

                            if (get_status == 1) {

                                // Đổi sang thuộc tính button quay lại
                                $('#ConfirmOfferButton').attr('data-status', 2);
                                $('#ConfirmOfferButton').html(
                                    '<span class="fas fa-arrow-left"></span>&emsp;Quay lại');
                                $(this).removeClass("btn-primary").addClass("btn-danger");

                                //Css, text, html nội dung hiển thị của button
                                if ($('input[type="checkbox"]').is(':checked') == false) {
                                    $('.js-errors').addClass(style_contentOrbutton);
                                    $('.js-errors').html(
                                        '<p style="font-size:1.5rem;font-weight:bold;text-align: center;">Bạn chưa lựa chọn sản phẩm. Xin hãy quay lại</p>'
                                    )
                                } else {
                                    $('.SubmitSpecialConditionDiv').addClass(style_contentOrbutton);
                                    $('.SubmitSpecialConditionDiv').html(`
                            <button class="btn btn-success" type="submit" id="SubmitSpecialCondition">Xác nhận</button>
                       `);

                                    $_str = get_change == 1 ? 'Percent_Money' : 'Reduce_Money_';
                                    sessionStorage.setItem('PRICE', $('#' + $_str).val());

                                    //Thiết lập lưu checked vào session
                                    $('input[type="checkbox"]').each(function() {
                                        if ($(this).is(':checked')) {
                                            var getIdProduct = $(this).attr('id');
                                            session_checked.push($('label[for="' +
                                                getIdProduct + '"]').text());
                                        }
                                    });
                                    sessionStorage.setItem('CHECKED', JSON.stringify(session_checked));

                                    $('._others .col-md-4').remove();
                                    $('#Title_Special_Offer')
                                        .text('Danh sách vừa chọn');
                                }
                            } else {
                                $('#ConfirmOfferButton').attr('data-status', 1);
                                $(this).text('Thêm vào');

                                // Khi click vào button[Quay Lại] thì khôi phục lại class="row _others"
                                _function_one_(get_change);

                                //Xóa class
                                $('.js-errors').removeClass(style_contentOrbutton);
                                $('.SubmitSpecialConditionDiv').removeClass(style_contentOrbutton);

                                //Reset
                                $('.js-errors').empty();
                                $('.SubmitSpecialConditionDiv').empty();

                                array_checked = Object.values(sessionStorage);

                                sessionStorage.clear();

                                $(this).removeClass("btn-danger").addClass("btn-primary");
                                var _token = $('input[name="_token"]').val();
                            }

                            $('input[type="checkbox"]').each(function() {
                                if ($(this).is(':checked')) {
                                    var get_id = $(this).attr('id');
                                    new_arr.push(get_id);
                                }
                            });
                            var str1 = ``;
                            var str2 = ``;

                            for (let i = 0; i < new_arr.length; i++) {
                                if (i >= 0 && i < Math.floor(new_arr.length / 2)) {
                                    str1 += '<li>' + $('label[for="' + new_arr[i] + '"]').text() +
                                        '</li>';
                                } else {
                                    str2 += '<li>' + $('label[for="' + new_arr[i] + '"]').text() +
                                        '</li>';
                                }
                            }

                            $('.modal-body .col-sm-6').eq(0).html(
                                '<ul class="list-unstyled arrow mx-2" style="font-size:1rem">' +
                                str1 +
                                '</ul>');
                            $('.modal-body .col-sm-6').eq(1).html(
                                '<ul class="list-unstyled arrow mx-2" style="font-size:1rem">' +
                                str2 +
                                '</ul>');
                        }
                    }); // END fuction before and after click button [Xác nhận][Quay lại]

                    // $(document).on('click', '#SubmitSpecialCondition', function() {
                    //     var arr_val = JSON.parse(sessionStorage.getItem('CHECKED'));
                    //     for (let i = 0; i < arr_val.length; i++) {
                    //         localStorage.setItem((Math.random() + 1).toString(36).substring(7), arr_val[i]);
                    //     }
                    // });

                }); // END document ready
            </script>
            <script>
                function unique_arr(arr) {
                    let newArr = arr.reduce(function(accumulator, element) {
                        if (accumulator.indexOf(element) === -1) {
                            accumulator.push(element)
                        }
                        return accumulator
                    }, [])
                    return newArr
                }

                function jsonObjectToAssociateArray(obj) {
                    var mediate = [];
                    obj.forEach(element => {
                        JSON.parse(element).map(function(item) {
                            mediate.push(item);
                        });
                    });
                    return mediate;
                }

                function transmitToArrayNumber(array) {
                    var number = [];
                    var string = [];
                    var mediate = [];
                    array.forEach(element => {
                        if (typeof element === 'string') {
                            mediate = element.split(",");
                            for (let i = 0; i < mediate.length; i++) {
                                string.push(Number(mediate[i]));
                            }
                        } else if (typeof element === 'number') {
                            number.push(element);
                        }
                    });
                    var concat = string.concat(number);
                    return concat;
                }

                $(document).on('click', '#SubmitSpecialCondition', function() {
                    var get_change = $('#special_condition').val();
                    var idArrayPercent = 0;
                    var idArrayReduce = 0;
                    var mediate_percent = [];
                    var mediate_reduce = [];

                    var jsonStr =
                        '{"keyPercent":[],"keyPercentChecked":[],"keyPercentPrice":[],"keyReduce":[],"keyReduceChecked":[],"keyReducePrice":[]}';
                    var obj = JSON.parse(jsonStr);
                    var array_local_percent = 0;
                    var array_local_reduce = 0;

                    if (get_change == 1) {
                        var countArrayPercent = [];
                        var countPercent = $('input.Count_Percent').val(); //lấy giá trị hiện tại
                        countPercent == '0' ? countArrayPercent : countArrayPercent.push(
                            countPercent); // đưa vào mảng mới
                        // lấy phần tử cuối cùng chuyển thành number + 1 rồi push vào mảng
                        var idArrayPercent = Number(countPercent[countPercent.length - 1]) + 1;
                        countArrayPercent.push(idArrayPercent);
                        $('input.Count_Percent').val(countArrayPercent);

                        localStorage.setItem('COUNT_PERCENT', JSON.stringify(transmitToArrayNumber(countArrayPercent)));
                        localStorage.setItem('CHECKED_PERCENT_' + idArrayPercent, sessionStorage.getItem('CHECKED'));
                        localStorage.setItem('PRICE_PERCENT_' + idArrayPercent, sessionStorage.getItem('PRICE'));
                    } else if (get_change == 2) {
                        var countArrayReduce = [];
                        var countReduce = $('input.Count_Reduce').val();
                        countReduce == '0' ? countArrayReduce : countArrayReduce.push(countReduce);
                        var idArrayReduce = Number(countReduce[countReduce.length - 1]) + 1;
                        countArrayReduce.push(idArrayReduce);
                        $('input.Count_Reduce').val(countArrayReduce);

                        localStorage.setItem('COUNT_REDUCE', JSON.stringify(transmitToArrayNumber(countArrayReduce)));
                        localStorage.setItem('CHECKED_REDUCE_' + idArrayReduce, sessionStorage.getItem('CHECKED'));
                        localStorage.setItem('PRICE_REDUCE_' + idArrayReduce, sessionStorage.getItem('PRICE'));

                    }
                    array_local_percent = JSON.parse(localStorage.getItem("COUNT_PERCENT"));
                    array_local_reduce = JSON.parse(localStorage.getItem("COUNT_REDUCE"));

                    if (localStorage.getItem('COUNT_PERCENT')) {
                        // Đẩy price,checked,key vào json (jsonStr)
                        for (let i = 0; i < array_local_percent.length; i++) {
                            obj['keyPercent'].push("CHECKED_PERCENT_" + array_local_percent[i]);
                            obj['keyPercentChecked'].push(localStorage.getItem("CHECKED_PERCENT_" + array_local_percent[
                                i]));
                            obj['keyPercentPrice'].push(localStorage.getItem("PRICE_PERCENT_" + array_local_percent[
                                i]));
                        }

                        //Lấy mảng chuyển đổi này để loại trừ ra các sản phẩm đã chọn rồi (tránh trường hợp lặp lại)
                        mediate_percent = unique_arr(jsonObjectToAssociateArray(obj['keyPercentChecked']));
                    }
                    if (localStorage.getItem('COUNT_REDUCE')) {
                        for (let i = 0; i < array_local_reduce.length; i++) {
                            obj['keyReduce'].push("CHECKED_REDUCE_" + array_local_reduce[i]);
                            obj['keyReduceChecked'].push(localStorage.getItem("CHECKED_REDUCE_" + array_local_reduce[
                                i]));
                            obj['keyReducePrice'].push(localStorage.getItem("PRICE_REDUCE_" + array_local_reduce[i]));
                        }

                        mediate_reduce = unique_arr(jsonObjectToAssociateArray(obj['keyReduceChecked']));
                    }

                    jsonStr = JSON.stringify(obj);
                    var _token = $('input[name="_token"]').val();

                    // Đưa các sản phẩm dưới dạng json vào value để tiện truyền dữ liệu qua route(save_special)
                    $('input.special_product_json').val(jsonStr);

                    $.ajax({
                        type: 'post',
                        url: '{{ route('backend.special_list_checked') }}',
                        data: {
                            jsonStr: jsonStr,
                            _token: _token
                        },
                        success: function(data) {

                            $("label#special_number-error").hide();
                            $("select.special_number").removeClass("error");

                            localStorage.setItem('Mediate_Checked_Percent', JSON.stringify(mediate_percent));
                            localStorage.setItem('Mediate_Checked_Reduce', JSON.stringify(mediate_reduce));

                            //Xóa đi PRODUCT_CHECK để phòng trường hợp [checked Product] chạy ẩn các sản phẩm đã chọn
                            localStorage.removeItem('PRODUCT_CHECK');

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
                                            <div class="col-sm-6">
                                                ${data['output_one']}
                                            </div>
                                            <div class="col-sm-6">
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
                            $(".modal").modal('hide');
                            $('.SubmitSpecialConditionDiv').empty();
                            $('.SubmitSpecialConditionDiv').removeClass('w-100 d-block my-3 text-center');
                        }
                    });
                });
            </script>
        @endsection
