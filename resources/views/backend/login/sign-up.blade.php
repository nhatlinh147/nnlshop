@extends('backend.login-form')
@section('content')
    <div class="splash-container" style="max-width:560px">
        <div class="row">
            <!-- ============================================================== -->
            <!-- validation form -->
            <!-- ============================================================== -->
            <style>
                label {
                    font-weight: bold;
                    margin: 10px 0px;
                }

                .Button_Click {
                    justify-content: center;
                    display: flex;
                }

                .footer-sign-up {
                    text-align: center;
                    padding-top: 20px
                }

                .footer-sign-up hr {
                    width: 60%;
                    border: 1px solid #e7e7e7;
                }

                .footer-sign-up div:first-child {
                    display: flex;
                    flex-direction: center;
                    align-items: center;
                }

                .footer-sign-up div:first-child span {
                    margin: 0px 10px;
                    font-size: 12pt;
                }

            </style>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <p class="card-header"
                        style="font-weight:bold;text-align:center;font-size:24pt;text-transform:uppercase">Đăng ký tài khoản
                    </p>
                    <div class="card-body">
                        <form action="{{ route('backend.save_register') }}" method="POST" id="Sign_Up">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustom">Tên tài khoản</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Tên tài khoản"
                                            name="account_name">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustom02">Email</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Email" name="account_email">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustomUsername">Số điện thoại</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-phone"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" placeholder="Phone number" type="text"
                                            name="account_phone">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustom01">Mật khẩu</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Mật khẩu"
                                            name="account_password" id="Account_password">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustom01">Xác nhận mật khẩu</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-lock"></i>
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" placeholder="Xác nhận mật khẩu"
                                            name="account_confirm_password">
                                    </div>
                                    <div id='message'></div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                    <label for="validationCustom01">Giới tính &nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="gender" value="Nam" class="custom-control-input"><span
                                            class="custom-control-label" style="font-weight:normal">Nam</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="gender" value="Nữ" class="custom-control-input"><span
                                            class="custom-control-label" style="font-weight:normal">Nữ</span>
                                    </label>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">

                                        <input type="checkbox" name="agree_policy">
                                        <label class="form-check-label" for="invalidCheck"
                                            style="font-weight:normal; font-size:11pt">
                                            Bạn có đồng ý chính sách bảo mật không
                                        </label>

                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 Button_Click">
                                    <button class="btn btn-primary btn-block" type="submit">Đăng ký</button>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 footer-sign-up">
                                    <div class="foo">
                                        <hr>
                                        <span>Hoặc</span>
                                        <hr>
                                    </div>
                                    <p> Nếu bạn bạn đã có tài khoản?
                                        <a href="{{ route('backend.login_by_auth') }}">
                                            Đăng nhập
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end validation form -->
            <!-- ============================================================== -->
        </div>
    </div>
@endsection
@section('script')
    <script>
        // $(document).ready(function() {
        //     $('#Account_password, #Account_Confirm_Password').on('keyup', function() {
        //         if ($('#Account_password').val() == "" || $('#Account_Confirm_Password').val() == "") {
        //             $('#message').empty();
        //         } else if ($('#Account_password').val() != "" || $('#Account_Confirm_Password').val() !=
        //             "") {
        //             if ($('#Account_password').val() == $('#Account_Confirm_Password').val()) {
        //                 $('#message').empty();
        //                 $('#message').html('Khớp mật khẩu').css({
        //                     'color': 'green',
        //                     'font-weight': 'bold',
        //                     'margin': '10px 0px 5px'
        //                 });
        //             } else if ($('#Account_password').val() != $('#Account_Confirm_Password').val()) {
        //                 $('#message').empty();
        //                 $('#message').html('Không khớp mật khẩu').css({
        //                     'color': 'red',
        //                     'font-weight': 'bold',
        //                     'margin': '10px 0px 5px'
        //                 });
        //             }
        //         }
        //     });
        // });

        $.validator.addMethod("phoneVN", function(value, element) {
            return this.optional(element) ||
                /^((\+|(\s|\s?\-\s?)?)84(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9]){8}$/.test(
                    value);
        }, "Số điện thoại phải bắt đầu bằng +84 và có đủ 11 số ( tính luôn số 84 )");
    </script>
    <script>
        $("#Sign_Up").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                account_name: {
                    required: true,
                    minlength: 7
                },
                account_email: {
                    required: true,
                    email: true,
                },
                account_phone: {
                    required: true,
                    phoneVN: true,
                },
                account_password: {
                    required: true,
                    regex: "^(((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])))(?=.{6,})",
                },
                account_confirm_password: {
                    required: true,
                    equalTo: "#Account_password"
                },
                agree_policy: {
                    required: true,
                },
                gender: {
                    required: true,
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                account_name: {
                    required: "Tên tài khoản không được để trống",
                    minlength: "Tên tài khoản phải ít nhất 7 ký tự"
                },
                account_email: {
                    required: "Email không được để trống",
                    email: "Email không hợp lệ"
                },
                // compound rule
                account_phone: {
                    required: "Số điện thoại không được để trống",
                },
                account_password: {
                    required: "Mật khẩu không được để trống",
                    regex: "Mức độ mật khẩu chưa tốt"
                },
                account_confirm_password: {
                    required: "Xác nhận mật khẩu không được để trống",
                    equalTo: "Xác nhận mật khẩu không khớp"
                },
                agree_policy: {
                    required: "Bạn phải đồng ý với chính sách bảo mật thì mới có thể đăng ký",
                },
                gender: {
                    required: "Bạn phải chọn giới tính",
                }
            },
            errorPlacement: function(error, element) {
                if (element.is(":radio"))
                    error.insertAfter(element.parent("label").next());
                else if (element.is(":checkbox"))
                    error.insertAfter(element.next());
                else
                    error.insertAfter(element);
            },

        });
    </script>
@endsection
