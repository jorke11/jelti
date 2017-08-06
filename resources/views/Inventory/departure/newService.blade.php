<div class="modal fade" role="dialog" id='modalService'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agrega Servicio</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmServices']) !!}
                <input type="hidden" id="id" name="id" class="input-detail">
                <input type="hidden" id="departure_id" name="departure_id">
                <input type="hidden" id="rowItem">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Servicio:</label>
                            <select class="form-control input-detail" id="product_id" name='product_id' data-api="/api/getService" required>
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail input-sm" id="value" name='value' required readonly>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Quantity real</label>
                            <input type="text" class="form-control input-detail input-sm" id="real_quantity" name='real_quantity' min='0' placeholder="Quantity real" data-type="number"
                                   <?php echo (Auth::user()->role != 4) ? '' : "readonly" ?>>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Description</label>
                            <textarea class="form-control input-detail" id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                @endif
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-success" id='newDetail'>Save</button>
            </div>
        </div>
    </div>
</div>