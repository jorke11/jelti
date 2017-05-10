@extends('layouts.dash')
@section('content')
@section('title','Contact')
@section('subtitle','Management')
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="myTabs">
        <li role="presentation" id="tabList" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
        <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Administration.contact.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('Administration.contact.management')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Contact.js')!!}
@endsection