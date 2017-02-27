<div class="panel panel-default">
    <div class="page-title" style="height: 0;">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id" name="id" type="hidden" class="input-purchage">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutive:</label>
                    <input type="text" class="form-control input-purchage input-sm" id="id" name='id' readonly="">
                </div>
            </div>


            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-purchage" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse">
                    </select>
                    <!--<select class="form-control input-purchage" id="supplier_id" name='supplier_id' data-api="/api/getSupplier">-->
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-purchage input-sm" id="responsable_id" name='responsable_id' readonly data-api="/api/getResponsable">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="text" class="form-control input-purchage input-sm form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" >
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Avoice:</label>
                    <input type="text" class="form-control input-purchage input-sm" id="avoice" name='avoice'>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Description:</label>
                    <input type="text" class="form-control input-purchage input-sm" id="description" name='description'>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City:</label>
                    <select class="form-control input-purchage" id="city_id" name='city_id' data-api="/api/getCity">                  
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Supplier:</label>
                    <select class="form-control input-purchage" id="supplier_id" name='supplier_id' data-api="/api/getSupplier">
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Name or Business name :</label>
                    <input type="text" class="form-control input-purchage input-sm" id="name_supplier" readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Address:</label>
                    <input type="text" class="form-control input-purchage input-sm" id="address_supplier" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-purchage input-sm" id="phone_supplier" readonly="">
                </div>
            </div>


        </div>

        {!!Form::close()!!}
    </div>
</div>

<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">List Detail</div>
                    <div class="col-lg-8 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnmodalCont">
                            <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id="btnmodalDetail" disabled>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed table-hover" id="tblDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Description</th>
                            <th>Account</th>
                            <th>Product</th>
                            <th>Expiration</th>
                            <th>Tax</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Debt</th>
                            <th>Credit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div
    </div>
</div>


