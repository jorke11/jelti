@extends('layouts.dash')
@section('content')
@section('title','Ordenes de Venta')
@section('subtitle','Administración')
<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Inventory.departure.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Inventory.departure.management')
        </div>

    </div>
</div>

<div class="modal fade" id="modalColumns" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Opcion para quitar columnas</h4>
            </div>
            <div class="modal-body">
                <ul>
                    <li><a id="col-dispatched" style="cursor: pointer" data-column="4">Despachado</a></li>
                    <li><a id="col-business_name" style="cursor: pointer" data-column="6">Razón Social</a></li>
                </ul>
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalFilter" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Opción para filtrar</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Fecha Inicio:</label>
                            <input type="text" id="finit_filter" class="form-control form_date modal-filter">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Fecha Fin:</label>
                            <input type="text" id="fend_filter" class="form-control form_date modal-filter">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Cliente:</label>
                            <select class="form-control input-departure modal-filter" id="client_filter" name='client_filter' data-api="/api/getClient"> 
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Comercial:</label>
                            <select class="form-control input-departure input-sm modal-filter" id="responsible_filter" name='responsible_filter' readonly data-api="/api/getResponsable">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Id:</label>
                            <input type="text" id="id_filter" class="form-control modal-filter">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Factura:</label>
                            <input type="text" id="invoice_filter" class="form-control modal-filter">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnFilter">Filtrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@include('Inventory.departure.newDetail')
@include('Inventory.departure.newService')
@include('Inventory.departure.upload')
{!!Html::script('js/Inventory/Departure.js')!!}
@endsection