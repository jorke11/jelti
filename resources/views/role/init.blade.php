@extends('layouts.dash')

@section('content')
@section('title','Profile')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Role</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success" type="submit" data-toggle='modal' data-target="#modalNew">
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
</div>
@include('role.new')
@include('role.edit')
{!!Html::script('js/Security/Role.js')!!}
@endsection