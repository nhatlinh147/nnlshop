<script>
        var path = "{{ route('frontend.search_product') }}";
        $('input#Search_Product').typeahead({
            onSelect: function(item) {
                console.log(item);
            },
            ajax: {
                url: path,
                method: "get",
                displayField: "Product_Name",
                valueField: "Product_Slug",
                preDispatch: function(query) {
                    return {
                        query: query,
                    }
                },
                preProcess: function(data) {
                    return data;
                }
            },
            item: '<li><a href="#" role="option" class="dropdown-item text-wrap"></a></li>',
            select: function(item) {
                var a = this.$menu.find(".active");
                if (a.length) {
                    var b = a.attr("data-value"),
                        c = this.$menu.find(".active a").text();
                    window.location.href = "{{ url('front-end/chi-tiet-san-pham') }}/" + a.attr("data-value");
                    this.$element.val(this.updater(c)).change(), this.options.onSelect && this.options
                        .onSelect({
                            value: b,
                            text: c
                        })
                }
                return this.hide();
            },
            autoSelect: 0
        });
    </script>