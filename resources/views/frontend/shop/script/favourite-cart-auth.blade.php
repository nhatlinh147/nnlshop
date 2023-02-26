<script>
    $('div.product-action a.btn.btn-square:not(:nth-child(3))').click(function() {
        let index = $(this).index();
        let product_id = $(this).data('product_id');

        if (index == 0) {
            save_update_cart(product_id, 0, 0);
        } else {
            if (!$(this).hasClass('active')) {
                $.ajax({
                    url: '{{ route('frontend.add_favorite') }}',
                    type: "get",
                    data: {
                        product_id: product_id
                    },
                    success: function(data) {
                        load_active_product();
                        save_update_cart(0, 0, 0);
                    }
                })
            } else {
                if (confirm('Bạn có chắc là hủy bỏ yêu thích không')) {
                    $.ajax({
                        url: '{{ route('frontend.cancel_favorite') }}',
                        type: "get",
                        data: {
                            product_id: product_id
                        },
                        success: function(data) {
                            save_update_cart(0, 0, 0);
                            let href_favor = '{{ route('frontend.show_favorite') }}';
                            if (window.location.href == href_favor) {
                                location.reload(true);
                            } else {
                                $(`div.product-item a[data-product_id="${product_id}"]:nth-child(2)`)
                                    .removeClass('active');
                            }

                        }
                    })
                }
            }

        }
    });
</script>
<script>
    load_active_product();

    function load_active_product() {
        $.ajax({
            url: '{{ route('frontend.show_favorite') }}',
            type: "get",
            data: {
                ajax: true
            },
            success: function(data) {
                console.log('Check active');
                console.log(data);
                data.forEach(element => {
                    $(`div.product-item a[data-product_id="${element.Product_ID}"]:nth-child(2)`)
                        .addClass('active');
                });
            }
        })
    }
</script>
<script>
    $("#message a.close-notify").click(function() {
        $("#message").fadeOut("slow");
        return false;
    });
</script>
