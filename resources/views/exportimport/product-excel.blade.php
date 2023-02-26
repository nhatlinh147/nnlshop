<table>
    <thead>
        <tr>
            <td colspan="11" style="text-align: center;font-size: 14pt;font-weight: bold">Thông tin toàn bộ sản phẩm
            </td>
        </tr>
        <tr>
            <th style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;">Thứ
                tự</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 5cm">
                Từ khóa thẻ meta</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 5cm">
                Tên sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 5cm">
                Slug sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 3cm">
                Danh mục</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 7cm">
                Tóm tắt sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 7cm">
                Mô tả sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6; width: 7cm">
                Nội dung sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;width: 3cm">
                Giá sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;width: 3cm">
                Giá gốc sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;width: 3cm">
                Số lượng sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;width: 4cm">
                Hình ảnh sản phẩm</th>
            <th
                style="word-wrap: break-word;font-weight: bold;background-color: #ffef5d;border:1px solid #d8d6d6;width: 3cm">
                Trạng thái sản phẩm</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($products as $product)
            <tr>
                <td>{{ $i++ }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{{ $product->Meta_Keywords_Product }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{{ $product->Product_Name }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{{ $product->Product_Slug }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{{ $product->category->Category_Name }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{!! $product->Product_Summary !!}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{!! $product->Product_Desc !!}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{!! $product->Product_Content !!}</td>
                <td style="border:1px solid #d8d6d6;">{{ $product->Product_Price }}</td>
                <td style="border:1px solid #d8d6d6;">{{ $product->Product_Cost }}</td>
                <td style="border:1px solid #d8d6d6;">{{ $product->Product_Quantity }}</td>
                <td style="word-wrap: break-word;border:1px solid #d8d6d6;">{{ $product->Product_Image }}</td>
                @if ($product->Product_Status == 1)
                    <td style="border:1px solid #d8d6d6;">Đã kích hoạt</td>
                @else
                    <td style="border:1px solid #d8d6d6;">Chưa kích hoạt</td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>
