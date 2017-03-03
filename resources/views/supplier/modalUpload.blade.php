<div class="modal fade" tabindex="-1" role="dialog" id="modalUpload">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Upload Image</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmFile','files' => true]) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Type Document:</label>
                            <select class="form-control" id="document_id" name="document_id">
                                <option value="0">Seleccione</option>
                                <option value="1">Cedula</option>
                                <option value="2">Nit</option>
                            </select>

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <input id="input-700" name="kartik-input-700[]" type="file" multiple class="file-loading">
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->