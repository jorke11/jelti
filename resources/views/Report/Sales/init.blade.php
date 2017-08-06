@extends('layouts.dash')
@section('content')
@section('title','Indicator')
@section('subtitle','Sales')

<div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Resumen</a></li>
        <li role="presentation" id="tabDetail"><a href="#detail" aria-controls="home" role="tab" data-toggle="tab">Detalle</a></li>
        <li role="presentation" id="tabFulfillmentSup"><a href="#fulfilmentSup" aria-controls="profile" role="tab" data-toggle="tab">Cumplimiento Sup </a></li>
        <li role="presentation" id="tabFulfillmentCli"><a href="#fulfilmentCli" aria-controls="profile" role="tab" data-toggle="tab">Cumplimiento Cli</a></li>
        <li role="presentation" id="tabUplod"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Load</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Report.Sales.summary')
                </div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane " id="detail">
            @include('Report.Sales.detail')
        </div>
        <div role="tabpanel" class="tab-pane " id="fulfilmentSup">
            @include('Report.Sales.fulfillmentsup')
        </div>
        <div role="tabpanel" class="tab-pane " id="fulfilmentCli">
            @include('Report.Sales.fulfillmentcli')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload">
            @include('Administration.products.management')
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

@endsection