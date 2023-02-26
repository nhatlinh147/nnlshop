@extends('frontend.index')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.index') }}">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.show_product') }}">Hiển thị sản phẩm</a>
                    <span class="breadcrumb-item active">Sản phẩm yêu thích</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            @foreach ($favorites as $favorite)
                <div class="col-lg-3 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100"
                                src="{{ asset('public/upload/product/' . $favorite['Product_Image']) }}"
                                alt="{{ $favorite['Product_Name'] }}">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $favorite['Product_ID'] }}"
                                    href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $favorite['Product_ID'] }}"
                                    href="javascript:void(0)"><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $favorite['Product_ID'] }}"
                                    href="{{ url('front-end/chi-tiet-san-pham/' . $favorite['Product_Slug']) }}"><i
                                        class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ url('/front-end/chi-tiet-san-pham/' . $favorite['Product_Slug']) }}">{{ $favorite['Product_Name'] }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $favorite['Product_Price'] }}</h5>
                                <h6 class="text-muted ml-2"><del>{{ $favorite['Product_Cost'] }}</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Cart End -->

    <!-- Products Start -->
    @include('frontend.detail.similar-product')
    <!-- Products End -->
@endsection
@push('scripts')
    @include('frontend.shop.script.favourite-cart-auth')
    <script>
        var perfEntries = performance.getEntriesByType("navigation");

        if (perfEntries[0].type === "back_forward") {
            location.reload(true);
        }
    </script>
@endpush
