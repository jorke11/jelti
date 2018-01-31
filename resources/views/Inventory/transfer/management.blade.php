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
        <input id="product_id" type="hidden" value="{{$product_id}}">
        <input id="commercial_id" type="hidden" value="{{$commercial_id}}">
        <input id="supplier_id" type="hidden" value="{{$supplier_id}}">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">#:</label>
                    <input type="text" class="form-control input-transfer input-sm" id="id" name='id' readonly="">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Bodega Origin:</label>
                    <select class="form-control input-transfer" id="origin_id" name='origin_id' data-api="/api/getWarehouse" required="">
                    </select>

                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Bodega destino:</label>
                    <select class="form-control input-transfer" id="destination_id" name='destination_id' data-api="/api/getWarehouse" required="">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Fecha:</label>
                    <input type="datetime" class="form-control input-transfer form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" required readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Estatus:</label>
                    <select class="form-control input-transfer input-sm" id="status_id" name='status_id' readonly>
                        <option value="0">Selection</option>
                        @foreach($status as $val)
                        <option value="{{$val->code}}">{{$val->description}}</option>
                        @endforeach
                    </select>
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



