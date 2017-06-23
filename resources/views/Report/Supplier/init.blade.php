@extends('layouts.dash')
@section('content')
@section('title','Indicador')
@section('subtitle','Proveedores')



<div class="row">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-lg-10 col-center">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="title" class="control-label">Proveedor</label>
                        <select class="form-control input-departure input-find" id="supplier_id" name='supplier_id'  data-api="/api/getSupplier">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="title" class="control-label">Producto</label>
                        <select class="form-control input-departure input-find" id="product_id" name='product_id'  data-api="/api/getProduct">
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Inicio</label>
                        <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m-") . "01" ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="title" class="control-label">Fecha Final</label>
                        <input type="text" class="form-control input-sm" id="fend" name='fend' value="<?php echo date("Y-m-d") ?>">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <button class="btn btn-success btn-sm" id="btnSearch" type="button">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>



<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                @include('Report.Supplier.client')
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
               @include('Report.Supplier.detail')
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Nav tabs -->
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
<!--                @include('Report.Supplier.detail')-->
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <!--@include('Report.Client.target')-->
            </div>
        </div>
    </div>
</div>


{!!Html::script('js/Report/Supplier.js')!!}

@endsection