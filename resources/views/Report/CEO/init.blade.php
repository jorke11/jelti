@extends('layouts.report')
@section('content')

<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-8 col-center">
                <div class="col-lg-5">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Inicio</label>
                        <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m-") . "01" ?>">
                    </div>
                </div>
                <div class="col-lg-5">
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
                    <thead>
                        <tr>
                            <th colspan="4">Resumen</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Total Clientes</td>
                        <td><span id="total_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Total Facturas</td>
                        <td><span id="total_invoice"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Ticket Promedio</td>
                        <td><span id="average"></span></td>
                    </tr>
                    <tr>
                        <td>Total Categorías</td>
                        <td><span id="category"></span></td>
                    </tr>
                    <tr>
                        <td>Total Proveedores</td>
                        <td><span id="supplier"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-user-information" id="tblSales">
                    <thead>
                        <tr>
                            <th colspan="7" align="center">Ventas vs Unidades</th>
                        </tr>
                        <tr>
                            <th>Mes</th>
                            <th>Total facturado</th>
                            <th>SubTotal</th>
                            <th>Iva 19%</th>
                            <th>Iva 5%</th>
                            <th>Flete</th>
                            <th>Unidades</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="tblClient">
                    <thead>
                        <tr >
                            <th colspan="3">Top 10 Clientes</th>
                        </tr>
                        <tr>
                            <th>Cliente</th>
                            <th>Unidades</th>
                            <th>Facturado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
               <table class="table" id="tblProduct">
                    <thead>
                        <tr >
                            <th colspan="3">Top 10 Productos</th>
                        </tr>
                        <tr>
                            <th>Producto</th>
                            <th>Unidades</th>
                            <th>Facturado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="tblCategory">
                    <thead>
                        <tr >
                            <th colspan="3">Top 5 Categoria</th>
                        </tr>
                        <tr>
                            <th>Categoria</th>
                            <th>Unidades</th>
                            <th>Facturado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
               <table class="table" id="tblSuppplier">
                    <thead>
                        <tr >
                            <th colspan="3">Top 5 Proveedor</th>
                        </tr>
                        <tr>
                            <th>Proveedor</th>
                            <th>Unidades</th>
                            <th>Facturado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="tblCommercial">
                    <thead>
                        <tr >
                            <th colspan="3">Top 5 Comercial</th>
                        </tr>
                        <tr>
                            <th>Comercial</th>
                            <th>Unidades</th>
                            <th>Facturado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                   
                </table>
            </div>
        </div>
    </div>
</div>




<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

{!!Html::script('js/Report/CEO.js')!!}

@endsection