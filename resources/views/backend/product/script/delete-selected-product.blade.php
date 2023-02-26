<script>
    $(document).on('click', '.title_checkbox', function() {
        var check = $(this).prop('checked') == true ? 1 : 0;
        product_id = [];
        $('input[class*="checkbox_"]').each(function() {
            product_id.push($(this).data('product_id'));
        });
        if (check == 1) {
            for (i = 0; i < product_id.length; i++) {
                $('.checkbox_' + product_id[i]).prop('checked', true);
            }
        } else {
            for (i = 0; i < product_id.length; i++) {
                $('.checkbox_' + product_id[i]).prop('checked', false);
            }
        }

        if (check == 1 && $('input[class*="checkbox_"]').prop('checked')) {
            $('.add-button-delete').html(
                '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-product-selected">Xóa</a>'
            );
            $('label.custom-control.custom-checkbox').css({
                'display': 'inline-block'
            });
        } else {
            $('.add-button-delete').empty();
        }


    }); //End click .delete_product
    $(document).on('click', 'input[class*="checkbox_"]', function() {
        var check = $(this).prop('checked') == true ? 1 : 0;
        product_id = [];
        $('input[class*="checkbox_"]').each(function() {
            product_id.push($(this).data('product_id'));
        });
        if (check == 0) {
            $('.title_checkbox').prop('checked', false);
        }
        for (i = 0; i < product_id.length; i++) {
            if ($('.checkbox_' + product_id[i]).is(':checked')) {
                $('.add-button-delete').html(
                    '<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-product-selected">Xóa</a>'
                );
                $('label.custom-control.custom-checkbox').css({
                    'display': 'inline-block'
                });

                break;
            } else {
                $('.add-button-delete').empty();
            }
        }

    });

    $(document).on('click', '.delete-product-selected', function() {

        var ids = [];
        var table = $('table.second').DataTable();
        table.rows().every(function() {
            const selector = $(this.node()).children('td:first-child').children('label').children(
                'input');
            if (selector.prop('checked')) {
                ids.push(selector.data('product_id'));
            }
        });

        var count_id = ids.length;
        $.ajax({
            url: '{{ route('backend.delete_product_selected') }}',
            type: 'get',
            dataType: 'json',
            data: {
                ids: ids
            },
            success: function(data) {
                if (data == count_id) {
                    $('.add-button-delete').empty();
                    $('.title_checkbox').prop('checked', false);
                }
                var oTable = $('table.second').DataTable();
                oTable.ajax.reload(null, false);

            } //End Success
        }); //End Ajax
    });
</script>
