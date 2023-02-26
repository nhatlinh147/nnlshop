@extends('frontend.index')
@if ($index == 0)
    @section('content')
        @include('frontend.shop.search-result')
    @endsection
@endif
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('frontend.index') }}">Trang chủ</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Hiển thị sản phẩm</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Danh
                        sách sản phẩm</span></h5>
                <!-- Category Start -->
                <nav class="navbar navbar-light align-items-start p-0 bg-light mb-30 p-4" style="width: 100%;"
                    id="Category_Filter">
                    <div class="navbar-nav w-100">
                        <style>
                            div.collapse a.nav-link:hover {
                                background: rgba(0, 0, 0, 0.103);
                            }
                        </style>
                        @php
                            $index_parent = 0;
                        @endphp
                        @foreach ($category_parent as $cate)
                            @php
                                $index_parent++;
                            @endphp
                            @if (in_array($cate->id, $array_have_child))
                                <div class="nav-item dropdown dropright my-1">
                                    <a href="#" class="nav-link dropdown-toggle d-flex" data-toggle="collapse"
                                        data-target="#collapse{{ $index_parent }}">
                                        <span style="white-space: normal;flex:auto;">{{ $cate->Category_Name }}</span>
                                        {{-- <i class="fa fa-angle-right mr-3"></i> --}}
                                        <i class="fa fa-plus fa-xs float-right mt-1 ml-3"></i>
                                    </a>

                                    @foreach (App\Model\CategoryModel::where('Category_Parent', $cate->id)->get() as $child)
                                        <div id="collapse{{ $index_parent }}" class="collapse" aria-labelledby="headingOne">
                                            <a href="{{ url()->current() . '?have_child=false&category=' . $child->Category_Product_Slug }}"
                                                class="nav-link" style="text-indent: 10px;">{{ $child->Category_Name }}</a>
                                        </div>
                                    @endforeach

                                </div>
                            @else
                                <div class="nav-item">
                                    <a href="{{ url()->current() . '?have_child=false&category=' . $cate->Category_Product_Slug }}"
                                        class="nav-link">{{ $cate->Category_Name }}</a>
                                </div>
                            @endif
                        @endforeach

                    </div>
                </nav>
                <!-- Category End -->

                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                        giá</span></h5>
                <div class="bg-light p-4 mb-30">
                    @php
                        $min_price = DB::table('tbl_product')->min('Product_Price');
                        $max_price = DB::table('tbl_product')->max('Product_Price');

                        // khai báo mảng giá,màu và kích thước để bắt đầu chuyển đổi sang html
                        $array_price = [$min_price, 10000000, 20000000, 30000000, 40000000, 50000000, 60000000, 70000000, 80000000, $max_price];
                        $colors = ['black', 'white', 'red', 'blue', 'green', 'cyan', 'yellow', 'magenta', 'purple', 'orange', 'pink', 'brown'];
                        $array_size = ['XS', 'S', 'M', 'L', 'XL'];
                    @endphp

                    <form id="Filter_Price">

                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-all"
                                data-min="{{ $min_price }}" data-max="{{ $max_price }}">
                            <label class="custom-control-label" for="price-all">Toàn bộ giá</label>
                        </div>

                        @for ($index = 1; $index <= count($array_price) - 1; $index++)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="price-{{ $index }}"
                                    data-min="{{ $array_price[$index - 1] }}" data-max="{{ $array_price[$index] }}">
                                <label class="custom-control-label" for="price-{{ $index }}">@php
                                    if ($index == 1) {
                                        echo '< ' . $array_price[$index] / 1000000 . ' triệu đ';
                                    } elseif ($index == count($array_price) - 1) {
                                        echo '> ' . $array_price[$index - 1] / 1000000 . ' triệu đ';
                                    } else {
                                        echo $array_price[$index - 1] / 1000000 . ' triệu đ' . ' - ' . $array_price[$index] / 1000000 . ' triệu đ';
                                    }
                                @endphp
                                </label>
                            </div>
                        @endfor
                    </form>
                </div>
                <!-- Price End -->

                <!-- Color Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                        màu</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="Filter_Color">
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-all">
                            <label class="custom-control-label" for="color-all">Toàn bộ màu</label>
                        </div>

                        @foreach ($colors as $color)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="color-{{ $color }}"
                                    data-color="{{ $color }}">
                                <label class="custom-control-label"
                                    for="color-{{ $color }}">{{ ucfirst($color) }}</label>
                            </div>
                        @endforeach

                    </form>

                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                        kích thước</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="Filter_Size">
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-all">
                            <label class="custom-control-label" for="size-all">Toàn bộ kích thước</label>
                        </div>
                        @foreach ($array_size as $size)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="size-{{ $size }}"
                                    data-size="{{ $size }}">
                                <label class="custom-control-label"
                                    for="size-{{ $size }}">{{ $size }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Size End -->

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2" id="Filter_Top">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item active" href="#" data-filter="latest">Gần
                                            nhất</a>
                                        <a class="dropdown-item" href="#" data-filter="sell_well">Bán chạy</a>
                                        <a class="dropdown-item" href="#" data-filter="view">Xem nhiều</a>
                                    </div>
                                </div>

                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Giá</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#" data-filter="price_asc">Giá thấp đến
                                            cao</a>
                                        <a class="dropdown-item" href="#" data-filter="price_desc">Giá cao đến
                                            thấp</a>
                                    </div>
                                </div>

                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item active" href="#" data-paginate="10">10</a>
                                        <a class="dropdown-item" href="#" data-paginate="15">15</a>
                                        <a class="dropdown-item" href="#" data-paginate="20">20</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="Product_Show_Shop" style="display:contents">

                        @include('frontend.shop.show')

                    </div>

                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>

    <!-- Shop Product Start -->
    @include('frontend.shop.modal-view-product')
    <!-- Shop Product End -->

    <!-- Shop End -->
@endsection

@push('scripts')
    <script>
        Array.prototype.diff = function(a) {
            return this.filter(function(i) {
                return a.indexOf(i) < 0;
            });
        };

        var sorBy = (function() {
            return {
                occurrences: function(array_unsort) {
                    const unorderedObj = array_unsort.reduce(function(acc, curr) {
                        acc[curr] ? ++acc[curr] : acc[curr] = 1;
                        return acc;
                    }, {});

                    function swap(json) {
                        var ret = {};
                        for (var key in json) {
                            ret[json[key]] = Number(key);
                        }
                        return ret;
                    }
                    const ordered = swap(unorderedObj);
                    return Object.values(ordered);
                }
            }
        })();

        const filter_checked = (function() {
            var array_favourite = [];
            // Lọc thuộc tính bên trái
            return {
                checked_left(selector, attribute) {
                    let array_push = [];
                    selector.each(function() {
                        if ($(this).prop('checked') == true) {
                            array_push.push($(this).data(attribute));
                        }
                    });
                    return array_push;
                },
                setSelectedLocalstorage(product_id, variable_name) {
                    //Đưa giá trị vào value dưới dạng json
                    let json = {};
                    json[variable_name] = product_id;
                    json['time'] = Date.now();

                    // Đưa giá trị vào localstorage (Vd key: cart_product_id140)
                    localStorage.setItem(variable_name + product_id, JSON.stringify(json));
                },
                getSelectedLocalstorage(key_name) {
                    let array_push = [];
                    for (let i = 0; i < localStorage.length; i++) {
                        let get_value = localStorage.getItem(localStorage.key(i));
                        let get_product_id = localStorage.getItem(key_name + JSON.parse(get_value)[key_name]);
                        if (get_product_id != null) {
                            array_push.push(JSON.parse(get_product_id));
                        }
                    }
                    return array_push;
                },
                getSortByTime(arr_unsort, variable_id) {
                    //Sắp xếp object theo time
                    var sort_by_time = arr_unsort.slice(0);
                    sort_by_time.sort(function(a, b) {
                        return b.time - a.time;
                    });

                    //Lấy mảng giá trị từ object đã sắp xếp trước đó
                    const getArrayProductID = sort_by_time.reduce(function(acc, curr) {
                        acc.push(curr[variable_id]);
                        return acc;
                    }, []);

                    return getArrayProductID;
                }
            }
        })();
    </script>

    @include('frontend.shop.script.check-all')
    @include('frontend.shop.script.price')
    @include('frontend.shop.script.interactive-pagination')

    @if (Auth::guard('customer')->check())
        @include('frontend.shop.script.favourite-cart-auth', [
            'customer_id' => Auth::guard('customer')->user()->Customer_ID,
        ])
    @else
        @include('frontend.shop.script.favourite-cart')
    @endif

    @include('frontend.shop.script.modal-view-product')
@endpush
