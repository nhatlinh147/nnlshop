<script>
    $(document).on('click', 'a#Edit_Prop', function() {
        var prop_id = $(this).data('prop_id');
        $('#edit_prop_modal').modal('show');
        $('input.edit_prop_id').val(prop_id);
        $.ajax({
            url: '{{ route('backend.edit_prop') }}',
            type: 'post',
            dataType: 'json',
            data: {
                _token: _token,
                prop_id: prop_id
            },
            success: function(data) {
                $('span.textListProduct').text(data['prop_product_id']);
                $('form#edit_prop_form input[type=checkbox]').prop('checked', false);

                data['prop_size'].forEach(element => {
                    $('input.edit_prop_size.' + element).prop('checked', true);
                });

                data['prop_color'].forEach(element => {
                    $('input.edit_prop_color.' + element).prop('checked', true);
                });
            }
        })
    });

    $("form#edit_prop_form").validate({
        ignore: [],
        groups: {
            edit_size_color: 'edit_prop_size[] edit_prop_color[]'
        },
        rules: {
            'edit_prop_size[]': {
                required: function() {
                    return ($('input.edit_prop_size').is(":checked") == false && $(
                        'input.edit_prop_color').is(
                        ":checked") == false);
                }
            },
            'edit_prop_color[]': {
                required: function() {
                    return ($('input.edit_prop_size').is(":checked") == false && $(
                        'input.edit_prop_color').is(
                        ":checked") == false);
                }
            }
        },
        messages: {
            'edit_prop_size[]': {
                required: "Phải lựa chọn mục kích thước hoặc màu sắc",
            },
            'edit_prop_color[]': {
                required: "Phải lựa chọn mục kích thước hoặc màu sắc",
            }
        },
        errorLabelContainer: $("form#edit_prop_form div.error"),
        submitHandler: function() {

            var edit_prop_tagsInput = $('span.textListProduct').text();
            var form_edit = new FormData($("form#edit_prop_form")[0]);
            $.ajax({
                data: form_edit,
                url: '{{ route('backend.save_prop') }}',
                type: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log("Thành công");
                    $('div#edit_prop_modal').modal('hide');
                    load_prop_product(active_item());
                },
                complete: function(data) {
                    console.log("Hoàn thành");
                }
            });
        } // END submitHandler
    }); // END validate
</script>
