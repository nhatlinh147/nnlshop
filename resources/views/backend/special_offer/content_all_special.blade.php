@php
$i = 1;
@endphp
@foreach ($all_special as $key => $special)
    <tr>
        <th scope="row">{{ $i++ }}</th>
        <td>{{ $special->Special_Title }}</td>
        <td><img src="{{ url('public/upload/special/' . $special->Special_Image) }}" height="100" width="100" /></td>
        <td class="text-center">
            @php
                $create_now = date_create($now);
                $create_end = date_create($special->Special_End);
                // $diff = date_diff($create_now);
                if (strtotime($special->Special_End) < strtotime($now)) {
                    echo '<span class="text-danger">Hết hạn</span>';
                } elseif (strtotime($special->Special_End) == strtotime($now)) {
                    echo '<span class="text-warning">Trong hôm nay</span>';
                } else {
                    echo '<span class="text-success">' . date_diff(date_create($now), date_create($special->Special_End))->format('%a') . '</span>';
                }
            @endphp
        </td>
        <td>
            <div class="switch-button switch-button-success">
                <input type="checkbox" name="switch{{ $special->Special_ID }}"
                    {{ $special->Special_Status == 1 ? 'Checked' : '' }} id="switch{{ $special->Special_ID }}"
                    data-id="{{ $special->Special_ID }}" class="update_status">
                <span>
                    <label for="switch{{ $special->Special_ID }}"></label>
                </span>
            </div>
        </td>
        <td>
            <a href="{{ url('back-end/chinh-sua-chien-dich-khuyen-mai/' . $special->Special_ID) }}"
                class="btn btn-success btn-xs editSpecial" data-id="{{ $special->Special_ID }}">Sửa</a>
            <a href="javascript:void(0)" class="btn btn-danger btn-xs deleteSpecial"
                data-id="{{ $special->Special_ID }}">Xóa</a>
        </td>
        <td>
            <a href="javascript:void(0)" id="SpecialOfferDetail" data-id="{{ $special->Special_ID }}">Xem chi tiết</a>
        </td>
    </tr>
@endforeach
