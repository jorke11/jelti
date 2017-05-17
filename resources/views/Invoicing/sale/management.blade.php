<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> New</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true"> Save</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnChecked'>
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"> Check</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id" name="id" type="hidden" class="input-sale">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutive:</label>
                    <input type="text" class="form-control input-sale" id="consecutive" name='consecutive' value="0001" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-sale" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsible:</label>
                    <select class="form-control input-sale input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Origin:</label>
                    <select class="form-control input-sale" id="city_id" name='city_id' width="100%" data-api="/api/getCity">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="datetime" class="form-control input-sale" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Status:</label>
                    <select class="form-control input-departure input-sm" id="status_id" name='status_id' readonly>
                        <option value="1">New</option>
                        <option value="2">Created</option>
                        <option value="3">Closed</option>
                        <option value="4">Canceled</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Destination:</label>
                    <select class="form-control input-sale" id="destination_id" name='destination_id' data-api="/api/getCity">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Client:</label>
                    <select class="form-control input-sale" id="client_id" name='client_id' data-api="/api/getSupplier">
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Name or Business name :</label>
                    <input type="text" class="form-control input-sale input-sm" id="name_client" readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Address:</label>
                    <input type="text" class="form-control input-sale input-sm" id="address" name="address">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-sale input-sm" id="phone" name="phone">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
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
                                    <th>Description</th>
                                    <th>Product</th>
                                    <th>Tax</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
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


        {!!Form::close()!!}
    </div>
</div>
</div>