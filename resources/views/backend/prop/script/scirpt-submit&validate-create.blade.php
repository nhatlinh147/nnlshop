<script>
    // Script write about submit[Tạo thuộc tính] and validate it
    // Go to script file
    $("#Form_Prop_Product").validate({
        ignore: [],
        groups: {
            prop_size_color: 'prop_size[] prop_color[]'
        },
        rules: {
            // simple rule, converted to {required:true}
            prop_tagsInput: {
                required: function(params) {
                    if ($('span.amsify-select-tag').length == 0) {
                        console.log(true);
                        return true;
                    } else {
                        console.log(true);
                        return false;
                    }

                }
            },
            'prop_size[]': {
                required: function() {
                    return ($('input.prop_size').is(":checked") == false && $(
                        'input.prop_color').is(
                        ":checked") == false);
                }
            },
            'prop_color[]': {
                required: function() {
                    return ($('input.prop_size').is(":checked") == false && $(
                        'input.prop_color').is(
                        ":checked") == false);
                }
            }
        },
        messages: {
            // simple rule, converted to {required:true}
            prop_tagsInput: {
                required: "Tags sản phẩm không được để trống"
            },
            'prop_size[]': {
                required: "Phải lựa chọn mục kích thước hoặc màu sắc",
            },
            'prop_color[]': {
                required: "Phải lựa chọn mục kích thước hoặc màu sắc",
            }
        },
        errorPlacement: function(error, element) {
            if (element.is(":checkbox"))
                error.insertAfter(element.parent("label").parent("div.text-center"));
            else
                error.insertAfter(element.parent("div.form-group"));
        },
        submitHandler: function(form) {
            var array_tag = '';
            var checked = 0;
            $('span.amsify-select-tag').each(function() {
                var comma = checked++ > 0 ? ',' : '';
                array_tag += comma + $(this).data('val');
            });

            var form_data = new FormData($("#Form_Prop_Product")[0]);
            form_data.append('prop_tagsInput', array_tag);

            $.ajax({
                data: form_data,
                url: '{{ route('backend.save_prop') }}',
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    //Refresh lại dữ liệu để lần submit sau có thể validate tagsinput
                    autocomplete_list_product();
                    $('input#prop_tagsInput').val('');

                    $('div#message').html(
                        `<div class="alert alert-success">Thêm thuộc tính sản phẩm thành công</div>`
                    );
                    load_prop_product(active_item());

                    //Xóa đi những checked của người dùng
                    $('form#Form_Prop_Product input[type=checkbox]').prop('checked',
                        false);
                    setTimeout(function() {
                        $(`div.alert.alert-success`).fadeOut().remove();
                    }, 15000);
                },
                complete: function(data) {
                    $('#collapseAllPropProduct').addClass('show');
                }
            });
        } // END submitHandler
    }); // END validate
</script>
