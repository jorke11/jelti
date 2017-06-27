
<table class="table table-condensed  table-hover nowrap" id="tbl" width='100%'>
    <thead>
        <tr>
            <th>Detail</th>
            <th>Id</th>
            <th>Factura</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Comercial</th>
            <th>Bodega</th>
            <th>Ciudad</th>
            <th>Unidades</th>
            <th>Total</th>
            <th>Estatus</th>
            <th tipo="prueba">Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    <tfoot>
        <tr>
            <th>Detail</th>
            <th>Id</th>
            <th>Factura</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Comercial</th>
            <th>Bodega</th>
            <th>Ciudad</th>
            <th>Unidades</th>
            <th>Total</th>
            <th>Estatus</th>
            <th tipo="prueba">Action</th>
        </tr>
    </tfoot>
</table>



<div class="modal fade" role="dialog" id="modalCancel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Anular Factura</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmCancel']) !!}
                <input type="hidden" id="departure_id" name="departure_id"> 
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Justificación:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerar</button>
                <button type="button" class="btn btn-success" id="btnCancel">Guardar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

