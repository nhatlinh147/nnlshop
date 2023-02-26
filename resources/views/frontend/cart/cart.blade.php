@extends('frontend.index')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.index') }}">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.show_product') }}">Hiển thị sản phẩm</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    @include('frontend.cart.show-cart')
                    <tfoot class="tfoot-dark">
                        <th class="align-middle">
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="check_cart_all">
                                <label class="custom-control-label" for="check_cart_all"></label>
                            </div>
                        </th>
                        <th colspan="2" class="align-middle"><a class="Delected_Cart" role="button">Xóa mục đã
                                chọn</a></th>
                        <th colspan="3" class="align-middle"><a class="Add_Favourite" role="button">Thêm vào
                                mục
                                yêuthích</a></th>
                    </tfoot>
                </table>
            </div>
            <div class="col-lg-4">
                @php
                    $check_coupon = empty($check_coupon) ? '' : $check_coupon;
                @endphp

                @if ($check_coupon == null)
                    @includeWhen(Auth::guard('customer')->check(), 'frontend.cart.coupon-code')
                @endif
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="sub_total"></h6>
                        </div>
                        <div id="reduce_follow_coupon" class="d-none mb-3">
                            <div class="d-flex justify-content-between">
                                <h6>Ưu đãi:</h6>
                                <h6 id="reduce"></h6>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium" id="shipping"></h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="total"></h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@push('scripts')
    @include('frontend.cart.script-selected-cart')
    <script>
        const array_cart_id = function(params) {
            var product_id = [];
            if (params == true) {
                var str = ':checked';
            } else if (params == false) {
                var str = ':not(:checked)';
            } else {
                var str = '';
            }

            $('input[id*="checkbox_"]' + str).each(function() {
                let get_id = $(this).attr('id').split('_');
                get_id = get_id[1];
                product_id.push(get_id);
            });
            return product_id;
        }
    </script>
    <script>
        $(document).on('click', 'div.quantity button:not(.disabled)', function() {
            let product_id = $(this).data('product_id');
            if ($(this).hasClass('btn-minus')) {
                save_update_cart(product_id, 1, 0);
            } else {
                save_update_cart(product_id, 0, 0);
            }
        })
        $('input#input_quantity').change(function() {
            let cart_quantity = $(this).val();
            let product_id = $(this).data('product_id');
            save_update_cart(product_id, 2, cart_quantity);
        })
    </script>
@endpush
