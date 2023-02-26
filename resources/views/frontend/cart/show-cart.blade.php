<tbody class="align-middle">
    @php
        $sub_total = 0;
    @endphp
    @foreach ($all_cart as $cart)
        @php
            if (!Auth::guard('customer')->check()) {
                $price = number_format($cart['Product_Price'], 0, ',', '.') . ' đ';
                $quantity = $cart['Cart_Quantity'];
                $product_name = $cart['Product_Name'];
                $product_image = $cart['Product_Image'];
                $product_id = $cart['Product_ID'];
                $cart_id = $cart['Cart_ID'];
            } else {
                $price = $cart->product->Product_Price;
                $quantity = $cart->Cart_Quantity;
                $product_name = $cart->product->Product_Name;
                $product_image = $cart->product->Product_Image;
                $product_id = $cart->product->Product_ID;
                $cart_id = $cart->Cart_ID;
                $check_coupon = $cart->Coupon_ID;
            }
        @endphp
        <tr>
            <td>
                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                    <input type="checkbox" class="custom-control-input" id="checkbox_{{ $cart_id }}">
                    <label class="custom-control-label" for="checkbox_{{ $cart_id }}"></label>
                </div>
            </td>
            <td class="align-middle">
                <img src="{{ asset('public/upload/product/' . $product_image) }}" alt="{{ $product_name }}"
                    style="width: 50px;">
                {{ $product_name }}
            </td>
            <td class="align-middle">{{ $price }}</td>
            <td class="align-middle">
                <div class="input-group quantity mx-auto" style="width: 100px;">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-minus" data-product_id="{{ $product_id }}">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center"
                        value="{{ $quantity }}" id="input_quantity" data-product_id="{{ $product_id }}">
                    <div class="input-group-btn">
                        <button class="btn btn-sm btn-primary btn-plus" data-product_id="{{ $product_id }}">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
            </td>
            <td class="align-middle"></td>
            <td class="align-middle">
                <a href="{{ url('front-end/xoa-gio-hang/' . $cart_id) }}">
                    <button class="btn btn-sm btn-danger">
                        <i class="fa fa-times"></i>
                    </button>
                </a>
            </td>
        </tr>
    @endforeach

</tbody>
