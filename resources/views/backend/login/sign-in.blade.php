@extends('backend.login-form')
@section('content')
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
                <a href="../index.html"><img class="logo-img" src="{{ asset('public/BackEnd/images/logo-01.png') }}"
                        alt="logo">
                    <h3 style="text-transform: uppercase;font-weight:bold">Chào mừng đến NNLSHOP</h3>
                </a>
            </div>
            <div class="card-body">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<p class="text-danger text-center" style="font-weight:bold">' . $message . '</p>';
                    Session::put('message', null);
                }
                ?>
                {{-- In lỗi validator --}}
                <ul class="list-unstyled arrow">
                    @foreach ($errors->all() as $value)
                        <li>{{ $value }}</li>
                    @endforeach
                </ul>

                <form action="{{ route('backend.check_login') }}" method="post" id="Sign_In">
                    @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg"
                            @if (Cookie::has('adminuser')) value="{{ Cookie::get('adminuser') }}" @endif type="text"
                            placeholder="Tên tài khoản" name="account_name">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" type="password" placeholder="Mật khẩu"
                            name="account_password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="remember_me" value="remember_me" id="remember_me"
                                type="checkbox"><span class="custom-control-label">Nhớ mật khẩu</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Đăng nhập</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="{{ route('backend.register_by_auth') }}" class="footer-link">Tạo tài khoản</a>
                </div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Quên mật khẩu</a>
                </div>
            </div>
        </div>
    </div>
@endsection
