@extends('backend.admin-layout')
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block" id="basicform">
                    <h3 class="section-title">Thêm sản phẩm</h3>
                    {{-- <p>Use custom button styles for actions in forms, dialogs, and more with support for multiple sizes, states, and more.</p> --}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <?php
                        $message = Session::get('message');
                        if ($message) {
                            echo '<div class="alert alert-info" style="font-weight:bold">' . $message . '</div>';
                            Session::put('message', null);
                        }
                        ?>
                        <form role="form" action="{{ route('backend.save_fee_shipping') }}" method="POST"
                            id="Form_Fee_Shipping" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="input-select">Chọn tỉnh/Thành phố: </label>
                                <select class="form-control" id="Province" name="fee_province_id">
                                    <option value="0">Xin lựa chọn tỉnh</option>
                                    @foreach ($all_province as $province)
                                        <option value="{{ $province->Province_ID }}">
                                            {{ $province->Province_Name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-select">Chọn Quận/Huyện</label>
                                <select class="form-control" id="District" name="fee_district_id">
                                    <option value="0">Xin lựa chọn quận/huyện</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input-select">Chọn Xã/Phường</label>
                                <select class="form-control" id="Ward" name="fee_ward_id">
                                    <option value="0">Xin lựa chọn xã/phường</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputText3" class="col-form-label">Phí vận chuyển</label>
                                <input type="text" class="form-control format_price" name="fee_shipping">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                style="display:flex;justify-content: center">
                                <button class="btn btn-primary" type="submit">Thiết lập</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if (count($shipping) > 0)
                    <div class="card">
                        <h5 class="card-header">Toàn bộ phí vận chuyển</h5>
                        <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Thứ tự</th>
                                        <th scope="col">Tỉnh</th>
                                        <th scope="col">Quận/Huyện</th>
                                        <th scope="col">Xã/Phường</th>
                                        <th scope="col">Phí giao hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $index = 1;
                                    @endphp
                                    @foreach ($shipping as $shi)
                                        <tr>
                                            <th scope="row">{{ $index++ }}</th>
                                            <td>{{ $shi->province->Province_Name }}</td>
                                            <td>{{ $shi->district->District_Name }}</td>
                                            <td>{{ $shi->ward->Ward_Name }}</td>
                                            <td contenteditable="true" data-fee_shipping_id="{{ $shi->Fee_Shipping_ID }}"
                                                data-fee_shipping="{{ $shi->Fee_Shipping }}" class="Fee_Shipping">
                                                {{ number_format($shi->Fee_Shipping, 0, ',', '.') . ' đ' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
@section('script')
    @include('backend.shipping.script-select-address')
    @include('backend.shipping.script-shipping-validate')
    <script>
        $('.Fee_Shipping').focus(function() {
            var getFeeShipping = $(this).attr('data-fee_shipping');
            $(this).text(getFeeShipping);
        });
        $('.Fee_Shipping').blur(function() {
            var fee_shipping_id = $(this).data('fee_shipping_id');
            var get_fee_shipping = $(this).text();
            var index = $(this).index('td:last-child');
            if (Number.isInteger(Number(get_fee_shipping))) {
                $.ajax({
                    url: '{{ route('backend.update_fee_shipping') }}',
                    method: 'GET',
                    data: {
                        fee_shipping_id: fee_shipping_id,
                        get_fee_shipping: get_fee_shipping
                    },
                    success: function(data) {
                        $("td.Fee_Shipping").eq(index).attr('data-fee_shipping', data.Fee_Shipping);
                        $("td.Fee_Shipping").eq(index).html(format_number(data.Fee_Shipping, " đ"));
                    } // end success
                }); //end ajax
            } else {
                $('.Fee_Shipping').eq(index).trigger('focus');
            }
        });
    </script>
@endsection
