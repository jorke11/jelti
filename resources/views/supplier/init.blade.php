@extends('layouts.dash')
@section('content')
@section('title','Supplier')
@section('subtitle','Management')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="myTabs">
        <li role="presentation" id="tabList" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
        <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
        <li role="presentation" id="tabBranch" class="hide"><a href="#branch" aria-controls="profile" role="tab" data-toggle="tab">Branch Office</a></li>
        <li role="presentation" id="tabSpecial" class="hide"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">Special</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('supplier.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('supplier.management')
        </div>
        <div role="tabpanel" class="tab-pane" id="branch">
            @include('supplier.branch')
        </div>
        <div role="tabpanel" class="tab-pane " id="special">
            @include('supplier.special')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Supplier.js')!!}
@endsection