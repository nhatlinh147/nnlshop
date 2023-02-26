<script>
    //Bắt sự kiện cũng như update lại giá trị trong badge cart và favourite
    $('div.product-action a#Add_To_Cart').click(function() {
        let product_id = $(this).data('product_id');
        $.ajax({
            url: '{{ route('frontend.add_cart_guest') }}',
            type: "get",
            data: {
                product_id: product_id,
                cart_quantity: 1
            },
            datatype: "json",
            success: function(data) {
                if (data.is_available != 0) {
                    save_update_cart(product_id, 0, 0);

                } else {
                    save_update_cart(0, 0, 0);
                }
            }
        })
    })
</script>
