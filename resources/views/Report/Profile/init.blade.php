@extends('layouts.report')
@section('content')

<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Bodega</label>
                        <select class="form-control" id="warehouse_id" name="warehouse_id">
                            <option value="0">SuperFüds</option>
                            @foreach($warehouse as $val)
                            <option value="{{$val->id}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Cliente</label>
                        <select class="form-control input-client" id="client_id" name='client_id' data-api="/api/getClient" required> 
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Ciudades</label>
                        <select class="form-control input-client input-find" id="city_id" name='city_id'  data-api="/api/getCity">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Producto</label>
                        <select class="form-control input-client input-find" id="product_id" name='product_id'  data-api="/api/getProduct">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Proveedor</label>
                        <select class="form-control input-client input-find" id="supplier_id" name='supplier_id'  data-api="/api/getSupplier">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Comercial</label>
                        <select class="form-control input-client input-find" id="commercial_id" name='commercial_id'  data-api="/api/getCommercial">
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Inicio</label>
                        <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m-") . "01" ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Final</label>
                        <input type="text" class="form-control input-sm" id="fend" name='fend' value="<?php echo date("Y-m-d") ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <button class="btn btn-success btn-sm" id="btnSearch" type="button">Search</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-user-information">
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        <td>Comercial asignado</td>
                        <td><span id="responsible"></span></td>
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        <td>Ultima venta</td>
                        <td><span id="last_sale"></span></td>
                    </tr>
                    <tr>
                        <td>Sector</td>
                        <td><span id="sector"></span></td>
                        <td>Frecuencia</td>
                        <td><span id="frecuency"></span></td>
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                        <td>Lead Time</td>
                        <td><span id="lead_time"></span></td>

                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-user-information">
                    <tr>
                        <td>Venta total a Cliente</td>
                        <td><span id="total_sales"></span></td>
                        <td>Ticket promedio</td>
                        <td><span id="ticket"></span></td>
                    </tr>
                    <tr>
                        <td>Total pedidos</td>
                        <td><span id="total_request"></span></td>
                        <td>Pedido vs Despachado</td>
                        <td><span id="name_client"></span></td>

                    </tr>
                    <tr>
                        <td>Valor no facturado</td>
                        <td><span id="last_sale"></span></td>
                        <td>Cumplimiento por orden</td>
                        <td><span id="city_address"></span></td>

                    </tr>
                    <tr>
                        <td>Cumplimiento promedio</td>
                        <td><span id="frecuency"></span></td>
                        <td>Devoluciones</td>
                        <td><span id="retorno"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading personal">Productos Vendidos</div>
            <div class="panel-body">
                <table class="table table-condensed  table-bordered" id="tblProduct">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Unidades</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <body>
                    </body>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading personal"></div>
            <div class="panel-body">
                <table class="table table-condensed  table-bordered" id="tblCategory">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Pedidas</th>
                            <th>Total Categorias</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('Report.Profile.repurchase')
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

{!!Html::script('js/Report/Profile.js')!!}

@endsection