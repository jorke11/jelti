
<div class="panel panel-default">
    <div class="page-title" style="">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> Save</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm','files' => true]) !!}
        <input id="id" name="id" type="hidden" class="input-services">
        <div class="row">
            <div class="col-lg-8 col-center">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Información</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="title" class="control-label">Título*</label>
                                    <input type="text" class="form-control input-services input-sm" id="title" name='title' required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="description" class="control-label">Descripción*</label>
                                    <input type="text" class="form-control input-services input-sm" id="description" name='description' required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Descripción Corta*</label>
                                    <input type="text" class="form-control input-services input-sm" id="short_description" name='short_description' required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Proveedor *</label>
                                    <select class="form-control input-services" id='supplier_id' name="supplier_id" data-api="/api/getSupplier" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Impuesto *</label>
                                    <select id="tax" name="tax" class="form-control input-services">
                                        @if(isset($tax))
                                        @foreach($tax as $val)
                                        <option value="{{$val->value}}">{{$val->description}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group" class="control-label">
                                    <label for="email" class="control-label">Precio*</label>
                                    <input type="text" class="form-control input-services"  id="price_sf" name='price_sf' required data-type="number">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Estatus</label>
                                    <input type="checkbox" class="form-control input-services" id="status_id" name='status_id'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {!!Form::close()!!}
    </div>
</div>



@include('Administration.products.modalUpload')