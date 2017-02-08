@extends('layouts.dash')
@section('content')
@section('title','Supplier')
@section('subtitle','Management')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">List Supplier</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success" type="submit" data-toggle='modal' data-target="#modalNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="panel-body">
                <table class="table table-condensed table-bordered" id="tblSuppliers" width='100%'>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Last Name</th>
                            <th>Document</th>
                            <th>Contact</th>
                            <th>Phone Contact</th>
                            <th>Email</th>
                            <th>Term</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Type Person</th>
                            <th>Regimen</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('supplier.edit')
@include('supplier.new')
{!!Html::script('js/Administration/Supplier.js')!!}
@endsection