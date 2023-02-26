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
            <div class="offset-xl-10 col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                <form>
                    <div class="form-group">
                        <input class="form-control" type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
                    </div>
                </form>
            </div>

        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Doanh thu</h5>
                    <div class="card-body">
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1" id="total_sales"></h3>
                        </div>
                        <div id="growth_total_sales">

                        </div>
                    </div>
                    <div class="card-body bg-light p-t-40 p-b-40">
                        <div id="sparkline-revenue"></div>
                    </div>
                    {{-- <div class="card-footer text-center bg-white">
                    <a href="#" class="card-link">View Details</a>
                </div> --}}
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Chi phí</h5>
                    <div class="card-body">
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1" id="total_expences"></h3>
                        </div>
                        <div id="growth_total_expences">

                        </div>
                    </div>
                    <div class="card-body text-center bg-light p-t-40 p-b-40">
                        <div id="sparkline-revenue2"></div>
                    </div>

                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Thu nhập</h5>
                    <div class="card-body">
                        <div class="metric-value d-inline-block">
                            <h3 class="mb-1" id="net_profit_margin"></h3>
                        </div>
                        <div id="growth_net_profit_margin">

                        </div>
                    </div>
                    <div class="card-body bg-light p-b-40 p-t-40">
                        <div id="sparkline-revenue4"></div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end revenue year  -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- ap and ar balance  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Doanh thu và chi phí
                    </h5>
                    <div class="card-body">
                        <canvas id="chartjs_balance_bar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- Các thư viện js ui trong jquery -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        function format_number(n, currency) {
            return n.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + currency;
        }

        function chart15daysorder() {
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{ route('backend.order_statistics_ajax') }}',
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "JSON",
                data: {
                    _token: _token
                },
                success: function(data) {
                    // var values = ['sales'];
                    let sum_profit = 0;
                    let sum_sales = 0;
                    let sum_expenses = 0;
                    let sum_CoH = 0;
                    let sum_profit_ago = 0;
                    let sum_sales_ago = 0;
                    let sum_expenses_ago = 0;
                    let sum_CoH_ago = 0;
                    profit = [];
                    sales = [];
                    expenses = [];
                    CoH = [];
                    period = [];
                    // Xử lý dữ liệu 15 ngày gần đây
                    data.current_week.forEach(element => {
                        sales.push(element.sales);
                        sum_sales += Number(element.sales);

                        period.push(element.period);

                        expenses.push(element.expenses);
                        sum_expenses += Number(element.expenses);
                        // sum_expenses_ago += Number(element.expenses_ago);

                        CoH.push(element.CoH);
                        sum_CoH += Number(element.CoH);
                        // sum_CoH_ago += Number(element.CoH_ago);

                        var calculate_profit = Math.round((Number(element.sales) - Number(element
                            .expenses)) * 0.8);
                        profit.push(calculate_profit);
                        sum_profit += calculate_profit;
                    });

                    // Xử lý dữ liệu 15 trước đó nữa
                    data.last_week.forEach(element => {
                        sum_sales_ago += Number(element.sales_ago);
                        sum_expenses_ago += Number(element.expenses_ago);
                        sum_CoH_ago += Number(element.CoH_ago);

                        var calculate_profit_ago = Math.round((Number(element.sales_ago) - Number(
                            element.expenses_ago)) * 0.8);
                        sum_profit_ago += calculate_profit_ago;
                    });

                    //Thành tiền
                    let myArrayOne = {
                        total_sales: sum_sales,
                        total_expences: sum_expenses,
                        cash_on_hand: sum_CoH,
                        net_profit_margin: sum_profit
                    };
                    //% tăng trưởng
                    let myArrayTwo = {
                        growth_total_sales: (sum_sales - sum_sales_ago) / sum_sales_ago,
                        growth_total_expences: (sum_expenses - sum_expenses_ago) / sum_expenses_ago,
                        growth_cash_on_hand: (sum_CoH - sum_CoH_ago) / sum_CoH_ago,
                        growth_net_profit_margin: (sum_profit - sum_profit_ago) / sum_profit_ago
                    };

                    for (var key in myArrayOne) {
                        $(`#${key}`).text(format_number(myArrayOne[key], " VNĐ"));
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

                    $("#sparkline-revenue").sparkline(sales, {
                        type: 'line',
                        width: '100%',
                        height: '100',
                        lineColor: '#5969ff',
                        fillColor: '',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: "red",
                        maxSpotColor: "green",
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true
                    });

                    $("#sparkline-revenue2").sparkline(expenses, {
                        type: 'line',
                        width: '100%',
                        height: '100',
                        lineColor: '#ff407b',
                        fillColor: '',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: "red",
                        maxSpotColor: "green",
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true
                    });

                    $("#sparkline-revenue4").sparkline(profit, {
                        type: 'line',
                        width: '100%',
                        height: '100',
                        lineColor: '#ffc750',
                        fillColor: '',
                        lineWidth: 2,
                        spotColor: undefined,
                        minSpotColor: undefined,
                        maxSpotColor: undefined,
                        highlightSpotColor: undefined,
                        highlightLineColor: undefined,
                        tooltipFormat: "<div class='tooltipFormat_style'><div class='tooltipFormat_value'><?php echo '{{y:val}}'; ?></div></div>",
                        resize: true,
                    });

                    var ctx = document.getElementById("chartjs_balance_bar").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',

                        data: {
                            labels: period,
                            datasets: [{
                                label: 'Doanh thu',
                                data: sales,
                                backgroundColor: "rgba(89, 105, 255,.8)",
                                borderColor: "rgba(89, 105, 255,1)",
                                borderWidth: 2

                            }, {
                                label: 'Chi phí',
                                data: expenses,
                                backgroundColor: "rgba(255, 64, 123,.8)",
                                borderColor: "rgba(255, 64, 123,1)",
                                borderWidth: 2


                            }]

                        },
                        options: {
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
                } //END success
            });
        } // end of create functuon chart15daysorder
        chart15daysorder();
    </script>
@endsection
