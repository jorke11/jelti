@extends('layouts.dash')
@section('content')
@section('title','Entry')
@section('subtitle','Management')
{!!Html::script('/vendor/inputmask/inputmask.js')!!}
{!!Html::script('/vendor/inputmask/jquery.inputmask.js')!!}

<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
            <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
            <!--<li role="presentation"><a href="#uploadFile" aria-controls="profile" role="tab" data-toggle="tab">Upload</a></li>-->
             <li role="presentation" id="tabUpload"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Upload</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('Inventory.entry.list')
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="management">
                @include('Inventory.entry.management')
            </div>
            
            <div role="tabpanel" class="tab-pane" id="upload">
              @include('Inventory.entry.upload')
            </div>

        </div>
    </div>
</div>
@include('Inventory.entry.newDetail')
{!!Html::script('js/Inventory/Entry.js')!!}
@endsection