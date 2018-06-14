<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" > Save</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id_orderext" type="hidden" value="{{isset($id)?$id:''}}">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutivo:</label>
                    <input type="text" class="form-control input-departure input-sm" id="id" name='id' readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Bodega:</label>
                    <select class="form-control input-departure" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse" required="">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-departure input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable" required>
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Ciudad Origen:</label>
                    <select class="form-control input-departure" id="city_id" name='city_id' width="100%" data-api="/api/getCity" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Fecha:</label>
                    <input type="datetime" class="form-control input-departure form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" required readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Estatus:</label>
                    <select class="form-control input-departure input-sm" id="status_id" name='status_id' readonly>
                        <option value="0">Selection</option>
                        @foreach($status as $val)
                        <option value="{{$val->code}}">{{$val->description}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Cliente:</label>
                    <select class="form-control input-departure input-fillable" id="client_id" name='client_id' data-api="/api/getClient" required> 
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Razón Social o Cuenta:</label>
                    <input type="text" class="form-control input-departure input-sm" id="name_client" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Ciudad Destino:</label>
                    <select class="form-control input-departure" id="destination_id" name='destination_id' data-api="/api/getCity" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Dirección:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="address" name="address" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Teléfono:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="phone" name="phone"> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Branch office:</label>
                    <select class="form-control input-departure input-fillable" id="branch_id" name='branch_id'>

                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Flete:</label>
                    <input type="text" class="form-control input-departure" id="shipping_cost" name="shipping_cost" data-type="number" required readonly="">
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Observationes:</label>
                    <input type="text" class="form-control input-departure" id="description" name="description" required>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Factura:</label>
                    <input type="text" class="form-control input-departure" id="invoice" readonly>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>


<div class="row">

    <div class="col-lg-7">
        <table class="table table-bordered table-condensed" id="tblDetail">
            <thead>
                <tr>
                    <th colspan="8" ><h4>Detalle Orden</h4></th>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Disponible</th>
                    <th>Lote</th>
                    <th>Vencimiento</th>
                    <th width="8%">Cantidad</th>
                    <th>Razon</th>
                    <th>Agregar</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="col-lg-5">
        <table class="table table-bordered table-condensed" id="tblDetailSelected">
            <thead>
                <tr>
                    <th colspan="8" ><h4>Detalle Seleccion</h4></th>
                </tr>
                <tr>
                    <th >Producto</th>
                    <th>Razon</th>
                    <th>Cantidad</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!--    <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-info btn-sm" id='btnAdd'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true" > Agregar</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed" id="tblDetail">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Producto</th>
                                <th>Disponible</th>
                                <th>Lote</th>
                                <th>Vencimiento</th>
                                <th>Cantidad</th>
                                <th>razon</th>
                                <th>Agregar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>-->
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">Notas credito generadas</div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-condensed  table-hover" id="tblNote" width='100%'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Id</th>
                            <th>Factura</th>
                            <th>Cliente</th>
                            <th>Orden de venta</th>
                            <th>PDF</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modalDetail">
    <div class="modal-dialog modal-lg" role="document" style="width: 1000px">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail factura</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-condensed table-hover" id="tblDetailDeparture" width='100%'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad Disponible</th>
                            <th>Lote</th>
                            <th>Fecha Vencimiento</th>
                            <th>Cantidad</th>
                            <th>Tipo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



