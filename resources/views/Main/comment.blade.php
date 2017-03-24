@extends('layouts.dash')
@section('content')
@section('title','Comment')
@section('subtitle','Filter')
<div class="row">

    <div class="col-lg-2">
        <select class="form-control" id="product_id" name="product_id">
            <option value="0">Selection</option>
            @foreach($products as $val)
            <option value="{{$val->id}}">{{$val->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-2">
        <input type="text" class="form-control" name="finit" id="finit" value="<?php echo date("Y-m") . "-01 00:00" ?>">
    </div>
    <div class="col-lg-2">
        <input type="text" class="form-control" name="fend" id="fend" value="<?php echo date("Y-m-d") . " 23:59" ?>">
    </div>
    <div class="col-lg-2">
        <button type="button" id="btnFind" class="btn btn-success">Search</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-8">
        <table class="table table-condensed table-bordered" id="tbl">
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Comment</td>
                    <td>StakeHolder</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{!!Html::script('js/Main/Comments.js')!!}
@endsection