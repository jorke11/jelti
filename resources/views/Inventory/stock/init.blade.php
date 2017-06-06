@extends('layouts.dash')
@section('content')
@section('title','Stock')
@section('subtitle','Reporte')

<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">Stock</div>
                </div>
            </div>
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Entry</th>
                            <th>Purchases</th>
                            <th>Departure</th>
                            <th>Sales</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!!Html::script('js/Inventory/Stock.js')!!}
@endsection