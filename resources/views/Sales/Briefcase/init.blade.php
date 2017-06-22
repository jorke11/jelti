@extends('layouts.dash')
@section('content')
@section('title','Cartera')
@section('subtitle','Administracion')

<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Administracion</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Sales.Briefcase.list')
        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Sales.Briefcase.management')
        </div>

    </div>
</div>
{!!Html::script('js/Sales/Briefcase.js')!!}
@endsection