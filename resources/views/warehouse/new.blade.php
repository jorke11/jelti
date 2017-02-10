<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warehouse</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">description:</label>
                            <input type="text" class="form-control input-product" id="description" name='description'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Address:</label>
                            <input type="text" class="form-control input-product" id="address" name='address'>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="id" name="id">
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id='new'>Save</button>
            </div>
        </div>
    </div>
</div>