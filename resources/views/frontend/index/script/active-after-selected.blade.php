<script>
    var href = window.location.href;

    $('div.nav-left-sidebar .nav-item .nav-link').each(function(index) {
        var selector = $(this).parents('li.nav-item').parents('ul.nav');
        if ($(this).attr("href") == href) {
            if (selector.length > 0) {
                selector.parents('.submenu').prev('.nav-link').addClass('active');
                selector.parents('.submenu').collapse('show');
                $(this).addClass("active");
            } else {
                $(this).addClass("active");
            }
        }
    })
</script>
