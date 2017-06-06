@extends('layouts.dash')
@section('content')
@section('title','Posible Cliente')
@section('subtitle','Administración')


<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
            <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('Sellers.prospect.list')
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane " id="management">
                @include('Sellers.prospect.management')
            </div>
        </div>
    </div>
</div>





{!!Html::script('js/Seller/Prospect.js')!!}
@endsection