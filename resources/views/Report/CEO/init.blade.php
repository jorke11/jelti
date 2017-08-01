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
                        <td>Total Clients</td>
                        <td><span id="total_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Total invoices</td>
                        <td><span id="total_invoice"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Average Ticket Price</td>
                        <td><span id="average"></span></td>
                    </tr>
                    <tr>
                        <td>Total Categories</td>
                        <td><span id="category"></span></td>
                    </tr>
                    <tr>
                        <td>Total Suppliers</td>
                        <td><span id="supplier"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-user-information">
                    <thead>
                        <tr>
                            <th colspan="4">Sales vs Units</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
                        <td>Lead Time</td>
                        <td><span id="lead_time"></span></td>
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
            <div class="panel-body">
                <table class="table table-user-information">
                    <thead>
                        <tr>
                            <th colspan="4">Top 10 Clients</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
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
                    <thead>
                        <tr>
                            <th colspan="4"> Top 10 Products</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
                        <td>Lead Time</td>
                        <td><span id="lead_time"></span></td>
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
            <div class="panel-body">
                <table class="table table-user-information">
                    <thead>
                        <tr>
                            <th colspan="4">Top 5 Categories</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
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
                    <thead>
                        <tr>
                            <th colspan="4">Top 5 Suppliers</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
                        <td>Lead Time</td>
                        <td><span id="lead_time"></span></td>
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
            <div class="panel-body">
                <table class="table table-user-information">
                    <thead>
                        <tr>
                            <th colspan="4">Sales Team</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>Cliente desde</td>
                        <td><span id="client_until"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Nombre Cliente</td>
                        <td><span id="name_client"></span></td>
                        
                    </tr>
                    <tr>
                        <td>Dirección/Ciudad</td>
                        <td><span id="city_address"></span></td>
                    </tr>
                    <tr>
                        <td>Lead Time</td>
                        <td><span id="lead_time"></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>




<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

{!!Html::script('js/Report/CEO.js')!!}

@endsection