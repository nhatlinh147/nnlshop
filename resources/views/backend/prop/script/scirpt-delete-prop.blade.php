<script>
    $(document).on('click', 'a#Delete_Prop', function() {
        var prop_id = $(this).data('prop_id');
        console.log(prop_id);
        $.ajax({
            url: '{{ route('backend.delete_prop') }}',
            type: 'post',
            dataType: 'json',
            data: {
                _token: _token,
                prop_id: prop_id
            },
            success: function(data) {
                if ($('table#list_prop_product tbody tr').length > 1) {
                    load_prop_product(active_item());
                } else {
                    load_prop_product(active_item() - 1);
                }

            }
        })
    });
</script>
