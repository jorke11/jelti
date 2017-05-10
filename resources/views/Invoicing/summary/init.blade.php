@extends('layouts.dash')

@section('content')
@section('title','Kardex')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3">
                        <input type="text" id="quantity" name="quantity" placeholder="days">
                    </div>
                    <div class="col-lg-2">
                        <button id="btnPrint" class="btn btn-success" type="button">Print</button>
                      
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-condensed table-bordered" id="data">
                            <thead>
                                <tr>
                                    <th>Dias</th>
                                    <th>Aleatorio</th>
                                    <th># autos rentados por dia</th>
                                    <th>Aleatorio</th>
                                    <th># dias rentados por auto</th>
                                    <th>Disponibles</th>
                                    <th>Necesarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>

                        </table>
                    </div>

                </div>
              
            </div>
        </div>
    </div>
</div>

{!!Html::script('js/Invoicing/Summary.js')!!}
@endsection