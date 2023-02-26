<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php
        $name = 0;
        $title = 0;
        $slug = 0;
    @endphp
    @if(!empty($array_one))
    @foreach ($array_one as $key => $value )
        @foreach ($value["suffix"] as $key2 => $item )
                @if ($key2 == 'path')
                    {"title": "Đường dẫn Google Drive", "data": "{{ucfirst($value['prefix_v'])}}_Path", "visible": false, "searchable": false},
                @elseif ($key2 == 'title')
                    {"title": "{{ucfirst($key2)}} {{$value['prefix_c']}}", "data": "{{ucfirst($value['prefix_v'])}}_{{ucfirst($key2)}}","visible": true, "searchable": true},
                @endif

        @endforeach
    @endforeach
    @endif
</body>
</html>


<script>
    $(document).ready(function() {
        function format_number (number) {
            return number.toFixed().replace('.', ',') .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.') + ' đ'
        }
        @if(!empty($array_one))
        @foreach ($array_one as $key => $value )
        var data_product_table = $('table.second').DataTable({
            lengthChange: true,
            footer: true,
            language: {
                "emptyTable": "Không có dữ liệu {{$value['prefix_c']}}"
            },
            ajax: {
                "type": "GET",
                "url": "{{ route('backend.list_'.$value['prefix_v'].'_json') }}",
                },
            columns: [
            @foreach ($value["suffix"] as $key2 => $item )
                    @if ($key2 == 'id')
                    {"title": `
                        <label class="custom-control custom-checkbox">
                            <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                            <span class="custom-control-label"></span>
                        </label>`,
                        "data": "{{ucfirst($value['prefix_v'])}}_ID", "visible": true, "searchable": true,
                            render: function (data,type,row){

                                return `<label class="custom-control custom-checkbox">
                                            <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_`+data+`" data-{{$value['prefix_v']}}_id ="`+data+`" >
                                            <span class="custom-control-label"></span>
                                        </label>`;
                            }
                    },
                    @endif
                    @if($key2 == 'id' || $key2 == 'edit_delete' || $key2 == 'gallery'||$key2 == 'slug')

                    {"title": "<?php if($key2 == 'id'){echo 'ID'.' '.$value['prefix_c'];} else if($key2 == 'gallery'){echo 'Thư viện ảnh';}else{echo ucfirst($item);}?>",

                    "data":
                            @if ($key2 == 'edit_delete'||$key2 == 'gallery')
                                "{{ucfirst($value['prefix_v'])}}_ID", "visible": true, "searchable": true,
                                render: function (data,type,row){
                                    @if ($key2 == 'edit_delete')
                                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-product" data-id="`+data+`">Sửa</a>
                                                <a href="javascript:void(0)" class="btn btn-danger btn-xs delete_product" data-id="`+data+`">Xóa</a>`
                                    @else
                                        return `<a href="{{url('back-end/liet-ke-anh-san-pham')}}/${row["{{ucfirst($value['prefix_v']).'_Slug'}}"]}"><span class='fa fa-lg fa-plus-circle'></span></a>`;
                                    @endif
                                }
                            @elseif($key2 == 'slug')
                                "{{ucfirst($value['prefix_v'])}}_Slug", "visible": false, "searchable": false
                            @else
                                "{{ucfirst($value['prefix_v'])}}_ID", "visible": false, "searchable": false
                            @endif
                    },

                    @else
                    {"title": "{{ucfirst($item).' '.$value['prefix_c']}}{{$key2 == 'sold'? ' đã bán' :''}}", "data": "{{ucfirst($value['prefix_v']).'_'.ucfirst($key2)}}","visible": true, "searchable": true,

                        @if ($key2 == 'price'|| $key2 == 'cost'||$key2 == 'image'|| $key2 == 'document'||$key2 == 'status')

                            render: function (data,type,row){
                                @if ($key2 == 'price'|| $key2 == 'cost')
                                    return format_number(data);
                                @elseif ($key2 == 'image')
                                    return`<img src="{{url('public/upload/'.$value['prefix_v'].'/`+data+`')}}" height="100" width="100"/>`
                                @elseif ($key2 == 'document')
                                    function getFileExtension(filename) {
                                        return filename.split('.').pop();
                                    }
                                    var getExtension = getFileExtension(data);
                                    var getString = '';

                                    if(data != 'Không'){
                                        if(getExtension == 'pdf'){
                                            getString += `<a href="{{asset('/public/upload/document/`+data+`')}}" class="get_document">Xem file</a>`;
                                        }else if(getExtension== 'doc'|| 'docx'){
                                            getString += `<a data-{{$value['prefix_v']}}_path = "${row['{{ucfirst($value['prefix_v'])}}_Path']}" target="_blank" class="read_by_ggdrive" href="https://drive.google.com/file/d/${row['{{ucfirst($value['prefix_v'])}}_Path']}/view">Xem file</a>`;
                                        }
                                    }else{
                                        getString += `<span>Không</span>`;
                                    }

                                    return getString;
                                @elseif ($key2 == 'status')
                                    if(data == 1){
                                        var value = 'checked';
                                    }else{
                                        var value = ''
                                    }
                                    return `<div class="switch-button switch-button-success">
                                                <input type="checkbox" `+value+` name="switch`+row['{{ucfirst($value['prefix_v'])}}_ID']+`" id="switch`+row['{{ucfirst($value['prefix_v'])}}_ID']+`" data-id="`+row['{{ucfirst($value['prefix_v'])}}_ID']+`" class="update_status"><span>
                                            <label for="switch`+row['{{ucfirst($value['prefix_v'])}}_ID']+`"></label></span>`
                                @elseif ($key2 == 'statu')
                                @endif

                            }

                        @endif
                    @endif
                    },

            @endforeach
            ],
            columnDefs: [ {
                sortable: false,
                "class": "index",
                targets: 0
            } ],
            order: [[ 1, 'asc' ]],
            fixedColumns: true

            });// END Datatable
            data_product_table.on( 'order.dt search.dt', function () {
                data_product_table.column(2, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
                } );
            }).draw();
        });
        @endforeach
        @endif
</script>
