<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> New</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave' disabled>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" > Save</span>
                </button>
                @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 1)
                <button class="btn btn-success btn-sm" id='btnSend'>
                    <span class="glyphicon glyphicon-send" aria-hidden="true"> Send</span>
                </button>

                <button class="btn btn-success btn-sm" id='btnDocument'>
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"> Pdf</span>
                </button>
                @endif
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        <input id="id_orderext" type="hidden" value="{{isset($id)?$id:''}}">
        <input id="id" name="id" type="hidden" class="input-departure">
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Consecutive:</label>
                    <input type="text" class="form-control input-departure" id="consecutive" name='consecutive' value="0001" readonly="">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select class="form-control input-departure" id="warehouse_id" name='warehouse_id' data-api="/api/getWarehouse" required="">
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Responsable:</label>
                    <select class="form-control input-departure input-sm" id="responsible_id" name='responsible_id' readonly data-api="/api/getResponsable" required>
                    </select>

                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Origin:</label>
                    <select class="form-control input-departure" id="city_id" name='city_id' width="100%" data-api="/api/getCity" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Date:</label>
                    <input type="text" class="form-control input-departure form_datetime input-fillable" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" required>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Status:</label>
                    <select class="form-control input-departure input-sm" id="status_id" name='status_id' readonly required>
                        @foreach($status as $val)
                        <option value="{{$val->id}}">{{$val->description}}</option>
                        @endforeach
                    </select>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">City Destination:</label>
                    <select class="form-control input-departure input-fillable" id="destination_id" name='destination_id' data-api="/api/getCity" required>
                    </select>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Client:</label>
                    <select class="form-control input-departure input-fillable" id="client_id" name='client_id' data-api="/api/getClient" required> 
                    </select>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="email">Name or Business name :</label>
                    <input type="text" class="form-control input-departure input-sm" id="name_client" readonly="">
                </div>
            </div>

            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Address:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="address" name="address" required>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input type="text" class="form-control input-departure input-sm input-fillable" id="phone" name="phone" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Branch office:</label>
                    <select class="form-control input-departure input-fillable" id="branch_id" name='branch_id' data-api="/api/getBranch" required>
                    </select>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="email">Invoice generated:</label>
                    <input type="text" class="form-control input-departure" id="invoice_generated" readonly>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>


<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
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
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>


