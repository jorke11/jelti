<div class="modal fade" role="dialog" id='modalUpload'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agregar Detalle</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmUpload','file'=>true]) !!}
                <input type="hidden" id="client_id" name="client_id">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">File:  <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span><a href="{{ URL::to( '/assets/formats/upload.xlsx')  }}" target="_blank">Descargar formato</a></label>
                            <input type="file" name="file_excel" id="file_excel" class="form-control">
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-success" id='uploadRequest'>upload</button>
            </div>
        </div>
    </div>
</div>