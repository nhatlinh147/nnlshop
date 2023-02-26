<script>
    // lưu ý nếu giảm số cột thì đồng thời giảm colspan (số lượng hàng gộp) nếu để chênh lệch thì không xuất hiện data
    $(document).ready(function() {
        function format_number(number) {
            return number.toFixed().replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' đ'
        }
        var data_product_table = $('table.second').DataTable({
            select: true,
            lengthChange: true,
            footer: true,
            language: {
                "emptyTable": "Không có dữ liệu sản phẩm"
            },
            ajax: {
                "type": "GET",
                "url": "{{ route('backend.all_product_data_table') }}",
            },
            columns: [{
                    "title": "Id sản phẩm",
                    "data": "Product_ID",
                    "visible": false,
                    "searchable": false
                },
                {
                    "title": `
                    <label class="custom-control custom-checkbox">
                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                        <span class="custom-control-label"></span>
                    </label>`,
                    "data": "Product_ID",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<label class="custom-control custom-checkbox">
                                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_` +
                            data + `" data-product_id ="` + data + `" >
                                        <span class="custom-control-label"></span>
                                    </label>`;
                    }
                },
                {
                    "title": "Thứ tự",
                    "data": null,
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Đường dẫn Google Drive",
                    "data": "Product_Path",
                    "visible": false,
                    "searchable": false
                },
                {
                    "title": "Tên sản phẩm",
                    "data": "Product_Name",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Giá bán",
                    "data": "Product_Price",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return format_number(data);
                    }
                },
                {
                    "title": "Giá gốc",
                    "data": "Product_Cost",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return format_number(data);
                    }
                },
                {
                    "title": "Thư viện ảnh",
                    "data": "Product_Slug",
                    "name": "Product_Slug",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<a href="{{ url('back-end/liet-ke-anh-san-pham') }}/${row['Product_Slug']}"><span class='fa fa-lg fa-plus-circle'></span></a>`;
                    }
                },
                {
                    "title": "Hình ảnh sản phẩm",
                    "data": "Product_Image",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<img src="{{ url('public/upload/product/`+data+`') }}" height="100" width="100"/>`
                    }
                },
                {
                    "title": "Tài liệu",
                    "data": "Product_Document",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        function getFileExtension(filename) {
                            return filename.split('.').pop();
                        }
                        var getExtension = getFileExtension(data);
                        var getString = '';

                        if (data != 'Không') {
                            if (getExtension == 'pdf') {
                                getString +=
                                    `<a href="{{ asset('/public/upload/document/`+data+`') }}" class="get_document">Xem file</a>`;
                            } else if (getExtension == 'doc' || 'docx') {
                                getString +=
                                    `<a data-product_path = "${row['Product_Path']}" target="_blank" class="read_by_ggdrive" href="https://drive.google.com/file/d/${row['Product_Path']}/view">Xem file</a>`;
                            }
                        } else {
                            getString += `<span>Không</span>`;
                        }

                        return getString;
                    }
                },
                {
                    "title": "Danh mục",
                    "data": "Category_Name",
                    "name": "Category_Name",
                    "visible": true,
                    "searchable": true
                },
                {
                    "title": "Ẩn/hiển thị",
                    "data": "Product_Status",
                    "name": "Product_Slug",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        if (data == 1) {
                            var value = 'checked';
                        } else {
                            var value = ''
                        }
                        return `<div class="switch-button switch-button-success">
                                                        <input type="checkbox" ` + value + ` name="switch` + row[
                                'Product_ID'] + `" id="switch` + row['Product_ID'] +
                            `" data-id="` + row['Product_ID'] + `" class="update_status"><span>
                                                    <label for="switch` + row['Product_ID'] + `"></label></span>`
                    }
                },
                {
                    "title": "Sửa/xóa",
                    "data": "Product_ID",
                    "name": "Product_Slug",
                    "visible": true,
                    "searchable": true,
                    render: function(data, type, row) {
                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-product" data-id="` +
                            data +
                            `">Sửa</a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-xs delete_product" data-id="` +
                            data + `">Xóa</a>`
                    }
                },
            ],
            columnDefs: [{
                    sortable: false,
                    targets: 1 //colIdx
                },
                {
                    sortable: false,
                    "class": "index",
                    targets: 2 //colIdx
                }
            ]
            // ,order: [
            //     [2, 'asc'] // [ colIdx, orderingDirection ]
            // ]
            // ,fixedColumns: true

        }); // END Datatable
        data_product_table.on('order.dt search.dt', function() {
            data_product_table.column(2, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
