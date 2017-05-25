@extends('layouts.dash')
@section('content')
@section('title','Proveedores')
@section('subtitle','Administración')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="myTabs">
        <li role="presentation" id="tabList" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a></li>
        <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <i class="fa fa-address-card fa-lg" aria-hidden="true" ></i>
            </a></li>
        <li role="presentation" id="tabUpload" class="hidden"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Supplier</a></li>
        <li role="presentation" id="tabTax" class="hidden"><a href="#frmTax" aria-controls="special" role="tab" data-toggle="tab">Impuestos</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Administration.stakeholder.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('Administration.stakeholder.management')
        </div>
        <div role="tabpanel" class="tab-pane" id="upload">
            @include('Administration.stakeholder.supplier')
        </div>
        <div role="tabpanel" class="tab-pane " id="frmTax">
            @include('Administration.stakeholder.tax')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Stakeholder.js')!!}
@endsection