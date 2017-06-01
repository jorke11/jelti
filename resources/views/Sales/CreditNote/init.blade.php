@extends('layouts.dash')
@section('content')
@section('title','Notas Credito')
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
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Sales.CreditNote.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Sales.CreditNote.management')
        </div>

    </div>
</div>
@include('Sales.CreditNote.newDetail')
{!!Html::script('js/Sales/Purse.js')!!}
@endsection