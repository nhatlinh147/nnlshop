@extends('backend.admin-layout')
@section('link')
    <!-- Css dataTables -->
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/dataTables.bootstrap4.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/bootstrap-tagsinput.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('public/BackEnd/css/amsify.suggestags.css') }}" type="text/css" />
    @include('backend.shared.spinner.spinner')
@endsection
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="section-block">
                    <h3 class="my-2 section-title">Thuộc tính sản phẩm</h3>
                </div>
                <div class="accrodion-regular">
                    <div id="accordion">
                        <div class="card">

                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed font-weight-bold" data-toggle="collapse"
                                        data-target="#collapseAddPropProduct" aria-expanded="false"
                                        aria-controls="collapseAddPropProduct">
                                        Thêm thuộc tính cho sản phẩm
                                    </button>
                                </h5>
                            </div>

                            <div id="collapseAddPropProduct" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordion" style="">
                                <div class="card-body">
                                    <div id="message">
                                        <?php
                                        $message = Session::get('message');
                                        if ($message) {
                                            echo '<div class="alert alert-success">' . $message . '</div>';
                                            Session::put('message', null);
                                        }
                                        ?>
                                    </div>

                                    <form id="Form_Prop_Product">
                                        @csrf
                                        <div class="form-group">
                                            <label for="prop_tagsInput" class="col-form-label font-weight-bold">Tags:
                                            </label>
                                            <input id="prop_tagsInput" name="prop_tagsInput"
                                                class="form-control prop_tagsInput">
                                        </div>

                                        <div class="form-group">

                                            @php
                                                $array_one = ['XS', 'S', 'M', 'L', '2XL', '3XL', '4XL', '5XL'];
                                                $i = 0;
                                                $amount = 0;
                                                for ($amount = 28; $amount < 47; $amount++) {
                                                    array_push($array_one, $amount);
                                                }
                                            @endphp
                                            <label for="prop_size" class="col-form-label font-weight-bold">Chọn kích thước:
                                            </label>
                                            <div class="text-center">

                                                @foreach ($array_one as $size)
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input prop_size"
                                                            data-chkbox-shiftsel="checkbox" name="prop_size[]"
                                                            value="{{ $size }}">
                                                        <span class="custom-control-label">{{ $size }}</span>
                                                    </label>
                                                @endforeach

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <style>
                                                span.custom-control-label.color::after {
                                                    width: 2rem !important;
                                                    height: 2rem !important;
                                                }

                                                span.custom-control-label.color::before {
                                                    width: 2rem !important;
                                                    height: 2rem !important;
                                                }
                                            </style>
                                            @php
                                                $color = ['blue', 'cyan', 'green', 'yellow', 'red', 'magenta', 'purple', 'orange', 'black', 'white', 'pink', 'brown'];
                                            @endphp
                                            <label for="prop_color" class="col-form-label font-weight-bold">Chọn màu sắc:
                                            </label>
                                            <div class="text-center">
                                                @foreach ($color as $val)
                                                    @include('backend.prop.color')
                                                    <label class="custom-control custom-checkbox custom-control-inline m-2">
                                                        <input type="checkbox"
                                                            class="{{ $val }} custom-control-input prop_color"
                                                            data-chkbox-shiftsel="checkbox" name="prop_color[]"
                                                            value="{{ $val }}">
                                                        <span class="color custom-control-label"></span>
                                                    </label>
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4"
                                                style="display:flex;justify-content: center">
                                                <button class="btn btn-primary" type="submit" id="create_prop_product">Tạo
                                                    thuộc tính</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingTwo">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed font-weight-bold" data-toggle="collapse"
                                        data-target="#collapseAllPropProduct" aria-expanded="false"
                                        aria-controls="collapseAllPropProduct">
                                        Toàn bộ thuộc tính sản phẩm
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseAllPropProduct" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="list_prop_product" class="table table-striped table-bordered second"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="5%">Thứ tự</th>
                                                    <th scope="col" width="50%">Sản phẩm</th>
                                                    <th scope="col" width="10%">Kích thước</th>
                                                    <th scope="col" width="25%">Màu sắc</th>
                                                    <th scope="col" width="10%">Chi tiết</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>

                                            <tfoot>
                                                {{-- @inject('count_page', 'App\Repository\CountPageRepository') --}}
                                                @php
                                                    define('LIMIT_PAGE', 3);
                                                @endphp
                                                <tr>
                                                    <td colspan="5">
                                                        <div id="pagination" data-limit_page="{{ LIMIT_PAGE }}"
                                                            class="d-flex justify-content-end">
                                                        </div>
                                                    </td>
                                                </tr>


                                            </tfoot>

                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="edit_prop_modal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-small">
                                    <div class="modal-content">
                                        <div class="modal-header justify-content-center">
                                            <h3 class="modal-title text-uppercase font-weight-bold">Sửa đổi thuộc tính</h3>
                                        </div>
                                        <div class="modal-body">
                                            @include('backend.prop.edit-prop')
                                        </div>
                                        <div class="modal-footer">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('public/BackEnd/js/jquery.checkbox-shift-selector.js?update=17012022') }}"></script>

    <script src="{{ asset('public/BackEnd/js/jquery.amsify.suggestags.js') }}"></script>
    <script src="{{ asset('public/BackEnd/js/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        // GLOGBAL
        const _token = $('input[name="_token"]').val();
        const active_item = () => Number($('li.page-item.active').text());

        let pages = document.getElementById('pagination').getAttribute('data-count_page');

        document.getElementById('pagination').innerHTML = createPagination(Number(pages),
            1);

        function createPagination(pages, page) {
            let str =
                '<nav aria-label="Page navigation" id="navigation_prop"><ul class="pagination">';
            let active;
            let pageCutLow = page - 1;
            let pageCutHigh = page + 1;
            // Show the Previous button only if you are on a page other than the first
            if (page > 1) {
                str +=
                    `<li class="page-item previous no">
                            <a class="page-link" href="javascript:void(0)" aria-label="Previous" onclick="createPagination(pages, ${page - 1})" data-paginate="${ page - 1}">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>`;
            }

            // Show all the pagination elements if there are less than 6 pages total
            if (pages < 6) {
                for (let p = 1; p <= pages; p++) {
                    active = page == p ? "active" : "no";
                    str += `<li class="page-item ${active}">
                                    <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages, ${p})" data-paginate="${p}">${p}</a>
                                </li>`;
                }
            }
            // Use "..." to collapse pages outside of a certain range
            else {
                // Show the very first page followed by a "..." at the beginning of the
                // pagination section (after the Previous button)
                if (page > 2) {
                    str += `<li class="no page-item">
                                    <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages, 1)" data-paginate="1">1</a>
                                </li>`;
                    if (page > 3) {
                        str += `<li class="page-item out-of-range">
                                        <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages,${page - 2})" data-paginate="${page - 2}">...</a>
                                    </li>`;
                    }
                }
                // Determine how many pages to show after the current page index
                if (page === 1) {
                    pageCutHigh += 2;
                } else if (page === 2) {
                    pageCutHigh += 1;
                }
                // Determine how many pages to show before the current page index
                if (page === pages) {
                    pageCutLow -= 2;
                } else if (page === pages - 1) {
                    pageCutLow -= 1;
                }
                // Output the indexes for pages that fall inside the range of pageCutLow
                // and pageCutHigh
                for (let p = pageCutLow; p <= pageCutHigh; p++) {
                    if (p === 0) {
                        p += 1;
                    }
                    if (p > pages) {
                        continue
                    }
                    active = page == p ? "active" : "no";

                    str += `<li class="page-item ${active}">
                                    <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages, ${p})" data-paginate="${p}">${p}</a>
                                </li>`;
                }
                // Show the very last page preceded by a "..." at the end of the pagination
                // section (before the Next button)
                if (page < pages - 1) {
                    if (page < pages - 2) {
                        str += `<li class="page-item ${active} out-of-range">
                                        <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages, ${page + 2})" data-paginate="${page + 2}">...</a>
                                    </li>`;
                    }
                    str += `<li class="page-item no">
                                    <a class="page-link" href="javascript:void(0)" onclick="createPagination(pages, pages)" data-paginate="${pages}">${pages}</a>
                                </li>`;
                }
            }
            // Show the Next button only if you are on a page other than the last
            if (page < pages) {
                str += `<li class="page-item next no">
                                <a class="page-link" href="javascript:void(0)" aria-label="Next" onclick="createPagination(pages, ${ page + 1})" data-paginate="${ page + 1}">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>`;
            }
            str += '</ul></nav>';
            // Return the pagination string to be outputted in the pug templates
            document.getElementById('pagination').innerHTML = str;
            return str;
        }

        function load_prop_product(active_page) {
            var limit_page = $('div#pagination').data('limit_page');
            $.ajax({
                url: '{{ route('backend.list_prop') }}',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: _token,
                    limit_page: limit_page,
                    active_page: active_page
                },
                beforeSend: function() {
                    $('table#list_prop_product tbody').addClass('refresh_table');
                    $('table#list_prop_product tbody').html(`
                    <tr>
                        <td colspan="5">
                            <div id="Loading" class="d-flex justify-content-center">
                                Loading
                            </div>
                        </td>
                    </tr>`);
                },
                success: function(data) {
                    $('table#list_prop_product tbody').removeClass('refresh_table');
                    $('table#list_prop_product tbody').html(data['output']);
                    createPagination(data['count_page'], active_page);
                } //End Success

            }); //End Ajax
        }

        function autocomplete_list_product() {
            //AUTOCOMPLETE tagsinput bootstrap
            $.ajax({
                url: '{{ route('backend.products_selected_prop') }}',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: _token
                },
                success: function(data) {
                    var array_tag_value = [];
                    for (let index = 0; index < data['tag'].length; index++) {
                        array_tag_value.push({
                            tag: data['tag'][index],
                            value: data['value'][index]
                        });
                    }

                    // const randomColor = Math.floor(Math.random() * 16777215).toString(16);
                    var getArrayColor = [];
                    for (let index = 0; index < array_tag_value.length; index++) {
                        getArrayColor.push("hsl(" + Math.floor(Math.random() * 360) + ", 100%, 40%)");
                    }

                    $('#prop_tagsInput').amsifySuggestags({
                        suggestions: array_tag_value,
                        backgrounds: getArrayColor,
                        whiteList: true,
                        afterAdd: function(value) {
                            $('div.amsify-suggestags-input-area span.amsify-select-tag')
                                .css('color', 'white');
                        }
                    });
                    // amsifySuggestags.refresh();
                } //End Success

            }); //End Ajax
        }
    </script>
    <script>
        $(document).ready(function() {

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            //Chạy dữ liệu ban đầu
            load_prop_product(1);
            autocomplete_list_product();
        });
    </script>
    {{-- Script sửa thuộc tính sản phẩm --}}
    @include('backend.prop.script.scirpt-edit-prop')

    {{-- Script write about submit[Tạo thuộc tính] and validate it --}}
    @include('backend.prop.script.scirpt-submit&validate-create')

    {{-- Script tạo tương tác với phân trang --}}
    @include('backend.prop.script.scirpt-paginate-prop')

    {{-- Xóa thuộc tính sản phẩm --}}
    @include('backend.prop.script.scirpt-delete-prop')
@endsection
