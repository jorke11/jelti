<div class="modal fade" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Detail</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" class="input-detail" name="id">
                <input type="hidden" id="purchase_id" class="input-detail" name="purchase_id">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Product:</label>
                            <select class="form-control input-detail input-sm" id="product_id" name='product_id' data-api="/api/getProduct" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Category:</label>
                            <select class="form-control input-detail input-sm" id="category_id" name='category_id' required>
                                <option value="0">Selection</option>
                                @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Expiration Date:</label>
                            <input size="16" type="text" name="expiration_date" id="expiration_date" value="<?php echo date("Y-m-d H:i") ?>" class="form_datetime input-detail input-sm form-control" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Lot:</label>
                            <input type="text" class="form-control input-detail input-sm" id="lot" name='lot' autofocus="" required>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Quantity:</label>
                            <input type="text" class="form-control input-detail input-sm" id="quantity" name='quantity' required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail input-sm" id="value" name='value'>
                        </div>
                    </div>

                </div>
                <div class="row">


                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='newDetail'>Save</button>
            </div>
        </div>
    </div>
</div>