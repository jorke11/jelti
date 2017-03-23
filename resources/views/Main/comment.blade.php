@extends('layouts.dash')
@section('content')
@section('title','Comment')
@section('subtitle','Filter')
<div class="row">
    
    <div class="col-lg-2">
        <select class="form-control" id="product_id" name="product_id">
            @foreach($products as $val)
            <option value="{{$val->id}}">{{$val->title}}</option>
            @endforeach
        </select>
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
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

{!!Html::script('js/Main/Comments.js')!!}
@endsection