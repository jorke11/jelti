@extends('layouts.dash')
@section('content')
@section('title','Productos')
@section('subtitle','Administración')
{!!Html::script('/vendor/file-input/js/fileinput.js')!!}
{!!Html::style('/vendor/file-input/css/fileinput.css')!!}

<div class="row">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="tabManagement">
            <a href="#management" aria-controls="profile" role="tab" data-toggle="tab">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </a>
        </li>
        <li role="presentation" id="tabUplod"><a href="#upload" aria-controls="special" role="tab" data-toggle="tab">Load</a></li>
        <li role="presentation" id="tabUplod"><a href="#upload_code" aria-controls="special" role="tab" data-toggle="tab">Load Code</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Administration.products.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Administration.products.management')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload">
            @include('Administration.products.upload')
        </div>
        <div role="tabpanel" class="tab-pane " id="upload_code">
            @include('Administration.products.upload_code')
        </div>

    </div>
</div>


<div class="modal fade" id="modalFilter" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Opcion para filtrar</h4>
            </div>
            <div class="modal-body">
                <form id="frmFilter">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Estado:</label>
                                <select class="form-control" id="status_id">
                                    <option value="1">Activas</option>
                                    <option value="2">Inactivas</option>
                                    <option value="0">Todas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnFilter">Filtrar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{!!Html::script('js/Administration/Products.js')!!}
@endsection