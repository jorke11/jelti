@extends('layouts.dash')

@section('content')
@section('title','Profile')
@section('subtitle','Management')

{!!Html::script('/vendor/treeview/logger.min.js')!!}
{!!Html::script('/vendor/treeview/treeview.js')!!}

<div class="row">
    <div class="col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Role</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Permission</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnSavePermission">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <!--<div id="tree"></div>-->
                        <div id="treeview-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('Security.role.form')
{!!Html::script('js/Security/Role.js')!!}
@endsection