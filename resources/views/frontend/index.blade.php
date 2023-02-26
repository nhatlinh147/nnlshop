<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    {{-- <link href="{{ asset('public/FrontEnd/img/favicon.ico') }}" rel="icon"> --}}

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('public/FrontEnd/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/FrontEnd/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('public/FrontEnd/css/style.css') }}" rel="stylesheet">

    <!-- Bootstrap Notification-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/FrontEnd/css/notification.css') }}">

    <!-- Script được thêm vào -->
    @stack('css')

</head>

<body>
    {{-- <pre>
        @php
            Session::put('cart', null);
            Session::has('cart') ? print_r(Session::get('cart')) : print_r('Không có session cart');
        @endphp
    </pre> --}}
    <!-- Topbar Start -->
    @include('frontend.index.topbar')
    <!-- Topbar End -->


    <!-- Navbar Start -->
    @include('frontend.index.navbar')
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    @include('frontend.index.footer')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('public/FrontEnd/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('public/FrontEnd/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('public/FrontEnd/mail/jqBootstrapValidation.min.js') }}"></script>
    <script src="{{ asset('public/FrontEnd/mail/contact.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('public/FrontEnd/js/main.js') }}"></script>

    <!-- Pusher Javascript -->
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    @php

        if (Auth::guard('customer')->check()) {
            $customer_id = Auth::guard('customer')->user()->Customer_ID;
        } else {
            $customer_id = 0;
        }

    @endphp
    <script>
        var countModule = (function() {
            var count = 0;

            function increaseFunc() {
                return count++;
            }

            return {
                increase: increaseFunc
            }
        })();
    </script>
    <script>
        const token = function() {
            return $('input[name="_token"]').val();
        }

        const format_number = function(n, currency) {
            return n.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + currency;
        };

        function notify_add_cart(text) {
            var id = Math.random().toString(36).slice(2, 7);
            $("#message span").html(
                `Bạn vừa thêm sản phẩm ${text}`);
            $("#message").fadeIn("slow");

            setTimeout(function() {
                $("#message").fadeOut("slow");
            }, 10000);

        }
        var save_update_cart = function(product_id, minus, cart_quantity) {
            $.ajax({
                url: '{{ route('frontend.save_cart') }}',
                type: "get",
                data: {
                    product_id: product_id,
                    minus: minus,
                    customer_id: {{ $customer_id }},
                    cart_quantity: cart_quantity
                },
                datatype: "json",
                success: function(data) {
                    console.log(data);
                    var cart = data.cart;
                    var price = data.price;
                    var get_coupon = data.get_coupon;

                    if (data.first_time_added != 0) {
                        notify_add_cart(data.first_time_added);
                    }

                    $('div#Count_Favourite_Cart a:first-child span.badge').text(cart.length);
                    $('div#Count_Favourite_Cart a:last-child span.badge').text(data.count_favorite);

                    var subtotal = 0;
                    for (let index = 0; index < price.length; index++) {
                        let tich = cart[index].Cart_Quantity * price[index];
                        var subtotal = subtotal + tich;
                        let shipping = 5000000;

                        //Tính mức giảm giá do mã khuyến mãi
                        var reduce = 0;
                        if (get_coupon != 0) {
                            if (get_coupon.Coupon_ID == 2) {
                                var reduce = get_coupon.Coupon_Number;
                            } else {
                                var reduce = subtotal * get_coupon.Coupon_Number * 0.01;
                            }
                            //Hiển thị mục giá giảm theo mã ưu đãi
                            $('#reduce_follow_coupon').removeClass('d-none');
                        } else {
                            //Ẩn đi mục giá giảm theo mã ưu đãi
                            $('#reduce_follow_coupon').addClass('d-none');
                        }

                        var total = subtotal - reduce - shipping;

                        //Điền giá trị vào vị trí thẻ id chỉ định
                        $('table.table tbody tr td:nth-child(5)').eq(index).text(format_number(tich, " đ"));
                        $('h6#sub_total').text(format_number(subtotal, " đ"));

                        if (subtotal == 0) {
                            $('h6#shipping').text(format_number(0, " đ"));
                            $('h5#total').text(format_number(0, " đ"));
                        } else {
                            $('h6#shipping').text(format_number(shipping, " đ"));
                            $('h5#total').text(format_number(total, " đ"));

                            $('#reduce_follow_coupon #reduce').text(format_number(reduce, " đ"));
                        }
                        if (minus == 2 || minus == 3) {
                            window.location.href = "{{ route('frontend.show_cart') }}";
                        }
                    }
                }
            })
        }
        save_update_cart(0, 0, 0);

        //Save_update_cart có 5 trường hợp
        // save_update_cart(0, 0, 0) : chỉ tính số lượng giỏ hàng
        // save_update_cart(product_id, 0, 0): tăng thêm một giá trị hoặc cập nhật giá trị mới trong qty
        // save_update_cart(product_id, 1, 0): giảm một giá trị trong qty
        // save_update_cart(product_id, 2, cart_quantity): cập nhật giỏ hàng đúng bằng giá trị cart_quantity
        // save_update_cart(product_id, 3, cart_quantity): cập nhật giỏ hàng bằng giá trị cart_quantity + qty trước đó
    </script>
    @stack('scripts')
</body>

</html>
