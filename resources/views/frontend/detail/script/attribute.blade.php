<script>
    $('div.section div.attr').click(function() {
        var active = $(this).hasClass('active');
        const index_parent = $(this).parent('div').index('.flex-wrap');
        $('div.section div.flex-wrap').eq(index_parent).children().removeClass('active');
        $(this).addClass('active');
        if (active) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });
    $('button#Button_Add_Cart').click(function() {
        let product_id = $(this).data('product_id');
        let cart_quantity = $('input.cart_quantity').val();
        console.log(cart_quantity);
        save_update_cart(product_id, 3, cart_quantity);
    });
</script>
