<div class="modal fade" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Agrega Item</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" name="id" class="input-detail">
                <input type="hidden" id="departure_id" name="departure_id">
                <input type="hidden" id="rowItem">
                
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Product:</label>
                            <select class="form-control input-detail" id="product_id" name='product_id' data-api="/api/getProduct" required>
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Category:</label>
                            <select class="form-control input-detail input-sm" id="category_id">
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
                            <label for="email">Quantity <span id="quantityMax" style="color: red;"></span></label>
                            <input type="text" class="form-control input-detail input-sm" id="quantity" name='quantity' placeholder="Quantity" required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail input-sm" id="value" name='value' required readonly>
                        </div>
                    </div>

                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-success" id='newDetail'>Save</button>
            </div>
        </div>
    </div>
</div>