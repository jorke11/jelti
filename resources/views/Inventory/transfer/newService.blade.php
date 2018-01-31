<div class="modal fade" role="dialog" id='modalService'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agrega Servicio</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmServices']) !!}
                <input type="hidden" id="id" name="id" class="input-service">
                <input type="hidden" id="sample_id" name="sample_id">
                <input type="hidden" id="rowItem">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Servicio:</label>
                            <select class="form-control input-service" id="product_id" name='product_id' data-api="/api/getService" required>
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-service input-sm" id="value" name='value' required readonly>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" >Cerrar</button>
                <button type="button" class="btn btn-success" id='newService'>Guardar</button>
            </div>
        </div>
    </div>
</div>