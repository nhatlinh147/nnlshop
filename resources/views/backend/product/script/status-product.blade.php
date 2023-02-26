<script>
    $(document).on('change', '.update_status', function() {
        var status = $(this).prop('checked') == true ? 1 : 0;
        var product_id = $(this).data('id');
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: '{{ route('backend.product_status') }}',
            data: {
                'status': status,
                'product_id': product_id
            },
            success: function(data) {
                console.log('Thay đổi trạng thái sản phẩm thành công');
            }
        });
    });
</script>
