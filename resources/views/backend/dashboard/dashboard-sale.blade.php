@extends('backend.admin-layout')
@section('link')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Các thư viện ui css trong jquery -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection
@section('content')
    <style>
        .tooltipFormat_style {
            max-width: 100px;
            height: 26px;
            display: flex;
            justify-content: center;
        }

        .tooltipFormat_value {
            margin: 2px 4px;
            color: white;
        }
    </style>

    <div class="container-fluid dashboard-content">
        <div class="row">
            <!-- metric -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Chi phí</h5>
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1 text-primary" id="total_expences"></h3>
                        </div>
                        <div id="growth_expenses">

                        </div>
                    </div>
                    <div id="sparkline-1"></div>
                </div>
            </div>
            <!-- /. metric -->
            <!-- metric -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Đơn hàng</h5>
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1 text-primary" id="total_order"></h3>
                        </div>
                        <div id="growth_order">

                        </div>
                    </div>
                    <div id="sparkline-2"></div>
                </div>
            </div>
            <!-- /. metric -->
            <!-- metric -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Thu nhập</h5>
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1 text-primary" id="total_income"></h3>
                        </div>
                        <div id="growth_income">

                        </div>
                    </div>
                    <div id="sparkline-3">
                    </div>
                </div>
            </div>
            <!-- /. metric -->
            <!-- metric -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-muted">Số lượng</h5>
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1 text-primary" id="total_quantity"></h3>
                        </div>
                        <div id="growth_quantity">

                        </div>
                    </div>
                    <div id="sparkline-4"></div>
                </div>
            </div>

            <!-- /. metric -->
        </div>
        <!-- ============================================================== -->
        <!-- revenue  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h3 class="card-header" style="font-weight:bold">Doanh thu và chi phí</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 style="text-align: center" class="text-muted">7 Ngày gần đây</h4>
                                <canvas id="current_week"></canvas>
                            </div>
                            <div class="col-xl-6">
                                <h4 style="text-align: center" class="text-muted">7 Ngày trước đó</h4>
                                <canvas id="last_week"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 p-3">
                                <div id="evaluate_chart_one">
                                </div>
                            </div>
                            <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                <div id="evaluate_chart_two">
                                </div>

                            </div>
                            <div class="offset-xl-1 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 p-3">
                                <div id="evaluate_chart_three">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end reveune  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- total sale  -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Customer</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">1245</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i
                                                class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card border-3 border-top border-top-primary">
                                <div class="card-body">
                                    <h5 class="text-muted">Visitor</h5>
                                    <div class="metric-value d-inline-block">
                                        <h1 class="mb-1">1245</h1>
                                    </div>
                                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i
                                                class="fa fa-fw fa-arrow-up"></i></span><span class="ml-1">10%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Tài khoản đăng ký</h5>
                        <div class="card-body">
                            <canvas id="total-sale" width="220" height="130"></canvas>
                            <div class="chart-widget-list">
                                <p>
                                    <span class="fa-xs text-primary mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                                <p>
                                    <span class="fa-xs text-secondary mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                                <p class="mb-0">
                                    <span class="fa-xs text-info mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <h5 class="card-header">Hình thức thanh toán</h5>
                        <div class="card-body">
                            <canvas id="total-sale" width="220" height="130"></canvas>
                            <div class="chart-widget-list">
                                <p>
                                    <span class="fa-xs text-primary mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                                <p>
                                    <span class="fa-xs text-secondary mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                                <p class="mb-0">
                                    <span class="fa-xs text-info mr-1 legend-title"><i
                                            class="fa fa-fw fa-square-full"></i></span>
                                    <span class="legend-text"></span>
                                    <span class="float-right"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card">
                        <h5 class="card-header">Sản phẩm được quan tâm nhiều</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">Thứ tự</th>
                                            <th class="border-0">Tên sản phẩm</th>
                                            <th class="border-0">Mã sản phẩm</th>
                                            <th class="border-0">Số lượng đã bán</th>
                                            <th class="border-0">Phí vận chuyển</th>
                                            <th class="border-0">Thời gian đặt gần đây</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content_tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <h5 class="card-header">Đơn hàng gần đây</h5>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0">Thứ tự</th>
                                            <th class="border-0">Tên sản phẩm</th>
                                            <th class="border-0">Kho còn lại</th>
                                            <th class="border-0">Số lượng đã bán</th>
                                            <th class="border-0">Giá sản phẩm</th>
                                            <th class="border-0">Thời gian đặt gần đây</th>
                                        </tr>
                                    </thead>
                                    <tbody id="content_tbody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end total sale  -->
            <!-- ============================================================== -->
        </div>

    </div>
@endsection
@section('script')
    <script>
        function format_number(n, currency) {
            if (Array.isArray(n)) {
                var newArr = [];
                n.forEach(element => {
                    var number = Number(element).toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + currency;
                    newArr.push(number)
                });
                return newArr;
            } else {
                return Number(n).toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + currency;
            }

        }

        function chart7daysorder() {
            $.ajax({
                url: '{{ route('backend.order_statistics_ajax') }}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,

                success: function(data) {

                    // var values = ['sales'];
                    let sum_income = 0;
                    let sum_sales = 0;
                    let sum_expenses = 0;
                    let sum_CoH = 0;
                    let sum_quantity = 0;
                    let sum_order = 0;

                    let sum_income_ago = 0;
                    let sum_sales_ago = 0;
                    let sum_expenses_ago = 0;
                    let sum_CoH_ago = 0;
                    let sum_quantity_ago = 0;
                    let sum_order_ago = 0;


                    income = [];
                    sales = [];
                    expenses = [];
                    CoH = [];
                    period = [];
                    order = [];
                    quantity = [];

                    period_ago = [];
                    sales_ago = [];
                    expenses_ago = [];
                    // Xử lý dữ liệu 15 ngày gần đây
                    data.current_week.forEach(element => {
                        sales.push(element.sales);
                        sum_sales += Number(element.sales);

                        order.push(element.order);
                        sum_order += Number(element.order);

                        quantity.push(element.quantity);
                        sum_quantity += Number(element.quantity);

                        period.push(element.period);

                        expenses.push(element.expenses);
                        sum_expenses += Number(element.expenses);
                        // sum_expenses_ago += Number(element.expenses_ago);

                        CoH.push(element.CoH);
                        sum_CoH += Number(element.CoH);
                        // sum_CoH_ago += Number(element.CoH_ago);

                        var calculate_income = Math.round((Number(element.sales) - Number(element
                            .expenses)) * 0.8);
                        income.push(calculate_income);
                        sum_income += calculate_income;
                    });

                    // Xử lý dữ liệu 15 trước đó nữa
                    data.last_week.forEach(element => {

                        period_ago.push(element.period_ago);

                        sales_ago.push(element.sales_ago);
                        expenses_ago.push(element.expenses_ago);

                        sum_sales_ago += Number(element.sales_ago);
                        sum_expenses_ago += Number(element.expenses_ago);

                        sum_order_ago += Number(element.order_ago);
                        sum_quantity_ago += Number(element.quantity_ago);

                        var calculate_income_ago = Math.round((Number(element.sales_ago) - Number(
                            element.expenses_ago)) * 0.8);
                        sum_income_ago += calculate_income_ago;
                    });

                    //Thành tiền
                    let myArrayOne = {
                        total_expences: sum_expenses,
                        total_order: sum_order,
                        total_income: sum_income,
                        total_quantity: sum_quantity
                    };
                    //% tăng trưởng
                    let myArrayTwo = {
                        growth_expenses: (sum_expenses - sum_expenses_ago) / sum_expenses_ago,
                        growth_order: (sum_order - sum_order_ago) / sum_order_ago,
                        growth_income: (sum_income - sum_income_ago) / sum_income_ago,
                        growth_quantity: (sum_quantity - sum_quantity_ago) / sum_quantity_ago
                    };


                    for (var key in myArrayOne) {
                        if (key == 'total_quantity') {
                            var currency = " Sản phẩm";
                        } else if (key == 'total_order') {
                            var currency = " Đơn";
                        } else {
                            var currency = " VND";
                        }
                        $(`#${key}`).text(format_number(myArrayOne[key], currency));
                        $(`#${key}`).css({
                            'font-weight': '800'
                        })
                    }

                    $(`#${key}`).css({
                        'font-weight': '800'
                    })

                    for (var key in myArrayTwo) {
                        // $(`.${key}`).text((myArrayTwo[key]*100).toFixed(2));
                        if (myArrayTwo[key] >= 0) {
                            $(`#${key}`).html(`
                                    <div class="metric-label d-inline-block float-right text-success font-weight-bold">
                                        <span class="icon-circle-small icon-box-xs text-success bg-success-light"><i class="fa fa-fw fa-arrow-up"></i></span>
                                        <span class="ml-1">${(myArrayTwo[key]*100).toFixed(2)}%</span>
                                    </div>
                                `);
                        } else {
                            $(`#${key}`).html(`
                                <div class="metric-label d-inline-block float-right text-secondary font-weight-bold">
                                    <span class="icon-circle-small icon-box-xs text-danger bg-danger-light"><i class="fa fa-fw fa-arrow-down"></i></span>
                                    <span class="ml-1">${Math.abs(myArrayTwo[key]*100).toFixed(2)}%</span>
                                </div>
                                `);
                        }

                    }

                    $("#sparkline-1").sparkline(expenses, {
                        type: 'line',
                        width: '99.5%',
                        height: '100',
                        lineColor: '#5969ff',
                        fillColor: '#dbdeff',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: undefined,
                        maxSpotColor: undefined,
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true
                    });

                    $("#sparkline-2").sparkline(order, {
                        type: 'line',
                        width: '99.5%',
                        height: '100',
                        lineColor: '#ff407b',
                        fillColor: '#ffdbe6',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: undefined,
                        maxSpotColor: undefined,
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true
                    });

                    $("#sparkline-3").sparkline(income, {
                        type: 'line',
                        width: '99.5%',
                        height: '100',
                        lineColor: '#25d5f2',
                        fillColor: '#dffaff',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: undefined,
                        maxSpotColor: undefined,
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true,
                    });

                    $("#sparkline-4").sparkline(quantity, {
                        type: 'line',
                        width: '99.5%',
                        height: '100',
                        lineColor: '#fec957',
                        fillColor: '#fff2d5',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: undefined,
                        maxSpotColor: undefined,
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true,
                    });

                    //Fomat lại ngày theo dạng dd-mm
                    function format_dd_mm(array_date) {
                        var newArr = [];
                        array_date.forEach(element => {
                            var m = new Date(element);
                            var dateString = ("0" + m.getUTCDate()).slice(-2) + "-" + ("0" + (m
                                .getUTCMonth() + 1)).slice(-2);
                            // +  m.getUTCFullYear()
                            newArr.push(dateString);
                        });
                        return newArr;
                    }

                    //Loại bỏ phần tử giống nhau
                    function unique(arr) {
                        var newArr = []
                        newArr = arr.filter(function(item) {
                            return newArr.includes(item) ? '' : newArr.push(item)
                        })
                        return newArr
                    }

                    var current_week = document.getElementById('current_week').getContext('2d');
                    var last_week = document.getElementById('last_week').getContext('2d');

                    var current = new Chart(current_week, {
                        type: 'line',

                        data: {
                            labels: unique(format_dd_mm(period)),
                            datasets: [{
                                label: 'Doanh Thu',
                                data: sales,
                                backgroundColor: "rgba(89, 105, 255,0.5)",
                                borderColor: "rgba(89, 105, 255,0.7)",
                                borderWidth: 2

                            }, {
                                label: 'Chi phí',
                                data: expenses,
                                backgroundColor: "rgba(255, 64, 123,0.5)",
                                borderColor: "rgba(255, 64, 123,0.7)",
                                borderWidth: 2
                            }]
                        },
                        options: {
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return format_number(tooltipItem.yLabel, " VND");
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'bottom',

                                labels: {
                                    fontColor: '#71748d',
                                    fontFamily: 'Circular Std Book',
                                    fontSize: 14,
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return value + ' VND';
                                        }
                                    }
                                }]
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        fontSize: 14,
                                        fontFamily: 'Circular Std Book',
                                        fontColor: '#71748d',
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        fontSize: 14,
                                        fontFamily: 'Circular Std Book',
                                        fontColor: '#71748d',
                                    }
                                }]
                            }
                        }
                    });

                    var last = new Chart(last_week, {
                        type: 'line',

                        data: {
                            labels: unique(format_dd_mm(period_ago)),
                            datasets: [{
                                label: 'Doanh Thu',
                                data: sales_ago,
                                backgroundColor: "rgba(89, 105, 255,0.5)",
                                borderColor: "rgba(89, 105, 255,0.7)",
                                borderWidth: 2

                            }, {
                                label: 'Chi phí',
                                data: expenses_ago,
                                backgroundColor: "rgba(255, 64, 123,0.5)",
                                borderColor: "rgba(255, 64, 123,0.7)",
                                borderWidth: 2
                            }]
                        },
                        options: {
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        return format_number(tooltipItem.yLabel, " VND");
                                    }
                                }
                            },
                            legend: {
                                display: true,
                                position: 'bottom',

                                labels: {
                                    fontColor: '#71748d',
                                    fontFamily: 'Circular Std Book',
                                    fontSize: 14,
                                }
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        // Include a dollar sign in the ticks
                                        callback: function(value, index, values) {
                                            return value + ' VND';
                                        }
                                    }
                                }]
                            },
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        fontSize: 14,
                                        fontFamily: 'Circular Std Book',
                                        fontColor: '#71748d',
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        fontSize: 14,
                                        fontFamily: 'Circular Std Book',
                                        fontColor: '#71748d',
                                    }
                                }]
                            }
                        }
                    });

                    let i = -1;
                    set_customer = [];
                    for (var key in data.customer) {
                        i++;
                        $('.chart-widget-list .legend-text').eq(i).text(key);
                        $('.chart-widget-list .legend-text').eq(i).css('text-transform', 'uppercase');
                        $('.chart-widget-list .float-right').eq(i).text(data.customer[key]);
                        set_customer.push(data.customer[key]);
                    }


                    $('#evaluate_chart_one').html(`
                            <h4 style="font-weight:bold">Doanh thu hôm nay:
                            <p>${format_number(Number(data.statistic_today[0].sum_sales_today)," VNĐ")}</p>
                            Chi phí hôm nay:
                            <p>${format_number(data.statistic_today[0].sum_expenses_today," VNĐ")}</p>
                            </h4>

                        `);
                    $('#evaluate_chart_two').html(`
                            <h3 class="font-weight-bold mb-3"><span>${format_number(sum_sales," VNĐ")}</span></h3>
                            <div class="mb-0 mt-3 legend-item">
                                <span class="fa-xs text-primary mr-1 legend-title "><i class="fa fa-fw fa-square-full"></i></span>
                                <span class="legend-text">Tổng doanh thu</span>
                            </div>
                        `);
                    $('#evaluate_chart_three').html(`
                            <h3 class="font-weight-bold mb-3">
                                <span>${format_number(sum_expenses," VNĐ")}</span>
                            </h3>
                            <div class="text-muted mb-0 mt-3 legend-item">
                                <span class="fa-xs text-secondary mr-1 legend-title">
                                    <i class="fa fa-fw fa-square-full"></i>
                                </span><span class="legend-text">Tổng chi phí</span>
                            </div>
                        `);


                    var ctx = document.getElementById("total-sale").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',

                        data: {
                            labels: ["NNLShop", " Google", "Facebook"],
                            datasets: [{
                                backgroundColor: [
                                    "#5969ff",
                                    "#ff407b",
                                    "#25d5f2"
                                ],
                                data: set_customer,
                            }]
                        },
                        options: {
                            legend: {
                                display: false

                            }
                        }

                    });
                    var j = 1;
                    for (var key in data.all_order_details) {
                        var total_quantity = data.all_order_details[key].total_quantity;
                        var product_name = data.all_order_details[key].Product_Name;
                        var product_fee = data.all_order_details[key].total_delivery;
                        var order_time = data.all_order_details[key].order_time;

                        console.log(data.all_order_details[key].Order_Code);
                        $('#content_tbody').append(`
                            <tr>
                                <td>${j++}</td>
                                <td>${product_name}</td>
                                <td>00${Math.floor(Math.random() * 1000)}</td>
                                <td>${total_quantity}</td>
                                <td>${format_number(product_fee," VNĐ")}</td>
                                <td>${order_time}</td>
                            </tr>
                        `);
                    }


                } // END success
            }); // END ajax
        } // END create functuon chart7daysorder


        chart7daysorder();
    </script>
@endsection
