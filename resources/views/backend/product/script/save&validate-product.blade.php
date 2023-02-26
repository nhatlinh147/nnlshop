<script>
    if ($("#productForm").length > 0) {
        $("#productForm").validate({
            ignore: [],
            rules: {
                // simple rule, converted to {required:true}
                product_name: {
                    required: true
                },
                // compound rule
                product_slug: {
                    required: true,
                    minlength: 4
                },
                product_quantity: {
                    required: true
                },
                product_price: {
                    required: true
                },
                product_cost: {
                    required: true
                },
                product_image: {
                    required: true,
                    accept: "image/*"
                },
                product_tag: {
                    required: true
                },
                product_summary: {
                    required: true
                },
                product_desc: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                product_content: {
                    required: function(textarea) {
                        CKEDITOR.instances[textarea.id].updateElement();
                        var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                        return editorcontent.length === 0;
                    }
                },
                meta_keywords_product: {
                    required: true
                },
                category_product_name: {
                    valueNotEquals: "" // so sánh giá trị trong select-option
                },
                // brand_product_name: {
                //     valueNotEquals: ""
                // }
            },
            messages: {
                // simple rule, converted to {required:true}
                product_name: {
                    required: "Tên danh mục sản phẩm không được để trống"
                },
                // compound rule
                product_slug: {
                    required: "Slug danh mục sản phẩm không được để trống",
                    minlength: "Slug danh mục sản phẩm cần ít nhất 4 ký tự"
                },
                product_quantity: {
                    required: 'Số lượng sản phẩm không được để trống'
                },
                product_price: {
                    required: "Giá bán sản phẩm không được để trống"
                },
                product_cost: {
                    required: "Giá gốc sản phẩm không được để trống"
                },
                product_image: {
                    required: "Hình ảnh sản phẩm không được để trống",
                    accept: "File nhập vào phải là file hình ảnh"
                },
                product_tag: {
                    required: "Tag sản phẩm không được để trống"
                },
                product_summary: {
                    required: "Tóm tắt sản phẩm không được để trống"
                },
                product_desc: {
                    required: "Mô tả sản phẩm không được để trống",
                },
                product_content: {
                    required: "Nội dung sản phẩm không được để trống",
                },
                meta_keywords_product: {
                    required: "Từ khóa tìm kiếm không được để trống"
                },
                category_product_name: {
                    valueNotEquals: "Cần lựa chọn danh mục sản phẩm"
                },
                // brand_product_name: {
                //     valueNotEquals: "Cần lựa chọn thương hiệu sản phẩm"
                // }
            },
            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                var get_image = $('#Image_Product').val();
                var get_document = $('#Document_Product').val();
                // await getBinaryFromFile(file);
                var data = new FormData($("#productForm")[0]);
                data.append('get_image', get_image);
                data.append('get_document', get_document);
                $.ajax({
                    data: data,
                    url: '{{ route('backend.save_product') }}',
                    type: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    complete: function() {
                        $('#ajax-product-modal').modal('hide');
                    },
                    success: function(data) {
                        $('#productForm').trigger("reset");

                        $('#btn-save').html('Lưu sản phẩm');
                        var oTable = $('table.second').DataTable();
                        oTable.ajax.reload(null, false);

                        //Dữ liệu ban đầu trong product_path là Path_Drive
                        // Chỉ cần tồn tại Path_Drive thì sẽ luôn load dữ liệu cho đến khi controller đưa dữ liệu ra path cụ thể
                        var reload_path = setInterval(
                            function() {
                                oTable.ajax.reload(null, false);

                                if ($('.read_by_ggdrive').data('product_path').includes(
                                        "Drive") == false) {
                                    clearInterval(reload_path);
                                }
                            }, 3000);

                        if (data.Product_Name) {
                            if (get_image == '') {
                                $('#message_product').after(
                                    "<div class='alert alert-info message_" + data
                                    .Product_Id +
                                    "'>Tạo sản phẩm: <i class='compareCondition'>" + data
                                    .Product_Name + "</i> thành công</div>");
                            } else {
                                $('#message_product').after(
                                    "<div class='alert alert-info message_" + data
                                    .Product_Id +
                                    "'>Lưu sản phẩm: <i class='compareCondition'>" + data
                                    .Product_Name + "</i> thành công</div>");
                            }
                            setTimeout(function() {
                                $('.message_' + data.Product_Id).fadeOut().remove();
                            }, 10000);
                        }
                    }, // END success
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    } // END error
                }); // END ajax
            } // END submitHandler
        }); // END validate
    }
</script>
