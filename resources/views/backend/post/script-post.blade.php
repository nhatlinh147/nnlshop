@include('backend.include.transfer-slug')
<script>
      $("a[data-target='#submenu-3']").addClass('active');
</script>
<script>
    $(document).ready(function() {
        var data_cate_pro = $('table.second').DataTable({
            lengthChange: true,
            ajax: {
                "type": "POST",
                "headers":{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "url": "{{ route('backend.list_post_json') }}",
                },
            columns: [
                {"title": `
                    <label class="custom-control custom-checkbox">
                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input title_checkbox">
                        <span class="custom-control-label"></span>
                    </label>`,
                    "data": "Post_ID", "visible": true, "searchable": true,
                        render: function (data,type,row){

                            return `<label class="custom-control custom-checkbox">
                                        <input id="ck1" name="ck1" type="checkbox" class="custom-control-input checkbox_`+data+`" data-cate_pro_id ="`+data+`" >
                                        <span class="custom-control-label"></span>
                                    </label>`;
                        }
                },
                {"title": "Id bài viết", "data": "Post_ID", "visible": false, "searchable": false},
                {"title": "Thứ tự", "data": null, "visible": true, "searchable": true},
                {"title": "Tiêu đề bài viết", "data": "Post_Title","visible": true, "searchable": true},
                {"title": "Slug bài viết", "data": "Post_Slug","visible": true, "searchable": true},
                {"title": "Từ khóa tìm kiếm", "data": "Meta_Keywords_Post","visible": true, "searchable": true},
                {"title": "Số lượng view", "data": "Post_Views","visible": true, "searchable": true},
                {"title": "Hình ảnh bài viết", "data": "Post_Image", "visible": true, "searchable": true,
                    render: function (data,type,row){
                        return`<img src="{{url('public/upload/post/`+data+`')}}" height="100" width="100"/>`
                    }
                },
                {"title": "Thuộc danh mục bài viết", "data": 'Cate_Post_ID', "visible": true, "searchable": true,
                    render: function (data,type,row){

                        @foreach($category_post as $key => $cate_pro)
                        if(data == {{$cate_pro->Cate_Post_ID}}){
                            var value = `<span style="color:green;">{{$cate_pro->Cate_Post_Name}}</span>`;
                        }
                        @endforeach

                        return value;
                    }
                },
                {"title": "Ẩn/hiển thị", "data": "Post_Status", "visible": true, "searchable": true,
                    render: function (data,type,row){
                        if(data == 1){
                            var value = 'checked';
                        }else{
                            var value = ''
                        }
                        return `<div class="switch-button switch-button-success">
                                <input type="checkbox" `+value+` name="switch`+row['Post_ID']+`" id="switch`+row['Post_ID']+`" data-id="`+row['Post_ID']+`" class="update_status"><span>
                            <label for="switch`+row['Post_ID']+`"></label></span>`;
                    }
                },
                {"title": "Ngày thêm", "data": "created_at","visible": true, "searchable": true,
                    render: function (data,type,row){
                        return new Date(data).toLocaleDateString("en-IN");
                    }
                },
                {"title": "Sửa/xóa", "data": "Post_ID", "visible": true, "searchable": true,
                    render: function (data,type,row){
                        return `<a href="javascript:void(0)" class="btn btn-success btn-xs edit-post" data-id="`+data+`">Sửa</a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-xs delete-post" data-id="`+data+`">Xóa</a>`
                    }
                },
            ],
            columnDefs: [ {
                sortable: false,
                "class": "index",
                targets: 0
            } ],
            order: [[ 1, 'asc' ]],
            fixedColumns: true
            });// END Datatable
            data_cate_pro.on( 'order.dt search.dt', function () {
                data_cate_pro.column(2, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
                } );
            }).draw();
        });
</script>
<script>
    $.fn.clearValidation = function(){
        var v = $(this).validate();
        $('[name]',this).each(
            function(){
                v.successList.push(this);
                v.showErrors();
            });
            v.resetForm();
            v.reset();
        };

var SITEURL = '{{url('/back-end')}}';
$(document).ready( function () {
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('#create-post').click(function () {
    //Xóa đi toàn bộ dữ liệu validate (trước đó)
    //Thiết lập validate cho post_image (vì clearValidation không thể xóa đi validation image trước đó)
    $("#postForm").clearValidation();
    $(".post_image").rules('add', 'required accept');

    $('.see_post_image').empty();

    //Hidden
    $('#post_id').val('');
    $('#Image_Post_Hidden').val('');

    $('#postForm').trigger("reset");
    CKEDITOR.instances['Ckeditor_Desc'].setData('');
    CKEDITOR.instances['Ckeditor_Content'].setData('');
    CKEDITOR.instances['Ckeditor_Desc_Meta'].setData('');
    $('#btn-save').val("Thêm bài viết");
    $('#Title_Post').html("Thêm bài viết mới");
    $('#ajax-post-modal').modal('show');
});

$('body').on('click', '.edit-post', function () {
    var cate_pro_id = $(this).data('id');
    $("#postForm").clearValidation();
    $(".post_image").rules('remove');

    $.get('sua-bai-viet/' + cate_pro_id, function (data) {
        $('#Image_Post_Hidden').val(data.Post_Image);
        $('#post_id').val(data.Post_ID);

        $('#Title_Post').html("Sửa slide sản phẩm");

        $('#btn-save').val("Lưu slide");
        $('#ajax-post-modal').modal('show');
        $('.post_title').val(data.Post_Title);
        $('.post_slug').val(data.Post_Slug);
        CKEDITOR.instances['Ckeditor_Desc'].setData(data.Post_Desc);
        CKEDITOR.instances['Ckeditor_Content'].setData(data.Post_Content);
        $('.meta_keywords_post').val(data.Meta_Keywords_Post);
        CKEDITOR.instances['Ckeditor_Desc_Meta'].setData(data.Meta_Desc_Post);
        $('.see_post_image').html(`<img src="{{url('public/upload/post/${data.Post_Image}')}}" height="100" width="100" style="margin-top:6px"/>`);
        $('.post_status option[value="'+data.Post_Status+'"]').attr('selected','selected');
        $('.cate_post_id option[value="'+data.Cate_Post_ID+'"]').attr('selected','selected');
    });
});

$('body').on('click', '.delete-post', function () {

var post_id = $(this).data("id");
    if(confirm("Bạn có chắc muốn xóa bài viết này không ?")){
        $.ajax({
            type: "get",
            url: SITEURL + "/xoa-bai-viet/" + post_id,
            success: function (data) {
                var oTable = $('table.second').DataTable();
                oTable.ajax.reload(null,false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    }

});

}); // END document ready
if ($("#postForm").length > 0) {
    $("#postForm").validate({
    ignore: [],
    rules: {
        // simple rule, converted to {required:true}
        post_title: {
            required: true
        },
        post_slug: {
            required: true
        },
        post_image:{
            required: true,
            accept: "image/*"
        },
        // compound rule
        post_desc: {
            required: function(textarea) {
                CKEDITOR.instances[textarea.id].updateElement();
                var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                return editorcontent.length === 0;
            }
        },
        post_content: {
            required: function(textarea) {
                CKEDITOR.instances[textarea.id].updateElement();
                var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                return editorcontent.length === 0;
            }
        },
        meta_desc_post: {
            required: function(textarea) {
                CKEDITOR.instances[textarea.id].updateElement();
                var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                return editorcontent.length === 0;
            }
        },
        meta_keywords_post: {
            required: true,
        },
        cate_post_id: {
            valueNotEquals: ""// so sánh giá trị trong select-option
        },

    },
    messages: {
        // simple rule, converted to {required:true}
        post_title: {
            required: "Tiêu đề bài viết không được để trống"
        },
        post_slug: {
            required: "Slug bài viết không được để trống"
        },
        post_image:{
            required: "Hình ảnh bài viết không được để trống",
            accept: "File nhập vào phải là file hình ảnh"
        },
        post_desc: {
            required: "Mô tả bài viết không được để trống"
        },
        post_content: {
            required: "Nội dung bài viết không được để trống"
        },
        post_meta_desc: {
            required: "Mô tả tìm kiếm bài viết không được để trống"
        },
        meta_keywords_post: {
            required: "Từ khóa tìm kiếm bài viết không được để trống"
        },
        cate_post_id: {
            valueNotEquals: "Cần lựa chọn danh mục bài viết"// so sánh giá trị trong select-option
        },
    },
    submitHandler: function(form) {
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');
        var get_image = $('#Image_Post_Hidden').val();
        var data = new FormData($("#postForm")[0]);
        data.append ('get_image', get_image);
        $.ajax({
            data: data,
            url: SITEURL + "/luu-bai-viet",
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (data) {
                $('#postForm').trigger("reset");
                $('#ajax-post-modal').modal('hide');
                $('#btn-save').html('Lưu slide');
                var oTable = $('#example').DataTable();
                oTable.ajax.reload(null,false);
                if(data.Post_Title){
                    if(get_image == ''){
                        $('#message_post').after("<div class='alert alert-info message_"+data.Post_ID+"'>Tạo bài viết: <i class='compareCondition'>"+data.Post_Title+ "</i> thành công</div>");
                        setTimeout(function(){
                            $('.message_'+data.Post_ID).fadeOut().remove();
                        }, 10000);
                    }else{
                        $('#message_post').after("<div class='alert alert-info message_"+data.Post_ID+"'>Lưu bài viết: <i class='compareCondition'>"+data.Post_Title+ "</i> thành công</div>");
                        setTimeout(function(){
                            $('.message_'+data.Post_ID).fadeOut().remove();
                        }, 10000);
                    }

                }
            }, // END success
            error: function (data) {
                console.log('Error:', data);
                $('#btn-save').html('Save Changes');
            } // END error
        }); // END ajax
    } // END submitHandler
    })
}
</script>
<script>
    $(document).on('click','.title_checkbox',function(){
        var check = $(this).prop('checked') == true ? 1 : 0;
        cate_pro_id = [];
        $('input[class*="checkbox_"]').each(function(){
            cate_pro_id.push($(this).data('cate_pro_id'));
        });
        if(check == 1){
            for(i=0;i<cate_pro_id.length;i++){
                $('.checkbox_'+cate_pro_id[i]).prop('checked',true);
            }
        }else{
            for(i=0;i<cate_pro_id.length;i++){
                $('.checkbox_'+cate_pro_id[i]).prop('checked',false);
            }
        }

        if(check == 1 &&  $('input[class*="checkbox_"]').prop('checked')){
            $('.add-button-delete').html('<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-post-selected">Xóa</a>');
            $('label.custom-control.custom-checkbox').css({'display':'inline-block'});
            $('td.index,th.index').css({'text-align': 'center'});
        }else{
            $('.add-button-delete').empty();
        }


    });//End click .delete_slide
    $(document).on('click','input[class*="checkbox_"]',function(){
        var check = $(this).prop('checked') == true ? 1 : 0;
        cate_pro_id = [];
        $('input[class*="checkbox_"]').each(function(){
            cate_pro_id.push($(this).data('cate_pro_id'));
        });
        if(check == 0){
            $('.title_checkbox').prop('checked',false);
        }
        for(i=0;i<cate_pro_id.length;i++){
            if($('.checkbox_'+cate_pro_id[i]).is(':checked') ){
                $('.add-button-delete').html('<a href="javascript:void(0)" class="btn btn-outline-danger btn-xs delete-post-selected">Xóa</a>');
                $('label.custom-control.custom-checkbox').css({'display':'inline-block'});
                $('td.index,th.index').css({'text-align': 'center'});
                break;
            }else{
                $('.add-button-delete').empty();
            }
        }

    });
    $(document).on('click','.delete-post-selected',function(){
        var ids = [];

        $('input[class*="checkbox_"]').each(function () {
            if ($(this).is(":checked")) {
                ids.push($(this).data('cate_pro_id'));
            }
        });
        var count_id = ids.length;
        $.ajax({
            url:'{{route('backend.delete_post_selected')}}',
            type:'get',
            dataType: 'json',
            data:{
                ids: ids
            },
            success:function(data){
                if(data == count_id){
                    $('.add-button-delete').empty();
                    $('.title_checkbox').prop('checked',false);
                }
                var oTable = $('table.second').DataTable();
                    oTable.ajax.reload(null,false);

            }//End Success
        });//End Ajax
    });
</script>
<script>
     $(document).ready(function(){
        $('.post_image').on('change', function() {
            var file = $(this)[0].files[0];

            var fileReader = new FileReader();
            fileReader.onload = function() {
                var str = '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                $('.see_post_image').html(str);

                var imageSrc = event.target.result;

                $('.js-file-image').attr('src', imageSrc);
            };
            fileReader.readAsDataURL(file);
        });
    });
        $(document).on('click','.update_status',function(){
        var status = $(this).prop('checked') == true ? 1 : 0;
        var cate_pro_id =$(this).data('id');
        $.ajax({
            type:'get',
            dataType:'json',
            url:'{{route('backend.post_status')}}',
            data:{'status':status, 'post_id': post_id},
            success:function(data){
                console.log('Success Update Slide Status');
            }
        });
    });
</script>
