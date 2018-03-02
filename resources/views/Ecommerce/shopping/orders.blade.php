@extends('layouts.client')
@section('content')
<div class="row" style="padding-bottom: 3%;padding-top: 3%">
    <div class="col-lg-12">
        <table class="table table-bordered  table-condensed" id="orderClient">
            <thead>
                <tr>
                    <th></th>
                    <th>Factura</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot></tfoot>
        </table>
    </div>
</div>

@include("footer")

{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection