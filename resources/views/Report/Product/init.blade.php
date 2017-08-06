@extends('layouts.report')
@section('content')
<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-12 col-center">
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
                        <label for="title" class="control-label">Ciudades</label>
                        <select class="form-control input-departure input-find" id="city_id" name='city_id'  data-api="/api/getCity">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Producto</label>
                        <select class="form-control input-departure input-find" id="product_id" name='product_id'  data-api="/api/getProduct">
                        </select>
                    </div>
                </div>
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

        <div class="x_panel">
            <div class="x_title">
                <h2>Ventas por Productos<small>Sessions</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('Report.Product.detail')
            </div>
        </div>
    </div>
    <div class="col-lg-6">

        <div class="x_panel">
            <div class="x_title">
                <h2>Producto más vendido por Ciudad<small class="date-report"></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('Report.Product.products')
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">

        <div class="x_panel">
            <div class="x_title">
                <h2>Ventas de Productos Por Cliente<small class="date-report"></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @include('Report.Product.productsclient')
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
{!!Html::script('js/Report/Product.js')!!}

@endsection