@extends('layouts.report')
@section('content')

<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-10 col-center">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="title" class="control-label">Cliente</label>
                        <select class="form-control input-departure input-fillable" id="client_id" name='client_id' data-api="/api/getClient" required> 
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Inicio</label>
                        <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m-") . "01" ?>">
                    </div>
                </div>
                <div class="col-lg-3">
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
                        <td><span id="client_until"></span></td>
                        <td>Ticker promedio</td>
                        <td><span id="responsible"></span></td>
                    </tr>
                    <tr>
                        <td>Pedido vs Despachado</td>
                        <td><span id="name_client"></span></td>
                        <td>Valor no facturado</td>
                        <td><span id="last_sale"></span></td>
                    </tr>
                    <tr>
                        <td>Cumplimiento por orden</td>
                        <td><span id="city_address"></span></td>
                        <td>Cumplimiento promedio</td>
                        <td><span id="frecuency"></span></td>
                    </tr>
                    <tr>
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