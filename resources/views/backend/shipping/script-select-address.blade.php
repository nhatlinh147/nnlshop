<script>
    var all_district = {!! $all_district !!};
    var all_ward = {!! $all_ward !!};

    const option = function(array, equalValue) {
        var str = '';
        var key = Object.keys(array[0]); //Tập hợp key lại thành mảng
        if (equalValue != 0) {
            array.forEach(element => {
                if (element[key[3]] == equalValue) {
                    str +=
                        `<option value="${element[key[0]]}">${element[key[1]]}</option>`;
                }
            });
        } else {
            str =
                `<option value="0">Xin lựa chọn ${key[0] == 'District_ID' ? 'quận/huyện' : 'xã/phường'}</option>`;
        }
        return str;
    }

    $(document).on('change', 'div.form-group select:not(#Ward)', function() {
        var getType = $(this).attr('id');
        var getId = $(this).val();
        // console.log(getId);

        if (getType == 'Province') {
            $('#District').html(option(all_district, getId)); // truyền giá trị vào #District và #Ward
            $('div.form-group select:not(#Ward)').eq(1).trigger('change');
        } else {
            $('#Ward').html(option(all_ward, getId));
        }
    }); // end select-ajax
</script>
