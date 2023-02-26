<div class="modal fade" id="import_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-small">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Đính kèm tệp excel (.xlxs)</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('backend.import_excel_product') }}" method="POST" enctype="multipart/form-data"
                    id="Form_Import">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="product_excel" class="form-control product_excel" id="product_excel"
                            placeholder="Thêm tệp excel">
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"
                        style="display:flex;justify-content: center">
                        <input type="submit" value="Import file Excel" name="import_csv" class="btn btn-primary">
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
