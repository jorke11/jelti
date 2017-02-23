@extends('layouts.dash')
@section('content')
@section('title','Products')
@section('subtitle','Management')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}

<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
            <li role="presentation"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
            <li role="presentation"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">Special</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('products.list')
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane " id="management">
                @include('products.management')
            </div>
            <div role="tabpanel" class="tab-pane " id="special">
                @include('products.special')
            </div>

        </div>
    </div>
</div>
{!!Html::script('js/Administration/Products.js')!!}
@endsection