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
                            <label for="email">Codigo Barras</label>
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
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Referencia</th>
                            <th>Proveedor</th>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!!Html::script('js/Inventory/Stock.js')!!}
@endsection