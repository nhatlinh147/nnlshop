@extends('frontend.index')
@section('content')
    <!-- Carousel Start -->
    @include('frontend.index.carousel-include')
    <!-- Carousel End -->

    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span
                class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">

            @foreach ($category_parent as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none"
                        href="{{ url('/front-end/hien-thi-san-pham?parent=true&category=' . $category->Category_Product_Slug) }}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid"
                                    src="{{ asset('public/upload/cate_pro/' . $category->Category_Image) }}" alt="">
                            </div>
                            <div class="flex-fill pl-3" style="width: min-content">
                                <h6>{{ $category->Category_Name }}</h6>
                                <small class="text-body">100 Products</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured
                Products</span></h2>
        <div class="row px-xl-5">
            @foreach ($filterPopularProduct as $featured_pro)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100"
                                src="{{ asset('public/upload/product/' . $featured_pro->Product_Image) }}"
                                alt="{{ $featured_pro->Product_Name }}">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $featured_pro->Product_ID }}"
                                    href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $featured_pro->Product_ID }}"
                                    href="{{ isCheckCustomer() ? 'javascript:void(0)' : route('frontend.show_favorite') }}"><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $featured_pro->Product_ID }}"
                                    href="{{ url('front-end/chi-tiet-san-pham/' . $featured_pro->Product_Slug) }}"><i
                                        class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="">{{ $featured_pro->Product_Name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $featured_pro->Product_Price }}</h5>
                                <h6 class="text-muted ml-2">
                                    <del>{{ $featured_pro->Product_Cost }}</del>
                                </h6>
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
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            @foreach ($special_show as $spe)
                <div class="col-md-6">
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid" src="{{ asset('public/upload/special/' . $spe->Special_Image) }}"
                            alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Save 20%</h6>
                            <h3 class="text-white mb-3">{{ $spe->Special_Title }}</h3>
                            <a href="" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!-- Offer End -->

    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recent
                Products</span></h2>
        <div class="row px-xl-5">
            @foreach ($latest_product as $last_pro)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100"
                                src="{{ asset('public/upload/product/' . $last_pro->Product_Image) }}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $last_pro->Product_ID }}"
                                    href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $last_pro->Product_ID }}"
                                    href="{{ isCheckCustomer() ? 'javascript:void(0)' : route('frontend.show_favorite') }}"><i
                                        class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" data-product_id="{{ $last_pro->Product_ID }}"
                                    href="{{ url('front-end/chi-tiet-san-pham/' . $last_pro->Product_Slug) }}"><i
                                        class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="">{{ $last_pro->Product_Name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $last_pro->Product_Price }}</h5>
                                <h6 class="text-muted ml-2"><del>{{ $last_pro->Product_Cost }}</del></h6>
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
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-1.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-2.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-3.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-4.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-5.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-6.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-7.jpg') }}" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="{{ asset('public/FrontEnd/img/vendor-8.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection
