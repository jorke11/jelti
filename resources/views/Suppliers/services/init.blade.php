@extends('layouts.dash')
@section('content')
@section('title','Servicios')
@section('subtitle','Administración')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}

<div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="tabManagement">
            <a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a>
        </li>
        <li role="presentation" id="tabUplod"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Load</a></li>
        <li role="presentation" id="tabUplod"><a href="#upload_code" aria-controls="special" role="tab" data-toggle="tab">Load Code</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Suppliers.services.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Suppliers.services.management')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload">
            @include('Suppliers.services.upload')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload_code">
            @include('Suppliers.services.upload_code')
        </div>

    </div>
</div>
{!!Html::script('js/Suppliers/Services.js')!!}
@endsection