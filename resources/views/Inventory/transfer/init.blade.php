@extends('layouts.dash')
@section('content')
@section('title','Traslados')
@section('subtitle','Administración')
<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Inventory.transfer.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Inventory.transfer.management')
        </div>

    </div>
</div>
@include('Inventory.transfer.newDetail')
@include('Inventory.transfer.upload')
{!!Html::script('js/Inventory/Transfer.js')!!}
@endsection