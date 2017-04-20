@extends('layouts.dash')

@section('content')
@section('title','Kardex')
@section('subtitle','Management')
<style>
    #micanvas{
        border:1px #000 solid;
    }
</style>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="text" id="quantity" name="quantity">
                    </div>
                    <div class="col-lg-2">
                        <button id="btnPrint" class="btn btn-success" type="button">Print</button>
                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-condensed table-bordered" id="data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Aleatorio</th>
                                    <th>Pasos</th>
                                    <th>Aleatorio</th>
                                    <th>Angulo</th>
                                    <th>Distancia</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>

                        </table>
                    </div>

                </div>
                <canvas height="500px" width="500px" id="micanvas">
                    Su navegador no soporta en elemento CANVAS
                </canvas>
            </div>
        </div>
    </div>
</div>

{!!Html::script('js/Invoicing/Summary.js')!!}
@endsection