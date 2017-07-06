<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> Nuevo</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" > Guardar</span>
                </button>
                @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 1)
                <button class="btn btn-success btn-sm" id='btnSend' disabled>
                    <span class="glyphicon glyphicon-send" aria-hidden="true"> Enviar</span>
                </button>

                <button class="btn btn-success btn-sm" id='btnDocument' disabled>
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Pdf</span>
                </button>
                @endif
                @if( Auth::user()->role_id == 1)
                <button class="btn btn-success btn-sm" id='btnReverse'>
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true">Reversar</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id_orderext" type="hidden" value="{{isset($id)?$id:''}}">
        <input id="client_id" type="hidden" value="{{$client_id}}">
        <input id="init" type="hidden" value="{{$init}}">
        <input id="end" type="hidden" value="{{$end}}">
        <input id="type" type="hidden" value="{{$type}}">
        <input id="product_id" type="hidden" value="{{$product}}">
        <input id="commercial_id" type="hidden" value="{{$commercial_id}}">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">#:</label>
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
                    <select class="form-control input-departure input-fillable" id="destination_id" name='destination_id' data-api="/api/getCity" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Dirección:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="address" name="address" required>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Teléfono:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="phone" name="phone" required> 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Sucursal:</label>
                    <select class="form-control input-departure input-fillable" id="branch_id" name='branch_id'>

                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Flete:</label>
                    <input type="text" class="form-control input-departure" id="shipping_cost" name="shipping_cost" data-type="number" required>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Observaciones:</label>
                    <input type="text" class="form-control input-departure" id="description" name="description">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Factura:</label>
                    <input type="text" class="form-control input-departure" id="invoice" readonly>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Guia:</label>
                    <input type="text" class="form-control input-departure" id="transport" name="transport">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Descuento:</label>
                    <input type="text" class="form-control input-departure" id="discount" name="discount">
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">Detalle</div>
                    <div class="col-lg-8 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnAsociar">
                            Asociar
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id="btnModalUpload">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id="btnmodalDetail">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed" id="tblDetail">
                    <thead>
                        <tr>
                            <th colspan="3" class="center-rowspan">Información</th>
                            <th colspan="3" class="center-rowspan">Pedido</th>
                            <th colspan="3" class="center-rowspan">Despachado</th>
                            <th rowspan="2" class="center-rowspan">Estatus</th>
                            <th rowspan="2" class="center-rowspan">Actiones</th>
                        </tr>
                        <tr>
                            <th>Producto</th>
                            <th>Comentario</th>
                            <th>Embalaje</th>
                            <th>Cantidad</th>
                            <th>Unidad</th>
                            <th>Total</th>
                            <th>Cantidad</th>
                            <th>Unidades</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



