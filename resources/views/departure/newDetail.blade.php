<div class="modal fade" tabindex="-1" role="dialog" id='modalDetail'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Detail</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmDetail']) !!}
                <input type="hidden" id="id" name="id">
                <input type="hidden" id="departure_id" name="departure_id">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Supplier:</label>
                            <select class="form-control input-detail" id="supplier_id" name='supplier_id'>
                                @if(isset($responsable))
                                @foreach($responsable as $res)
                                <option value="{{$res->id}}">{{$res->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Mark:</label>
                            <select class="form-control input-detail" id="mark_id" name='mark_id'>
                                <option value="0">Seleccione</option>
                                @if(isset($mark))
                                @foreach($mark as $mar)
                                <option value="{{$mar->id}}">{{$mar->description}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Product:</label>
                            <select class="form-control input-detail" id="product_id" name='product_id'>
                                <option value="0">Seleccione</option>
                                @if(isset($product))
                                @foreach($product as $pro)
                                <option value="{{$pro->id}}">{{$pro->description}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Quantity:</label>
                            <input type="text" class="form-control input-detail" id="quantity" name='quantity' min='0'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Value:</label>
                            <input type="text" class="form-control input-detail" id="value" name='value'>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Lot:</label>
                            <input type="text" class="form-control input-detail" id="lot" name='lot'>
                        </div>
                    </div>
                </div>
                <div class="row">
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
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Expiration Date:</label>
                            <input type="text" class="form-control input-detail" id="expiration_date" value="">
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id='newDetail'>Save</button>
            </div>
        </div>
    </div>
</div>