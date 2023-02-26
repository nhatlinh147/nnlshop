<script>
    $('body').on('click', '.edit-product', function() {

        var product_id = $(this).data('id');

        $("#productForm").clearValidation();
        $(".product_image").rules('remove');

        $.get('sua-san-pham/' + product_id, function(data) {
            var product_quantity = format_number(data.Product_Quantity, "");
            var product_price = format_number(data.Product_Price, "");
            var product_cost = format_number(data.Product_Cost, "");

            $('#Title_Product').html("Sửa sản phẩm");
            $('#btn-save').val("Lưu sản phẩm");
            $('#ajax-product-modal').modal('show');
            $('#product_id').val(data.Product_ID);
            $('#Image_Product').val(data.Product_Image);
            $('#Document_Product').val(data.Product_Document);
            $('.product_name').val(data.Product_Name);
            $('.product_slug').val(data.Product_Slug);
            $('.product_summary').val(data.Product_Summary);
            $('.product_quantity').val(product_quantity);
            $('.product_price').val(product_price);
            $('.product_cost').val(product_cost);

            // Tagsinput Bootstrap
            $('input.product_tag').tagsinput('add', data.Product_Tag + ",");

            CKEDITOR.instances['Ckeditor_Desc'].setData(data.Product_Desc);
            CKEDITOR.instances['Ckeditor_Content'].setData(data.Product_Content);
            $('.meta_keywords_product').val(data.Meta_Keywords_Product);
            $('.category_product_name option[value="' + data.Category_ID + '"]').attr(
                'selected', 'selected');
            // $('.brand_product_name option[value="' + data.Brand_ID + '"]').attr('selected',
            //     'selected');
            $('.product_status option[value="' + data.Product_Status + '"]').attr(
                'selected', 'selected');

            //bắt đầu reset lại input
            $('.see_product_image').html(
                `<img src="{{ url('public/upload/product/${data.Product_Image}') }}" height="100" width="100" class="get_image"/>`
            );
            $('.see_product_document').empty();

        });
    });
</script>
