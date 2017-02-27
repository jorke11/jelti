<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSend'>
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
       
        {!! Form::open(['id'=>'frm']) !!}
        
        <input id="id" name="id" type="hidden" class="input-order">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutive:</label>
                    <input type="text" class="form-control input-order" id="consecutive" name='consecutive' value="0001">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-order" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-order input-sm" id="responsable_id" name='responsable_id' readonly data-api="/api/getResponsable">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Origin:</label>
                    <select class="form-control input-order" id="city_id" name='city_id' width="100%" data-api="/api/getCity">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Destination:</label>
                    <select class="form-control input-order" id="destination_id" name='destination_id' data-api="/api/getCity">
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Status:</label>
                    <select class="form-control input-order input-sm" id="status_id" name='status_id' readonly>
                        <option value="1">New</option>
                        <option value="1">Partial</option>
                        <option value="3">Created</option>
                        <option value="4">Closed</option>
                        <option value="5">Canceled</option>
                    </select>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="text" class="form-control input-order form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Client:</label>
                    <select class="form-control input-order" id="client_id" name='client_id' data-api="/api/getSupplier">
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Name or Business name :</label>
                    <input type="text" class="form-control input-order input-sm" id="name_client" readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Address:</label>
                    <input type="text" class="form-control input-order input-sm" id="address" name="address">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-order input-sm" id="phone" name="phone">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Branch office:</label>
                    <select class="form-control input-order" id="branch_id" name='branch_id' data-api="/api/getSupplier">
                    </select>
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
                        <button class="btn btn-success btn-sm" type="button" id="btnmodalDetail" disabled>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed" id="tblDetail">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Mark</th>
                            <th>Quantity</th>
                            <th>Generate</th>
                            <th>Value</th>
                            <th>Expiration</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



