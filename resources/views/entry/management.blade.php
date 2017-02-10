{!! Form::open(['id'=>'frm']) !!}
<input id="id" name="id" type="hidden" class="input-entry">
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Consecutive:</label>
            <input type="text" class="form-control input-entry" id="consecutive" name='consecutive'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Date:</label>
            <input type="text" class="form-control input-entry" id="date" name='date'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Bill:</label>
            <input type="text" class="form-control input-entry" id="bill" name='bill'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Warehouse:</label>
            <input type="text" class="form-control input-entry" id="warehouse" name='warehouse'>
        </div>
    </div>
</div>
<div class="row">
   <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Responsable:</label>
            <input type="text" class="form-control input-entry" id="user_create_id" name='user_create_id'>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <table class="table table-bordered table-condensed" id="tblDetail">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Unidades</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody></tbody>

        </table>
    </div>
</div>


{!!Form::close()!!}