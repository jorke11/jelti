
{!! Form::open(['id'=>'frm']) !!}
<div class="panel panel-default">
    <div class="page-title" style="height: 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-9 col-md-6">
                    #: <label><span id="consecutive" class="input-purchase"></span></label>
                </div>
                <div class="col-lg-3 col-md-6 text-right">
                    <button type="button" class="btn btn-success btn-sm" id='btnNew'>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"> Nuevo</span>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id='btnSave' disabled>
                        <span class="glyphicon glyphicon-save" aria-hidden="true"> Guardar</span>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" id='btnSend' disabled>
                        <span class="glyphicon glyphicon-save" aria-hidden="true"> Enviar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <input id="id" name="id" type="hidden" class="input-purchase">

        <div class="row">
            <div class="col-lg-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Proveedor*:</label>
                                    <select class="form-control input-purchase  input-sm" id="supplier_id" name='supplier_id' data-api="/api/getSupplier" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Cuenta o Razón Social :</label>
                                    <input type="text" class="form-control input-purchase input-sm" id="name_supplier" readonly="">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Entrega:</label>
                                    <input type="text" class="form-control input-purchase input-sm" id="delivery" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="email">Bodega:</label>
                                    <select class="form-control input-purchase  input-sm" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse" required="">
                                    </select>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Descripción:</label>
                                    <input type="text" class="form-control input-purchase input-sm" id="description" name='description'>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Ciudad:</label>
                                    <select class="form-control input-purchase" id="city_id" name='city_id' data-api="/api/getCity" required>                  
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Estatus:</label>
                                    <select class="form-control input-purchase input-sm" id="status_id" readonly>
                                        <option value="0">Selección</option>
                                        @foreach($status as $val)
                                        <option value="{{$val->code}}">{{$val->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Fecha:</label>
                                    <input type="text" class="form-control input-purchase input-sm form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" required readonly="" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Responsable:</label>
                                    <select class="form-control input-purchase input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable" required>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">Lista Detalle</div>
                    <div class="col-lg-8 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnmodalDetail" disabled>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-hover" id="tblDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Descripción</th>
                            <th>Producto</th>
                            <th>Iva</th>
                            <th>Cantidad</th>
                            <th>Unidades</th>
                            <th>Total</th>
                            <th>Debito</th>
                            <th>Credito</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div
    </div>
</div>


