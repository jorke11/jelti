@extends('layouts.dash')
@section('content')
@section('title','Clientes')
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
        <!--<li role="presentation" id="tabBranch" class="hide"><a href="#branch" aria-controls="profile" role="tab" data-toggle="tab">Sucursales</a></li>-->
        <li role="presentation" id="tabSpecial" class="hide"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">
            <i class="fa fa-usd fa-lg" aria-hidden="true"></i>
            </a></li>
        <li role="presentation" id="tabSpecial"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">
       <i class="fa fa-file-pdf-o fa-lg" aria-hidden="true"></i>
            </a></li>
        <li role="presentation" id="tabUpload" class="hide"><a href="#client" aria-controls="special" role="tab" data-toggle="tab">Client</a></li>
        <li role="presentation" id="tabTax" class="hide"><a href="#frmTax" aria-controls="special" role="tab" data-toggle="tab">Tax</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Administration.client.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('Administration.client.management')
        </div>
<!--        <div role="tabpanel" class="tab-pane" id="branch">
            @include('Administration.client.branch')
        </div>-->
        <div role="tabpanel" class="tab-pane" id="special">
            @include('Administration.client.special')
        </div>
        <div role="tabpanel" class="tab-pane" id="client">
            @include('Administration.client.client')
        </div>
        <div role="tabpanel" class="tab-pane " id="frmTax">
            @include('Administration.client.tax')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Client.js')!!}
@endsection