@extends('layouts.dash')
@section('content')
@section('title','Compras')
@section('subtitle','Administración')

{!!Html::script('/vendor/inputmask/inputmask.js')!!}

<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
            <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">

                    @include('Invoicing.purchase.list')

                </div>

            </div>
            <div role="tabpanel" class="tab-pane " id="management">
                @include('Invoicing.purchase.management')
            </div>

        </div>
    </div>
</div>
@include('Invoicing.purchase.newDetail')
{!!Html::script('js/Invoicing/Purchase.js')!!}
@endsection