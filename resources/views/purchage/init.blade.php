@extends('layouts.dash')
@section('content')
@section('title','Purchage')
@section('subtitle','Management')

{!!Html::script('/vendor/inputmask/inputmask.js')!!}

<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
            <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('purchage.list')
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane " id="management">
                @include('purchage.management')
            </div>

        </div>
    </div>
</div>
@include('purchage.newDetail')
{!!Html::script('js/Invoicing/Purchage.js')!!}
@endsection