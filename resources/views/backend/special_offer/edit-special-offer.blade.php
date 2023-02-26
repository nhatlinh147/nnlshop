@extends('backend.admin-layout')
@section('content')
    <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pagehader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            <h3 class="my-2 section-title">Chỉnh sửa chiến dịch khuyến mãi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <form role="form" action="#" method="get" id="Form_Special_Offer"> --}}
                        <form role="form"
                            action="{{ url('back-end/cap-nhat-chien-dich-khuyen-mai/' . $edit_special->Special_ID) }}"
                            method="post" id="Form_Special_Offer" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="inputText3" class="col-form-label">Tiêu đề chiến dịch khuyến mãi</label>
                                <input type="text" class="form-control" name="special_title" class="special_title"
                                    onkeyup="ChangeToSlug()" id="slug" value="{{ $edit_special->Special_Title }}">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Slug chiến dịch khuyến mãi</label>
                                <input type="text" class="form-control special_slug" name="special_slug"
                                    id="convert_slug" value="{{ $edit_special->Special_Slug }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="special_image" class="form-control special_image"
                                    id="special_image" placeholder="Hình ảnh sản phẩm">

                                <div class="see_special_image py-2">
                                    <img src="{{ url('public/upload/special/' . $edit_special->Special_Image) }}"
                                        height="100" width="100" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                <input type="text" name="special_start" class="form-control" id="special_start"
                                    placeholder="Ngày bắt đầu" value="{{ $edit_special->Special_Start }}">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày kết thúc</label>
                                <input type="text" name="special_end" class="form-control" id="special_end"
                                    placeholder="Ngày kết thúc" value="{{ $edit_special->Special_End }}">
                            </div>

                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                                style="display:flex;justify-content: center">
                                <button class="btn btn-primary" type="submit">Cập nhật chiến dịch</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        @endsection
        @section('script')
            <script src="{{ asset('public/BackEnd/js/jquery.checkbox-shift-selector.js?update=17012022') }}"></script>
            @include('backend.include.transfer-slug')
            <script>
                $('#special_image').on('change', function() {
                    var file = $(this)[0].files[0];

                    var fileReader = new FileReader();
                    fileReader.onload = function() {
                        var str =
                            '<img class="img-thumbnail js-file-image" style="width: 100px; height: 100px">';
                        $('.see_special_image').html(str);

                        var imageSrc = event.target.result;

                        $('.js-file-image').attr('src', imageSrc);
                    };
                    fileReader.readAsDataURL(file);
                });
            </script>
        @endsection
