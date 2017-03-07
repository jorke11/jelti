<div class="panel panel-default">
    <div class="page-title" style="height: 0;">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave' disabled>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" ></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSend' disabled>
                    <span class="glyphicon glyphicon-send" aria-hidden="true" ></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id" name="id" type="hidden" class="input-entry">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutive:</label>
                    <input type="text" class="form-control input-entry input-sm" id="id" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-entry" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-entry input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City:</label>
                    <select class="form-control input-entry" id="city_id" name='city_id' width="100%" data-api="/api/getCity">
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Status:</label>
                    <select class="form-control input-entry" id="status_id" name="status_id">
                        <option value="0">Selection</option>
                        <option value="1">New</option>
                        <option value="2">Pending</option>
                        <option value="3">validate</option>
                        <option value="4">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="text" class="form-control input-entry input-sm form_datetime input-fillable" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" readonly="">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Supplier:</label>
                    <select class="form-control input-entry" id="supplier_id" name='supplier_id' data-api="/api/getSupplier">
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Name or Business name :</label>
                    <input type="text" class="form-control input-entry input-sm" id="name_supplier" placeholder="Name or Business name" readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Address:</label>
                    <input type="text" class="form-control input-entry input-sm" id="address_supplier" placeholder="Address" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-entry input-sm" id="phone_supplier"  placeholder="Phone" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Invoice:</label>
                    <input type="text" class="form-control input-entry input-sm input-fillable" id="invoice" name='invoice' placeholder="invoice" readonly>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Description:</label>
                    <input type="text" class="form-control input-entry input-sm input-fillable" id="description" name='description' placeholder="Description" readonly>
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
                            <th>Product</th>
                            <th>Expiration</th>
                            <th>Quantity</th>
                            <th>Value</th>
                            <th>Total</th>
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


