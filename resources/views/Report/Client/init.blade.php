@extends('layouts.report')
@section('content')

<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-6 col-center">
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
                <div id="container_product" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                <!--@include('Report.Client.product')-->
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="container_cities" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                <!--@include('Report.Client.cities')-->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('Report.Product.detail')
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                
            </div>
        </div>
    </div>
</div>


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

{!!Html::script('js/Report/Client.js')!!}

@endsection