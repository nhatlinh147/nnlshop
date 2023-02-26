<script>
    $(document).on('click', 'input#check_cart_all', function() {
        var check = $(this).prop('checked') == true ? 1 : 0;
        product_id = array_cart_id();
        console.log(product_id);
        //Lấy id từng cart dựa trên id đã đặt
        if (check == 1) {
            for (i = 0; i < product_id.length; i++) {
                $('#checkbox_' + product_id[i]).prop('checked', true);
            }
        } else {
            for (i = 0; i < product_id.length; i++) {
                $('#checkbox_' + product_id[i]).prop('checked', false);
            }
        }
    });

    $('a.Delected_Cart').on('click', function() {
        let get_id = array_cart_id(true);
        if (get_id.length) {
            get_id.forEach(element => {
                $.ajax({
                    url: '{{ url('front-end/xoa-gio-hang/') }}' + '/' + element,
                    type: "get",
                    success: function(data) {
                        window.location.href = "{{ route('frontend.show_cart') }}";
                    }
                })
            });
        } else {
            alert('Xin chọn sản phẩm cần xóa')
        }
    })
</script>
