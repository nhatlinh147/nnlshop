@push('css')
    <style>
        ul.dropdown-menu li.active a {
            text-decoration: none;
            background-color: #FFD333;
            color: #fff;
        }
    </style>
@show
<div class="container-fluid">
    <div class="row bg-secondary py-1 px-xl-5">
        <div class="col-lg-6 d-none d-lg-block">
            <div class="d-inline-flex align-items-center h-100">
                <a class="text-body mr-3" href="">About</a>
                <a class="text-body mr-3" href="">Contact</a>
                <a class="text-body mr-3" href="">Help</a>
                <a class="text-body mr-3" href="">FAQs</a>
            </div>
        </div>
        <div class="col-lg-6 text-center text-lg-right">
            <div class="d-inline-flex align-items-center">
                <div class="btn-group">
                    @php
                        $guard = Auth::guard('customer');
                    @endphp
                    @if ($guard->check())
                        @include('frontend.customer.auth', [
                            'username' => $guard->user()->Customer_Name,
                            'email' => $guard->user()->Customer_Email,
                            'address' => $guard->user()->Customer_Address,
                            'image' => $guard->user()->Customer_Image,
                        ])
                    @else
                        @include('frontend.customer.guest')
                    @endif
                </div>
                @if (isCheckCustomer())
                    @include('frontend.index.notification')
                @endif
                <div class="btn-group mx-2">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                        data-toggle="dropdown">USD</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">EUR</button>
                        <button class="dropdown-item" type="button">GBP</button>
                        <button class="dropdown-item" type="button">CAD</button>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                        data-toggle="dropdown">EN</button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">FR</button>
                        <button class="dropdown-item" type="button">AR</button>
                        <button class="dropdown-item" type="button">RU</button>
                    </div>
                </div>

            </div>
            <div class="d-inline-flex align-items-center d-block d-lg-none" id="Count_Favourite_Cart">
                <a href="{{ route('frontend.show_cart') }}" class="btn px-0 ml-2">
                    <i class="fas fa-shopping-cart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle"
                        style="padding-bottom: 2px;">0</span>
                </a>
                <a href="{{ route('frontend.show_favorite') }}" class="btn px-0 ml-2">
                    <i class="fas fa-heart text-dark"></i>
                    <span class="badge text-dark border border-dark rounded-circle"
                        style="padding-bottom: 2px;">0</span>
                </a>
            </div>
            {{-- @php
                Session::put('favorite', null);
            @endphp --}}
        </div>
    </div>
    <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
        <div class="col-lg-4">
            <a href="{{ route('frontend.index') }}" class="text-decoration-none">
                <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
            </a>
        </div>

        <div class="col-lg-4 col-6 text-left">
            <form action="{{ url('front-end/hien-thi-san-pham?search_query') }}">
                <div class="input-group">
                    <div class="icon"></div>
                    <input type="text" class="form-control" placeholder="Search for products" id="Search_Product"
                        name="Search_Product" autocomplete="off">

                    <div class="input-group-append">
                        <span class="input-group-text bg-transparent text-primary">
                            <i class="fa fa-search"></i>
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-6 text-right">
            <p class="m-0">Customer Service</p>
            <h5 class="m-0">+012 345 6789</h5>
        </div>
    </div>
</div>
@push('scripts')
    {{-- topbar --}}
    <script src="{{ asset('public/FrontEnd/js/bootstrap-typeahead.min.js') }}"></script>
    @include('frontend.index.script.search')
    @include('frontend.index.script.push')
@endpush
