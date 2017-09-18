@extends('layouts.dash')
@section('content')
@section('title','Cartera')
@section('subtitle','Administracion')

<div class="row">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Lista</a></li>
        <li role="presentation" id="insideManagement"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Administracion</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            @include('Sales.Briefcase.list')
        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Sales.Briefcase.management')
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
                                    <option value="0">No pagas</option>
                                    <option value="1">Pagadas</option>
                                    <option value="2">Todas</option>
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
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{!!Html::script('js/Sales/Briefcase.js')!!}
@endsection