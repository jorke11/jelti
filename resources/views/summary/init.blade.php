@extends('layouts.dash')

@section('content')
@section('title','Kardex')
@section('subtitle','Management')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Product</th>
                            <th>Entry</th>
                            <th>Departure</th>
                            <th>Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalEntry = 0;
                        $totalDeparture = 0;
                        $total = 0;
                        foreach ($summary as $k) {
                            $totalEntry += $k->entry;
                            $totalDeparture += $k->departure;
                            $total += $k->available;
                            ?>
                            <tr>
                                <td>{{$k->fecha}}</td>
                                <td>{{$k->product}}</td>
                                <td>{{$k->entry}}</td>
                                <td>{{$k->departure}}</td>
                                <td>{{$k->available}}</td>
                            </tr>
                        <?php }
                        ?>

                        <tr>
                            <td colspan="2">Total</td>
                            <td>{{$totalEntry}}</td>
                            <td>{{$totalDeparture}}</td>
                            <td>{{$total}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('Category.new')
@include('Category.edit')
{!!Html::script('js/Inventory/Kardex.js')!!}
@endsection