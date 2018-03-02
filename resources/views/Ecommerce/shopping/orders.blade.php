@extends('layouts.client')
@section('content')
<div class="row" style="padding-bottom: 3%;padding-top: 3%">
    <div class="col-lg-12">
        <table class="table table-bordered" id="orderClient">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Factura</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@include("footer")

{!!Html::script('js/Ecommerce/Detail.js')!!}
@endsection