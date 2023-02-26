<script>
    function get_notify_product() {
        $.ajax({
            url: '{{ route('backend.get_notify_product') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            dataType: 'json',
            success: function(data) {
                var str = '';

                var get_notify_success = data.get_notify_success;
                var get_notify_data = data.get_notify_data;

                var get_data = {!! Session::get('get_errors') !!};

                if (get_notify_success == 0) {
                    var elem = document.createElement("div");
                    elem.innerHTML = `<div id="get_notify_data" class="text-left">
                            </div>
                        `;

                    swal({
                        title: 'Không thành công',
                        text: 'Liệt kê lỗi',
                        content: elem,
                        dangerMode: true
                    });

                    for (let i = 0; i < get_notify_data.length; i++) {
                        str += '<p>' + get_notify_data[i] + '</p>';
                    }
                    $('div#get_notify_data ').html(str);
                } else {
                    $('#get_notify_data').empty();
                    swal({
                        title: "Thành công",
                        text: `${get_notify_success}`,
                        icon: "success",
                        button: "Ok",
                    });
                }
            } //End Success
        }); //End Ajax
    }

    var set = setInterval(
        function() {
            get_notify_product();
            $('table.second').DataTable().ajax.reload(null, false);
            if ($('div.swal-text').length > 0) {
                clearInterval(set);
            }
        }, 3000);
</script>
