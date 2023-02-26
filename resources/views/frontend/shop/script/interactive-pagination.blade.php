<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();

            $('li').removeClass('active');
            $(this).parent('li').addClass('active');

            var myurl = $(this).attr('href');
            var page = $(this).attr('href').split('page=')[1];

            show_product(page);
        });
    });

    function show_product(page) {
        var selector_price = $('form#Filter_Price div.custom-control input');
        var selector_color = $('form#Filter_Color div.custom-control input');
        var selector_size = $('form#Filter_Size div.custom-control input');

        // Lọc theo thuộc tính bên trái
        var array_min = filter_checked.checked_left(selector_price, 'min');
        var array_max = filter_checked.checked_left(selector_price, 'max');
        var colors = filter_checked.checked_left(selector_color, 'color');
        var sizes = filter_checked.checked_left(selector_size, 'size');

        // Lọc theo thuộc tính bên trên
        var filter = $('div#Filter_Top a.dropdown-item.active').data('filter');
        var paginate = $('div#Filter_Top a.dropdown-item.active').eq(1).data('paginate');
        let params = new URLSearchParams(location.search);

        $.ajax({
            url: '?page=' + page,
            type: "get",
            data: {
                array_min: array_min,
                array_max: array_max,
                colors: colors,
                sizes: sizes,
                filter: filter,
                paginate: paginate,
                have_child: params.get('have_child'),
                category: params.get('category'),
                Search_Product: params.get('Search_Product')
            },
            datatype: "html"
        }).done(function(data) {
            $("#Product_Show_Shop").empty().html(data);
            location.hash = page;
            // console.log(data);
        }).fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('No response from server');
        });
    }
</script>
<script>
    $(document).on('click', 'div#Filter_Top a.dropdown-item', function() {
        var isDataFilter = $(this).data('filter') != undefined ? 1 : 0;
        if (isDataFilter == 1) {
            var selector = $('div#Filter_Top div.btn-group:not(:nth-of-type(3)) a.dropdown-item');
        } else {
            var selector = $('div#Filter_Top div.btn-group:nth-of-type(3) a.dropdown-item');
        }
        selector.removeClass('active');
        $(this).addClass('active');

        show_product(1);
    })
</script>
