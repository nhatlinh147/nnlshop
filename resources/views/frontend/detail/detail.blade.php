@extends('frontend.index')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.index') }}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.show_product') }}">Hiển thị sản phẩm</a>
                    <a class="breadcrumb-item active"
                        href="{{ url('front-end/chi-tiet-san-pham/' . $show_product->Product_Slug) }}">{{ $show_product->Product_Name }}</a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">

                        <div class="carousel-item active">
                            <img class="w-100 h-100"
                                src="{{ asset('public/upload/product/' . $show_product->Product_Image) }}"
                                alt="{{ $show_product->Product_Name }}">
                        </div>
                        @php
                            $count = 0;
                        @endphp
                        @foreach (App\Model\GalleryModel::where('Product_ID', $show_product->Product_ID)->get() as $gallery)
                            @php
                                $count++;
                            @endphp
                            <div class="carousel-item">
                                <img class="w-100 h-100"
                                    src="{{ asset('public/upload/gallery/' . $gallery->Gallery_Image) }}"
                                    alt="{{ $show_product->Product_Name }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $show_product->Product_Name }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $show_product->Product_Price }}</h3>
                    <p class="mb-4">{{ $show_product->Product_Summary }}</p>

                    @include('frontend.detail.add-style')

                    @php
                        $colors = new \App\Support\GetIdBy($show_product->Product_ID, 'Prop_Color');
                        $colors = $colors->getAttr();
                        $sizes = new \App\Support\GetIdBy($show_product->Product_ID, 'Prop_Size');
                        $sizes = $sizes->getAttr();
                    @endphp

                    <!-- Lựa chọn thuộc tính màu sắc -->
                    @if (!is_string($colors))
                        <div class="d-flex mb-3">
                            <div class="section">
                                <strong class="text-dark mr-3" style="margin-top:15px;">Màu sắc:</strong>
                                <div class="flex-wrap">

                                    @foreach ($colors as $color)
                                        <div class="attr" style="background:{{ $color }};"
                                            data-color="{{ $color }}" id="Attr_Color"></div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endif

                    @if (!is_string($sizes))
                        <div class="d-flex mb-3">
                            <!-- Lựa chọn thuộc tính kích thước -->
                            <div class="section">
                                <strong class="text-dark mr-3" style="margin-top:15px;">Kích thước:</strong>
                                <div class="flex-wrap">

                                    @foreach ($sizes as $size)
                                        <div class="attr" data-size="{{ $size }}" id="Attr_Size">
                                            {{ $size }}</div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex mb-3">
                        <div class="section">
                            <strong class="text-dark mr-3" style="margin-top:15px;">Tags:</strong>
                            @php
                                $array_tag = explode(', ', $show_product->Product_Tag);
                            @endphp
                            @for ($i = 0; $i < count($array_tag); $i++)
                                <a class="tag-link"
                                    href="#{{ $array_tag[$i] }}">{{ $i == 0 ? '#' . $array_tag[$i] : ' , #' . $array_tag[$i] }}</a>
                            @endfor
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center cart_quantity"
                                value="1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3" id="Button_Add_Cart"
                            data-product_id="{{ $show_product->Product_ID }}"><i class="fa fa-shopping-cart mr-1"></i>
                            Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab"
                            href="#tab-pane-1">Description</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Product Description</h4>
                            {!! $show_product->Product_Desc !!}
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Additional Information</h4>
                            {!! $show_product->Product_Content !!}
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-4">1 review for "Product Name"</h4>
                                    <div class="media mb-4">
                                        <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                                            style="width: 45px;">
                                        <div class="media-body">
                                            <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum
                                                et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        <div class="text-primary">
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    @include('frontend.detail.similar-product')
    <!-- Products End -->
@endsection
@push('scripts')
    @include('frontend.detail.script.attribute')
@endpush
