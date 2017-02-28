{!! Form::open(['id'=>'frm']) !!}
<input id="id" name="id" type="hidden" class="input-departure">
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Consecutive:</label>
            <input type="text" class="form-control input-departure" id="consecutive" name='consecutive' value="0001" readonly="">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Date:</label>
            <input type="text" class="form-control input-departure" id="created" name='created' value="<?php echo date("Y-m-d H:i") ?>" readonly="">
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Warehouse:</label>
            <select class="form-control input-departure" id="warehouse_id" name='warehouse_id' readonly>
                @if (isset($warehouse))
                @foreach($warehouse as $war)
                <option value="{{$war->id}}">{{$war->description}}</option>
                @endforeach
                @endif
            </select>

        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Responsable:</label>
            <select class="form-control input-departure" id="responsible_id" name='responsible_id' readonly>
                @if (isset($responsable))
                @foreach($responsable as $res)
                <option value="{{$res->id}}">{{$res->name}}</option>
                @endforeach
                @endif
            </select>

        </div>
    </div>

</div>
<div class="row">
     <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Destination:</label>
            <input type="text" class="form-control input-departure" id="destination" name='destination'>
        </div>
    </div>
     <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Address:</label>
            <input type="text" class="form-control input-departure" id="address" name='address'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Description:</label>
            <input type="text" class="form-control input-departure" id="description" name='description'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Order:</label>
            <input type="text" class="form-control input-departure" id="order" name='order'>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">List Detail</div>
                    <div class="col-lg-8 text-right">
                        <button class="btn btn-success" type="button" id="btnmodalDetail" disabled>
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
                            <th>Value</th>
                            <th>Expiration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div
    </div>
</div>


{!!Form::close()!!}