<br>
<div class="row">
    {!! Form::open(['id'=>'frmSpecial']) !!}
    <div class="col-lg-7 col-lg-offset-2">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnNewSpecial'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id='btnSaveSpecial'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="id" name="id" class="input-special">
                <input type="hidden" id="client_id" name="client_id" class="input-special">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Producto</label>
                            <select class="form-control input-special input-sm" id="product_id" name="product_id" data-api="/api/getProduct" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Precio </label>
                            <input class="form-control input-special input-sm" id="price_sf" name="price_sf" required data-type="number">             
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Margen</label>
                            <input class="form-control input-special input-sm" id="margin" name="margin" data-type="number" required>    
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Margen sf</label>
                            <input class="form-control input-special input-sm" id="margin_sf" name="margin_sf" data-type="number" required>    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Iva</label>
                            <input class="form-control input-sm input-special" id="tax" name="tax" data-type="number" maxlength="4" required>    
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Reiniciar Todo</label>
                            <input type="checkbox" class="form-control input-sm input-special" id="reset">    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-lg-offset-2">
        <div class="panel panel-info">
            <div class="page-title" style="">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover table-striped" id="tblSpecial">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Referencia</th>
                                    <th>price_sf</th>
                                    <th>margen</th>
                                    <th>margen_sf</th>
                                    <th>Iva</th>
                                    <th>all</th>
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
    {!!Form::close()!!}

</div>
