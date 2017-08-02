
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
        <input id="id" name="id" type="hidden" class="input-product">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Información</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="title" class="control-label">Título*</label>
                                    <input type="text" class="form-control input-product input-sm" id="title" name='title' required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="description" class="control-label">Descripción*</label>
                                    <input type="text" class="form-control input-product input-sm" id="description" name='description' required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Descripción Corta*</label>
                                    <input type="text" class="form-control input-product input-sm" id="short_description" name='short_description' required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Referencia*</label>
                                    <input type="text" class="form-control input-product input-sm" id="reference" name='reference' required data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Categoria *</label>
                                    <select class="form-control input-product" id='category_id' name="category_id" data-api="/api/getCategory" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Proveedor *</label>
                                    <select class="form-control input-product" id='supplier_id' name="supplier_id" data-api="/api/getSupplier" required>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">


                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Código de Barra*</label>
                                    <input type="text" class="form-control input-product" id="bar_code" name='bar_code' required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Url Imagen</label>
                                    <input type="text" class="form-control input-product" id="url_part" name='url_part'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Estatus</label>
                                    <input type="checkbox" class="form-control input-product" id="status_id" name='status_id'>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="email">Caracteristica</label>
                                    <select class="form-control input-product" id='characteristic' name="characteristic[]" data-api="/api/getCharacteristic" multiple>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Cuenta</label>
                                    <select class="form-control input-product" id='account_id' name="account_id" data-api="/api/getAccount">
                                    </select>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Meta</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" >meta_title*</label>
                                    <textarea class="form-control input-product" id="meta_title" name='meta_title'>
                                    </textarea>                
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">meta_keywords*</label>
                                    <textarea class="form-control input-product" id="meta_keywords" name='meta_keywords'>
                                    </textarea> 
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">meta_description*</label>
                                    <textarea class="form-control input-product" id="meta_description" name='meta_description'>
                                    </textarea> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Valores</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Embalaje Proveedor:</label>
                                    <input type="text" class="form-control input-product" id="units_supplier" name='units_supplier' required data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Embalaje SF*</label>
                                    <input type="text" class="form-control input-product" id="units_sf" name='units_sf' required data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Costo SF*</label>
                                    <input type="text" class="form-control input-product" id="cost_sf" name='cost_sf' required data-type="number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Impuesto *</label>
                                    <select id="tax" name="tax" class="form-control input-product">
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
                                    <label for="email" class="control-label">Precio SF*</label>
                                    <input type="text" class="form-control input-product"  id="price_sf" name='price_sf' required data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Packaging</label>
                                    <input type="text" class="form-control input-product" id="packaging" name='packaging'  data-type="number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Stock Minimo</label>
                                    <input type="text" class="form-control input-product" id="minimum_stock" name='minimum_stock'  data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Precio Sugerido</label>
                                    <input type="text" class="form-control input-product" id="pvp" name='pvp'  data-type="number">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email" class="control-label">Bodega</label>
                                   <select class="form-control input-product" id='warehouse' name="warehouse[]" data-api="/api/getWarehouseProduct" multiple>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">Imagenes</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="#">
                                    <img src="" alt="Image" id="imageMain"  width="20%">
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <button class="btn btn-success" type="button" id="modalImage"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                            </div>
                            <div class="col-lg-11">
                                <div class="row" id='contentImages'>
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