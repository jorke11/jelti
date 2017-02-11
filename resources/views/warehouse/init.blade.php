@extends('layouts.dash')

@section('content')
@section('title','Warehouse')
@section('subtitle','Management')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Warehouse</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success" type="button" id="btnOpenModal">
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
                            <th>Address</th>
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
@include('warehouse.new')
@include('Warehouse.edit')
{!!Html::script('js/Administration/Warehouse.js')!!}
@endsection