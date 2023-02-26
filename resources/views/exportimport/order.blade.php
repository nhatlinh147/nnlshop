<!DOCTYPE html>
<html lang="en">

<head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Thông tin đơn hàng</title>
        <style>
            body{
			    font-family: DejaVu Sans;
                font-size: 80%;
		    }
            table, table tr, table tr td,table th {
                border:1px solid #000;
            }
            table {
                width: 100%;
            }
            h2, h1{
                text-align: center;
            }
            h1{
                margin-bottom: 2px
            }
            .title{
                text-align: center;
                margin-bottom: 6px;
            }
        </style>
</head>

<body>
    <div class="title">
        <h1>{{$title}}</h1>
        @foreach ($shipping_info as $key=>$shipping)
        <small><i>Ngày đặt hàng: {{$shipping->created_at}}</i></small>
        @endforeach
    </div>
    <h2>Thông tin đăng nhập</h2>
    <table>
        <thead>
            <tr>
                <th>Tên khách hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Địa chỉ thường/tạm trú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer_info as $key=>$customer)
            <tr>
            <td>{{$customer->Customer_Name}}</td>
            <td>
                <?php
                $number = $customer->Customer_Phone;
                if( preg_match( '/(\d{3})(\d{3})(\d{3})$/', $number,  $matches ) )
                {
                    echo $result = '0'.$matches[1] . '-' .$matches[2] . '-' . $matches[3];
                }
                ?>
            </td>
            <td>{{$customer->Customer_Email}}</td>
            <td>{{$customer->Customer_Address}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Thông tin vận chuyển</h2>
    <table>
        <thead>
            <tr>
                <th>Tên người nhận hàng</th>
                <th>Địa điểm giao hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Ghi chú</th>
                <th>Hình thức thanh toán</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($shipping_info as $key=>$shipping)
            <tr>
            <td>{{$shipping->Shipping_Fullname}}</td>
            <td>{{$shipping->Shipping_Address}}</td>
            <td>
            <?php
                $number = $shipping->Shipping_Phone;
                if( preg_match( '/(\d{4})(\d{3})(\d{3})$/', $number,  $matches ) )
                {
                    echo $result = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
                }
            ?>
            </td>
            <td>{{$shipping->Shipping_Email}}</td>
            <td>{{$shipping->Shipping_Note}}</td>
            @if ($shipping->Shipping_Payment_Select == 0)
                <td>Qua chuyển khoản</td>
            @else
                <td>Tiền mặt</td>
             @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    <h2>Chi tiết đơn hàng</h2>
    <table>
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng kho còn</th>
                <th>Số lượng hàng khách đặt</th>
                <th>Số lượng hàng đã bán</th>
                <th>Giá</th>
                <th>Mã giảm giá</th>
                <th>Phí vận chuyển</th>
                {{-- <th>Phí ship hàng</th> --}}
                <th>Số lượng</th>
                <th>Tổng tiền</th>
            </tr>
        </thead>
        <tbody>
            @php
                    $total=0;
            @endphp
            @foreach ($manage_order as $key=>$order)
            @php
                $subtotal = ($order->Product_Price)*($order->Product_Sales_Quantity);
                $total+=$subtotal;
            @endphp
            <tr>
            <td>{{$order->Product_Name}}</td>
            <td>{{$order->product->Product_Quantity}}</td>
            <td>{{$order->Product_Sales_Quantity}}</td>
            <td>{{$order->product->Product_Sold}}</td>
            <td>{{number_format(($order->Product_Price),0,',','.').' đ'}}</td>
            @if ($order->Product_Coupon_Code != 'No')
                <td>{{$order->Product_Coupon_Code}}</td>
            @else
            <td>Không</td>
            @endif
            <td>{{number_format(($order->Product_Fee_Delivery),0,',','.').' đ'}}</td>
            {{-- <td>{{$order->Product_Fee_Delivery}}</td> --}}
            <td>{{$order->Product_Sales_Quantity}}</td>
            <td>{{number_format(($order->Product_Price*$order->Product_Sales_Quantity),0,',','.').' đ'}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <table>
        <tr>
            <td style="font-weight:bold">
            @php
                $total_coupon = 0;
            @endphp
            @if($coupon_condition==1)
                @php
                    $total_after_coupon = ($total*$coupon_number)/100;
                    echo 'Tổng giảm (theo mã giảm giá): '.number_format($total_after_coupon,0,',','.').' đ';
                    $total_coupon = $total - $total_after_coupon - $order->Product_Fee_Delivery;
                @endphp
            @else
                @php
                echo 'Tổng giảm (theo mã giảm giá): '.number_format($coupon_number,0,',','.').' đ';
                $total_coupon = $total - $coupon_number - $order->Product_Fee_Delivery;
                @endphp
            @endif
            </td>
            <td style="font-weight:bold">
            Thanh toán: {{number_format($total_coupon,0,',','.')}}đ
            </td>
        </tr>
    </table>


</body>

</html>
