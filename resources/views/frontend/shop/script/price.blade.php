<script type="text/javascript">
    $(document).on('click', 'form#Filter_Price div.custom-control input', function() {
        var selector = $('form#Filter_Price div.custom-control input');
        var array_min = [];
        var array_max = [];
        selector.each(function() {
            if ($(this).prop('checked') == true) {
                array_min.push($(this).data('min'));
                array_max.push($(this).data('max'));
            }
        });
        // console.log(array_min);
        // console.log(array_max);
    })
</script>
