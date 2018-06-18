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
                            <input type="text" class="form-control input-detail input-sm" id="quantity" name='quantity' required data-type='number' readonly="">
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
                        <table class="table table-bordered" id="tbldetail_entry">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Fecha de Vencimiento</th>
                                    <th>Lote</th>
                                    <th>Descripción</th>
                                    <th>Add</th>
                                </tr>
                                <tr>
                                    <th><input type="number" class="form-control input-number row-detail" placeholder="Cantidad" id="detail_quantity" autofocus required=""></th>
                                    <th><input type="text" class="form-control form_datetime row-detail" placeholder="Fecha de Vencimiento"  
                                               value="<?php echo date("Y-m-d") ?>" id="detail_expiration_date" required></th>
                                    <th><input type="text" class="form-control row-detail" placeholder="Lote" id="detail_lot" required></th>
                                    <th><input type="text" class="form-control row-detail" placeholder="Descripcion" id="detail_description"></th>
                                    <th>
                                        <button class="btn btn-warning" type="button" onclick="obj.addDetail()">Add</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id='newDetail'>Guardar</button>
            </div>
        </div>
    </div>
</div>