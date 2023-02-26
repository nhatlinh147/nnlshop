@if ($index == 0)
    @include('frontend.shop.search-result')
@endif
@foreach ($show_product as $show_pro)
    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
            <div class="product-img position-relative overflow-hidden">
                <img class="img-fluid w-100" src="{{ asset('public/upload/product/' . $show_pro->Product_Image) }}"
                    alt="{{ $show_pro->Product_Name }}">
                <div class="product-action">
                    <a class="btn btn-outline-dark btn-square" data-product_id="{{ $show_pro->Product_ID }}"
                        href="javascript:void(0)" id="Add_To_Cart"><i class="fa fa-shopping-cart"></i></a>
                    <a class="btn btn-outline-dark btn-square" data-product_id="{{ $show_pro->Product_ID }}"
                        href="{{ isCheckCustomer() ? 'javascript:void(0)' : route('frontend.show_favorite') }}"><i
                            class="far fa-heart"></i></a>
                    <a class="btn btn-outline-dark btn-square" data-product_id="{{ $show_pro->Product_ID }}"
                        href="{{ url('front-end/chi-tiet-san-pham/' . $show_pro->Product_Slug) }}"><i
                            class="fa fa-eye"></i></a>
                </div>
            </div>
            <div class="text-center py-4">
                <a class="h6 text-decoration-none text-truncate"
                    href="{{ url('/front-end/chi-tiet-san-pham/' . $show_pro->Product_Slug) }}">{{ $show_pro->Product_Name }}</a>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5>{{ $show_pro->Product_Price }}</h5>
                    <h6 class="text-muted ml-2"><del>{{ $show_pro->Product_Cost }}</del></h6>
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
<div class="col-12">
    {{ $show_product->links('frontend.paginate.pagination') }}
</div>
<style>
    div[id*="message"] {
        display: flex;
        position: fixed;
        top: 0px;
        right: 0px;
        width: 30%;
        border-radius: 7px;
        z-index: 105;
        text-align: center;
        font-weight: bold;
        font-size: 100%;
        color: white;
        padding: 20px 10px;
        background-color: #f79489;
    }

    div[id*="message"] span {
        text-align: center;
        float: left;
    }

    .close-notify {
        white-space: nowrap;
        float: right;
        margin-right: 10px;
        color: #fff;
        text-decoration: none;
        padding-left: 3px;
        padding-right: 3px
    }

    .close-notify a {
        color: #fff;
    }
</style>
<div id='message' style="display: none;">
    <span></span>
    <a href="#" class="close-notify">X</a>
</div>
