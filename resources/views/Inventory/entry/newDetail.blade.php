<div class="modal fade" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Detail</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" name="id" class="input-detail">
                <input type="hidden" id="entry_id" name="entry_id" class="input-detail">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Product:</label>
                            <select class="form-control input-detail input-sm" id="product_id" name='product_id' data-api="/api/getProduct" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Quantity:</label>
                            <input type="text" class="form-control input-detail input-sm" id="quantity" name='quantity' required data-type='number'>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail input-sm" id="value" name='value' readonly="" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Lote</th>
                                    <th>Descripción</th>
                                    <th>Add</th>
                                </tr>
                                <tr>
                                    <th><input type="number" class="form-control" placeholder="Cantidad" id="detail_quantity"></th>
                                    <th><input type="text" class="form-control " placeholder="Fecha de Vencimiento" id="detail_expiration_date"></th>
                                    <th><input type="text" class="form-control" placeholder="Lote" id="detail_lot"></th>
                                    <th><input type="text" class="form-control" placeholder="Descripcion" id="detail_description"></th>
                                    <th>
                                        <button></button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Quantity Real:</label>
                            <input type="text" class="form-control input-detail input-sm" id="real_quantity" name='real_quantity' required data-type='number'>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Expiration Date:</label>
                            <input size="16" type="text" name="expiration_date" id="expiration_date" value="<?php echo date("Y-m-d") ?>" class="form_datetime input-detail input-sm form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Lot:</label>
                            <input type="text" class="form-control input-detail input-sm" id="lot" name='lot' required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description:</label>
                            <textarea class="form-control input-detail input-sm" id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='newDetail'>Save</button>
            </div>
        </div>
    </div>
</div>