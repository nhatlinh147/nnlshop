<form id="edit_prop_form" name="edit_prop_form" method="post">
    @csrf
    <input type="hidden" name="edit_prop_id" class="edit_prop_id" value="">
    <div class="form-group">
        <div class="error">
        </div>
    </div>
    <div class="form-group">
        <label for="edit_prop_tagsInput" class="col-form-label font-weight-bold">Tags:
        </label>
        <span class="textListProduct form-control"></span>
    </div>

    <div class="form-group">
        <label for="prop_size" class="col-form-label font-weight-bold">Chọn kích thước:
        </label>
        <div class="text-center">

            @foreach ($array_one as $size)
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="edit_prop_size {{ $size }} custom-control-input"
                        data-chkbox-shiftsel="checkbox" name="edit_prop_size[]" value="{{ $size }}">
                    <span class="custom-control-label">{{ $size }}</span>
                </label>
            @endforeach

        </div>

    </div>

    <div class="form-group">
        <label for="prop_color" class="col-form-label font-weight-bold">Chọn màu sắc:
        </label>
        <div class="text-center">
            @foreach ($color as $val)
                <label class="custom-control custom-checkbox custom-control-inline m-2">
                    <input type="checkbox" class="edit_prop_color {{ $val }} custom-control-input"
                        data-chkbox-shiftsel="checkbox" name="edit_prop_color[]" value="{{ $val }}">
                    <span class="color custom-control-label"></span>
                </label>
            @endforeach

        </div>
    </div>
    <div class="form-group">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4" style="display:flex;justify-content: center">
            <button class="btn btn-primary" type="submit" id="update_prop_product">Cập nhật thuộc tính</button>
        </div>
    </div>
</form>
