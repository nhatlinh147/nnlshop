<form class="mb-30" action="javascript:void(0)">
    @csrf
    <div class="input-group">
        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code" id="Coupon_code">
        <div class="input-group-append">
            <button class="btn btn-primary" id="Submit_Coupon">Apply Coupon</button>
        </div>
    </div>
</form>
<div id="message_coupon"></div>
@prepend('scripts')
    <script>
        //Kiểm tra mã coupon có áp dụng được không
        $('input#Coupon_code').change(function() {
            var get_coupon = $(this).val();
            $.ajax({
                url: '{{ route('frontend.check_coupon') }}',
                type: "post",
                data: {
                    get_coupon: get_coupon,
                    _token: token()
                },
                success: function(data) {
                    if (data.Coupon_ID != undefined) {
                        $('div#message_coupon').attr('class', 'alert alert-success');
                        $('div#message_coupon').html(`Mã ${data.Coupon_Code} có thể áp dụng`);

                        $('button#Submit_Coupon').css('cursor', 'pointer').removeClass('disabled');
                        $('button#Submit_Coupon').attr('data-amount', data.Coupon_Amount);
                    } else {
                        if (get_coupon != '') {
                            $('div#message_coupon').attr('class', 'alert alert-danger');
                            $('div#message_coupon').html(`Mã ${get_coupon} không thể áp dụng`);
                        } else {
                            $('div#message_coupon').empty();
                            $('div#message_coupon').attr('class', '');
                        }

                        $('button#Submit_Coupon').attr('data-amount', 0);
                        $('button#Submit_Coupon').css('cursor', 'not-allowed').addClass('disabled');
                    }
                }
            })
        })

        // //Tiến hành áp dụng coupon
        $(document).on('click', 'button#Submit_Coupon:not(.disabled)', function() {
            let get_coupon = $('input#Coupon_code').val();
            let get_amount = $(this).data('amount');
            $.ajax({
                url: '{{ route('frontend.apply_coupon') }}',
                type: "post",
                data: {
                    get_coupon: get_coupon,
                    get_amount: get_amount,
                    _token: token()
                },
                success: function(data) {
                    $('form.mb-30').remove();
                    $('div#message_coupon').html(
                        `Bạn vừa áp dụng mã <i>${data.Coupon_Code}</i> với mức giảm là <i>${data.Coupon_Condition == 2 ? format_number(data.Coupon_Number," đ") : data.Coupon_Number+' %'}</i>`
                    );
                    save_update_cart(0, 0, 0);
                }
            })
        })
    </script>
@endprepend
