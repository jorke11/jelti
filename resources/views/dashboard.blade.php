@extends('layouts.dash')
@section('content')
<style>
    .huge {
        font-size: 18px;
    }

    .panel-green > .panel-heading {
        border-color: #5cb85c;
        color: white;
        background-color: #5cb85c;
    }
    .panel-yellow {
        border-color: #f0ad4e;
        color: white;
        background-color: #f0ad4e;
    }

    .panel-red > .panel-heading {
        border-color: #d9534f;
        color: white;
        background-color: #d9534f;
    }
    .panel-blue > .panel-heading {
        border-color: #4e859a;
        color: white;
        background-color: #4e859a;
    }

</style>
<div class="right_col" role="main" style="margin:0 auto;">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Data mind <small>Review</small></h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="panel panel-green" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-shopping-cart fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($client))
                                <div class="huge">Cliente <br>{{(isset($client->client)?$client->client:'SuperFüds')}}</div>
                                <div> Total Unidades {{(isset($client->unidades)?$client->unidades:0)}}<br>
                                    @if(count($client)>0)
                                    Monto: $ {{number_format(round($client->total), 0, ',', '.')}}
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportClient">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-sm-3">
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-suitcase fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($supplier))
                                <div class="huge">Proveedor<br>{{(isset($supplier->proveedor)?$supplier->proveedor:'SuperFüds')}}</div>
                                <div> Total Unidades {{(isset($supplier->cantidadtotal)?$supplier->cantidadtotal:0)}}<br>
                                    @if(count($supplier)>0)
                                    Monto: $ {{number_format(round($supplier->total), 0, ',', '.')}}
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportSupplier">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="panel panel-yellow" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-star fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($product))
                                <div class="huge">Producto<br>{{(isset($product->title)?$product->title:'')}}</div>
                                <div> Unidades Vendidas {{(isset($product->cantidadtotal)?$product->cantidadtotal:0)}}<br>
                                    @if(count($product)>0)
                                    Monto: $ {{number_format(round($product->total), 0, ',', '.')}}
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportProduct">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">Ver Detalle</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 col-sm-3">
                <div class="panel panel-red" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-user-circle-o fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($commercial))
                                <div class="huge">Mejor Vendedor<br>{{$commercial->vendedor}}</div>
                                <div> Total Unidades {{$commercial->cantidadtotal}}<br>
                                    Monto: $ {{number_format(round($commercial->total), 0, ',', '.')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportCommercial">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="panel panel-blue" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-user-circle-o fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($newClient))
                                <div class="huge">Clientes Nuevos{{$newClient->estemes}}</div>
                                <div> Total Mes anterior {{$newClient->mesanterior}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportCommercial">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-3 col-sm-3">
                <div class="panel panel-blue" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-user-circle-o fa-4x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                @if(isset($purchase))
                                <div class="huge">Compras $ {{number_format(round($purchase->estemes), 0, ',', '.')}}</div>
                                <div> Total Mes anterior $ {{number_format(round($purchase->mesanterior), 0, ',', '.')}}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/reportCommercial">
                    <div class="panel-footer" style="background-color:#fff;border-color: blue;">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        
        
        <br />
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ventas por Productos del mes {{date("F")}}<small>A la fecha {{date("Y F d")}}</small></h2>
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
                        <div id="container_product" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ventas por Productos del mes {{date("F")}}<small>A la fecha {{date("Y F d")}}</small></h2>
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
                         <div id="graph_products" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ventas por Totales (histórico)<small>A la fecha {{date("Y F d")}}</small></h2>
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
                        <div id="graph_sales" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ventas por proveedor del mes {{date('F')}} <small>A la fecha {{date("Y F d")}}</small></h2>
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
                        <div id="container_supplier" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pie Graph Chart <small>Sessions</small></h2>
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
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pie Area Graph <small>Sessions</small></h2>
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
                        <canvas id="polarArea"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--{!!Html::script('/vendor/template/vendors/Chart.js/dist/Chart.min.js')!!}-->
{!!Html::script('/js/dash.js')!!}
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
@endsection