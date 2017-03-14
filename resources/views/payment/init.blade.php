@extends('layouts.dash')

@section('content')
@section('title','Payment')
@section('subtitle','Review')

<div class="row">
    <div class="col-lg-2">
        <button type="button" class="btn btn-success btn-lg">
            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Payment
        </button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-6">
        <table class="table table-condensed table-bordered table-hover" id="tblReview">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th width="10px">Del</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
            <tfoot>
              
            </tfoot>
        </table>
    </div>
</div>

{!!Html::script('js/Shopping/Payment.js')!!}
@endsection