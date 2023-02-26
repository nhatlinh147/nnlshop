<script>
    $("#Form_Fee_Shipping").validate({
        rules: {
            fee_province_id: {
                valueNotEquals: "0",
            },
            fee_shipping: {
                required: true,
                number: true
            }
        },
        messages: {
            fee_province_id: {
                valueNotEquals: "Xin hãy lựa chọn tỉnh"
            },
            fee_shipping: {
                required: "Phí giao hàng không được để trống",
                number: "Phí giao hàng phải là dãy số"
            }
        },
    });
</script>
