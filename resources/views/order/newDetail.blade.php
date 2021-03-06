<div class="modal fade" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Detail</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="order_id" name="order_id">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Product:</label>
                            <select class="form-control input-detail" id="product_id" name='product_id' data-api="/api/getProduct">
                                
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Category:</label>
                            <select class="form-control input-detail" id="category_id" name='category_id'>
                                @if(isset($mark))
                                @foreach($category as $cat)
                                <option value="{{$cat->id}}">{{$cat->description}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Quantity Max (<span id="quantityMax"></span>):</label>
                            <input type="text" class="form-control input-detail" id="quantity" name='quantity' min='0' disabled="" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail" id="value" name='value'>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">to Generate</label>
                            <input type="text" class="form-control input-detail" id="generate" name='generate' placeholder="Generate">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Total:</label>
                            <input type="text" class="form-control input-detail" id="total" name='total'>
                        </div>
                    </div>

                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
                <button type="button" class="btn btn-success" id='newDetail' disabled="">Save</button>
            </div>
        </div>
    </div>
</div>