<div class="panel panel-default">
    <div class="page-title" style="height: 0;">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> New</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave' disabled>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" > Save</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSend' disabled>
                    <span class="glyphicon glyphicon-send" aria-hidden="true" > Send</span>
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
                    <input type="text" class="form-control input-entry input-sm" id="consecutive" readonly="" name="consecutive">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-entry" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse" required>
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-entry input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable" required>
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City:</label>
                    <select class="form-control input-entry" id="city_id" name='city_id' width="100%" data-api="/api/getCity" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Status:</label>
                    <select class="form-control input-entry" id="status_id" name="status_id" required>
                        @foreach($status as $val)
                        <option value="{{$val->code}}">{{$val->description}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="datetime" class="form-control input-entry input-sm form_datetime" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" readonly="">
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Supplier:</label>
                    <select class="form-control input-entry" id="supplier_id" name='supplier_id' data-api="/api/getSupplier" required>
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
                    <input type="text" class="form-control input-entry input-sm" id="address_supplier" placeholder="Address">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-entry input-sm" id="phone_supplier"  placeholder="Phone">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Invoice:</label>
                    <input type="text" class="form-control input-entry input-sm input-fillable" id="invoice" name='invoice' placeholder="invoice" required>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Purchase(Order):</label>
                    <select class="form-control input-sm" id="purchase_id" name="purchase_id" required>
                        <option value="0">Selection</option>
                    </select>
                </div>
            </div>
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
                            <th colspan="4" class="center-rowspan">Information</th>
                            <th colspan="3" class="center-rowspan">Order</th>
                            <th colspan="3" class="center-rowspan">Real</th>
                            <th rowspan="2" class="center-rowspan">Status</th>
                            <th rowspan="2" class="center-rowspan">Actions</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Comment</th>
                            <th>Expiration</th>
                            <th>Quantity</th>
                            <th>Value</th>
                            <th>Total</th>
                            <th>Quantity</th>
                            <th>Value</th>
                            <th>Total</th>

                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div
    </div>
</div>
</div>


