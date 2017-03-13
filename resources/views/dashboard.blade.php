@extends('layouts.dash')
@section('content')
<style>
    .huge {
        font-size: 40px;
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
                <div class="panel panel-primary" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                <div class="huge">26</div>
                                <div> coments</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#">
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
                                <i class="fa fa-star fa-5x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                <div class="huge">Aceite</div>
                                <div> Best Product</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#">
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
                <div class="panel panel-green" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-shopping-cart fa-5x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                <div class="huge">250</div>
                                <div> Shopping</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#">
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
                <div class="panel panel-red" style="margin-bottom: 0px;">
                    <div class="panel-heading" style="height: 100px;">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-md-9 col-sm-9 text-right">
                                <div class="huge">50</div>
                                <div> Alerts</div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#">
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
                        <h2>Line graph<small>Sessions</small></h2>
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
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Bar graph <small>Sessions</small></h2>
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
                        <canvas id="mybarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Radar <small>Sessions</small></h2>
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
                        <canvas id="canvasRadar"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Donut Graph <small>Sessions</small></h2>
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
                        <canvas id="canvasDoughnut"></canvas>
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

{!!Html::script('/vendor/template/vendors/Chart.js/dist/Chart.min.js')!!}
@endsection