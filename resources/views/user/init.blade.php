@extends('layouts.dash')
@section('content')
@section('title','User')
@section('subtitle','Management')

<div class="row">
    <div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" id='myTabs'>
            <li role="presentation" class="active"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">List</a></li>
            <li role="presentation"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Management</a></li>
            <li role="presentation"><a href="#permission" aria-controls="profile" role="tab" data-toggle="tab">Permission</a></li>
            
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="list">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @include('user.list')
                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane " id="management">
                <div class="panel panel-default">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-success" id='new'>
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('user.management')
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane " id="permission">
                <div class="panel panel-default">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button class="btn btn-success" id='new'>
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @include('user.permission')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{!!Html::script('js/Security/User.js')!!}
@endsection