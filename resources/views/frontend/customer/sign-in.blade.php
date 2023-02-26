@extends('frontend.customer.layout')
@section('content')
    <!-- Sing in  Form -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="{{ asset('public/FrontEnd/img/ff20544179ff39c242e5d509c235e797.jpg') }}"
                            alt="Hình ảnh đăng nhập">
                    </figure>
                    <a href="{{ route('frontend.sign_up_customer') }}" class="signup-image-link">Tạo tài khoản</a>
                </div>
                <div class="signin-form">
                    <h2 class="form-title">Đăng nhập</h2>
                    @php
                        $message = Session::get('message');
                        if ($message) {
                            echo '<p class="text-danger text-center">' . $message . '</p>';
                            Session::put('message', null);
                        }
                    @endphp
                    {{-- In lỗi validator --}}
                    <ul>
                        @foreach ($errors->all() as $value)
                            <li class="text-danger">{{ $value }}</li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('frontend.check_login') }}" class="login-form" id="login-form">
                        @csrf
                        <div class="form-group">
                            <label for="customer_name"><i class="fa fa-user"></i></label>
                            <input type="text" name="customer_name" id="customer_name" placeholder="Tên tài khoản"
                                value="{{ Cookie::has('customeruser') ? Cookie::get('customeruser') : '' }}" />
                        </div>
                        <div class="form-group">
                            <label for="customer_password"><i class="fa fa-lock"></i></label>
                            <input type="password" name="customer_password" id="customer_password" placeholder="Mật khẩu" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="remember_me" id="remember_me" class="remember_me" />
                            <label for="remember_me" class="label-agree-term"><span><span></span></span>Nhớ mật khẩu</label>
                        </div>
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                        </div>
                    </form>
                    <div class="social-login">
                        <span class="social-label">Hoặc đăng nhập với</span>
                        <ul class="socials">
                            <li><a href="#"><i style="color: #3b5998;font-size: 2rem;"
                                        class="display-flex-center fab fa-6x fa-facebook"></i></a></li>
                            <li><a href="#"><i style="color: #55acee;font-size: 2rem;"
                                        class="display-flex-center fab fa-twitter"></i></a></li>
                            <li><a href="#"><i style="color: #dd4b39;font-size: 2rem;"
                                        class="display-flex-center fab fa-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
