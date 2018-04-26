@extends('layouts.dash')
@section('content')
@section('title','Stock')
@section('subtitle','Reporte')
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="email">Bodega</label>
                            <select class="form-control" id="warehouse_id">
                                <option value="0">Seleccione</option>
                                @foreach($warehouse as $val)
                                <option value="{{$val->id}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Busqueda</label>
                            <input type="text" id="bar_code" name="bar_code" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button id="btnFind" class="btn btn-success btn-sm" type="button">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <ul class="nav nav-tabs" role="tablist" id='myTabs'>
        <li role="presentation" class="active" id="tabList"><a href="#list" aria-controls="home" role="tab" data-toggle="tab">Inventario</a></li>
        <li role="presentation" id="tabLog"><a href="#management" aria-controls="profile" role="tab" data-toggle="tab">Log</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('Inventory.stock.list')
                </div>
            </div>

        </div>
        <div role="tabpanel" class="tab-pane " id="management">
            @include('Inventory.stock.hold')
        </div>

    </div>
</div>

{!!Html::script('js/Inventory/Stock.js')!!}
@endsection