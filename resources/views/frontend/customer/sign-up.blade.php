@extends('frontend.customer.layout')
@section('content')
    <!-- Sign up form -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Đăng ký</h2>
                    <form method="POST" action="{{ route('frontend.save_register') }}" id="Sign_Up">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name"><i class="fa fa-user"></i></label>
                            <input type="text" name="customer_name" id="customer_name"
                                placeholder="Nhập tên tài khoản" />
                        </div>
                        <div class="form-group">
                            <label for="customer_email"><i class="fa fa-envelope"></i></label>
                            <input type="email" name="customer_email" id="customer_email" placeholder="Nhập email" />
                        </div>
                        <div class="form-group">
                            <label for="customer_phone"><i class="fa fa-phone"></i></label>
                            <input type="text" name="customer_phone" id="customer_phone"
                                placeholder="Nhập số điện thoại" />
                        </div>
                        <div class="form-group">
                            <label for="customer_address"><i class="fa fa-address-card"></i></label>
                            <input type="text" name="customer_address" id="customer_address"
                                placeholder="Nhập địa chỉ" />
                        </div>
                        <div class="form-group">
                            <label for="customer_password"><i class="fa fa-lock"></i></label>
                            <input type="password" name="customer_password" id="customer_password"
                                placeholder="Nhập mật khẩu" />
                        </div>
                        <div class="form-group">
                            <label for="customer_re_pass"><i class="fa fa-lock"></i></label>
                            <input type="password" name="customer_re_pass" id="customer_re_pass"
                                placeholder="Nhập lại mật khẩu" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree_policy" id="agree_policy" class="agree_policy" />
                            <label for="agree_policy" class="label-agree-term"><span><span></span></span>Tôi đồng ý tất cả
                                các tuyên bố trong <a href="#" class="term-service">Điều khoản dịch vụ</a></label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Register" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="{{ asset('public/FrontEnd/img/uchiha_madara_by_deriavis_df1y455-fullview.jpg') }}"
                            alt="Hình ảnh đăng ký"></figure>
                    <a href="{{ route('frontend.sign_in_customer') }}" class="signup-image-link">I am already member</a>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $.validator.addMethod("phoneVN", function(value, element) {
            return this.optional(element) ||
                /^((\+|(\s|\s?\-\s?)?)84(\s|\s?\-\s?)?(\(0\)[\-\s]?)?|0)[1-9]((\s|\s?\-\s?)?[0-9]){8}$/.test(
                    value);
        }, "Số điện thoại phải bắt đầu bằng +84 hoặc 0 và có đủ 11 số ( tính luôn số 84 )");
    </script>
    <script>
        $("#Sign_Up").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                customer_name: {
                    required: true,
                    minlength: 7,
                    remote: {
                        type: "get",
                        url: '{{ url('/front-end/kiem-tra-ton-tai') }}',
                        data: {
                            customer_name: $('.customer_name').val()
                        }
                    }
                },
                customer_email: {
                    required: true,
                    email: true,
                    remote: {
                        type: "get",
                        url: '{{ url('/front-end/kiem-tra-ton-tai') }}',
                        data: {
                            customer_email: $('.customer_email').val()
                        }
                    }
                },
                customer_phone: {
                    required: true,
                    phoneVN: true,
                },
                customer_address: {
                    required: true
                },
                customer_password: {
                    required: true,
                    regex: "^(((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])))(?=.{6,})",
                },
                customer_re_pass: {
                    required: true,
                    equalTo: "#customer_password"
                },
                agree_policy: {
                    required: true,
                }
            },
            messages: {
                // simple rule, converted to {required:true}
                customer_name: {
                    required: "Tên tài khoản không được để trống",
                    minlength: "Tên tài khoản phải ít nhất 7 ký tự",
                    remote: "Tên tài khoản đã tồn tại. Xin nhập lại"
                },
                customer_email: {
                    required: "Email không được để trống",
                    email: "Email không hợp lệ",
                    remote: "Email đã tồn tại. Xin nhập lại"
                },
                // compound rule
                customer_phone: {
                    required: "Số điện thoại không được để trống",
                },
                customer_address: {
                    required: "Địa chỉ không được để trống",
                },
                customer_password: {
                    required: "Mật khẩu không được để trống",
                    regex: "Mức độ mật khẩu chưa tốt"
                },
                customer_re_pass: {
                    required: "Xác nhận mật khẩu không được để trống",
                    equalTo: "Xác nhận mật khẩu không khớp"
                },
                agree_policy: {
                    required: "Bạn phải đồng ý với điều khoản dịch vụ thì mới có thể đăng ký",
                }
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element.parent('.form-group'));
            }

        });
    </script>
@endpush
