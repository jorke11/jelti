@extends('layouts.dash')
@section('content')
@section('title','Supplier')
@section('subtitle','Management')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="myTabs">
        <li role="presentation" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
        <li role="presentation"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('supplier.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('supplier.management')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Supplier.js')!!}
@endsection