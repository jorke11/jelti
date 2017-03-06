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
                            <label for="email">Product</label>
                            <select class="form-control input-special input-sm" id="product_id" name="product_id" data-api="/api/getProduct">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">price_sf</label>
                            <input class="form-control input-special input-sm" id="price_sf" name="price_sf">             
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">margin</label>
                            <input class="form-control input-special input-sm" id="margin" name="margin">    
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">margin_sf</label>
                            <input class="form-control input-special input-sm" id="margin_sf" name="margin_sf">    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">tax</label>
                            <input class="form-control input-sm input-special" id="tax" name="tax">    
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Reset All</label>
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
                                    <th>Client</th>
                                    <th>Product</th>
                                    <th>price_sf</th>
                                    <th>margin</th>
                                    <th>margin_sf</th>
                                    <th>tax</th>
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
