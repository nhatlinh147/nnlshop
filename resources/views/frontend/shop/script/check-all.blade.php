<script>
    $(document).on('click', 'form div.custom-control:nth-child(1) input', function() {
        show_product(1);
        var check = $(this).prop('checked') == true ? 1 : 0;
        // Chọn checkbox không phải là all
        var selector = $(this).parent().parent('form').children('div:not(:first-child)').children('input');
        if (check == 1) {
            selector.prop('checked', true);
        } else {
            selector.prop('checked', false);
        }
    });

    $(document).on('click', 'form div.custom-control:not(:first-child) input', function() {
        show_product(1);
        // Toàn bộ các thành phần trong form
        var form = $(this).parent().parent('form');

        var selector_all = form.children('div:first-child').children('input');
        var selector_value = form.children('div:not(:first-child)').children('input');

        var unchecked = 0;

        selector_value.each(function(element) {
            if ($(this).prop('checked') == false) {
                unchecked++;
            }
        })

        if (unchecked == 0) {
            selector_all.prop('checked', true);
        } else {
            selector_all.prop('checked', false);
        }
    });
</script>
