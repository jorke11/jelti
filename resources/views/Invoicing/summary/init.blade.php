@extends('layouts.dash')

@section('content')
@section('title','Kardex')
@section('subtitle','Management')
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">

                <canvas height="300px" width="300px" id="micanvas">
                    Su navegador no soporta en elemento CANVAS
                </canvas>
            </div>
        </div>
    </div>
</div>

{!!Html::script('js/Invoicing/Summary.js')!!}
@endsection