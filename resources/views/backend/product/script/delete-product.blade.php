<script>
    $('.delete_product').on('click', function() {
        var product_id = $(this).data('id');
        if ($('.read_by_ggdrive').data('product_path')) {
            var get_path = $('.read_by_ggdrive').data('product_path');
        } else {
            var get_path = 0;
        }

        $.ajax({
            url: '{{ route('backend.delete_product') }}',
            type: 'get',
            dataType: 'json',
            data: {
                product_id: product_id,
                get_path: get_path,
            },
            success: function(data) {
                var oTable = $('table.second').DataTable();
                oTable.ajax.reload(null, false);
            } //End Success
        }); //End Ajax
    }); //End click .delete_product
</script>
