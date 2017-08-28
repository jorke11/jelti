<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-condensed  table-hover" id="tbl" width='100%'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>F. Despacho</th>
                        <th>Cliente</th>
                        <th>Razón Social</th>
                        <th>Comercial</th>
                        <th>Ciudad</th>
                        <th>Valor a Pagar</th>
                        <th>Valor a Pagado</th>
                        <th>dias_vencidos</th>
                        <th>Estado</th>
                        <th tipo="prueba">Factura</th>
                        <th tipo="prueba">Pagar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th></th>
                        <th style="text-align:center">Total:</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>    </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalPayed">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pagar</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmPay']) !!}
                <input type="hidden" class="input-pay input-sm" id="departure_id" name='departure_id'>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Saldo:</label>
                            <input type="text" class="form-control input-pay input-sm" id="saldo" name='saldo'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Comentario:</label>
                            <textarea class="form-control input-pay" id="comment"></textarea>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnPay">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->