<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thông tin sản phẩm</title>
    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 80%;
        }

        table,
        table tr,
        table tr td,
        table th {
            border: 1px solid #000;
            text-align: center;
        }

        table {
            width: 100%;
        }

        h2,
        h1 {
            text-align: center;
        }

        td.Product_Name {
            text-align: start;
            padding-left: 6px;
        }
    </style>
</head>

<body>
    <h1>Tổng hợp các sản phẩm</h1>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Hình ảnh sản phẩm</th>
                <th>Danh mục</th>
                <th>Tóm tắt sản phẩm</th>
                <th>Tình trạng</th>
                <th>Ngày thêm sản phẩm</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_product as $key => $product)
                <tr>
                    <td class="Product_Name">{{ $product->Product_Name }}</td>
                    <td>{{ $product->Product_Price }}</td>
                    <td>
                        <img src="{{ public_path('upload/product/' . $product->Product_Image) }}" height="100"
                            width="100" />
                    </td>
                    <td>{{ $product->category->Category_Name }}</td>
                    <td>{{ $product->Product_Summary }}</td>
                    <td>
                        <?php
                        if ($product->Product_Status == 0) {
                            echo 'Chưa kích hoạt';
                        } else {
                            echo 'Đã kích hoạt';
                        }
                        ?>
                    </td>
                    <td>24.08.2021</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
