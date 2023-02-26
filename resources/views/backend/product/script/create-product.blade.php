<script>
    $('#create-product').click(function() {
        $("#productForm").clearValidation();
        $(".product_image").rules('add', 'required accept');

        $('#product_id').val('');
        $('#Image_Product').val('');
        $('#Document_Product').val('');
        $('#productForm').trigger("reset");
        $('.product_tag').tagsinput('removeAll');
        $('.see_product_image').empty();
        $('.see_product_document').empty();
        CKEDITOR.instances['Ckeditor_Desc'].setData('');
        CKEDITOR.instances['Ckeditor_Content'].setData('');
        $('#btn-save').val("Thêm sản phẩm");
        $('#Title_Product').html("Thêm sản phẩm mới");
        $('#ajax-product-modal').modal('show');
    });
</script>
