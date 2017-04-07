@extends('layouts.dash')
@section('content')
@section('title','Stake Holder')
@section('subtitle','Management')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}
<div class="row">
    <ul class="nav nav-tabs" role="tablist" id="myTabs">
        <li role="presentation" id="tabList" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
        <li role="presentation" id="tabManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
        <li role="presentation" id="tabBranch" class="hide"><a href="#branch" aria-controls="profile" role="tab" data-toggle="tab">Branch Office</a></li>
        <li role="presentation" id="tabSpecial" class="hide"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">Special</a></li>
        <li role="presentation" id="tabUpload"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Upload</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Administration.stakeholder.list')
        </div>
        <div role="tabpanel" class="tab-pane" id="management">
            @include('Administration.stakeholder.management')
        </div>
        <div role="tabpanel" class="tab-pane" id="branch">
            @include('Administration.stakeholder.branch')
        </div>
        <div role="tabpanel" class="tab-pane " id="special">
            @include('Administration.stakeholder.special')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload">
            @include('Administration.stakeholder.upload')
        </div>
    </div>
</div>
{!!Html::script('js/Administration/Stakeholder.js')!!}
@endsection