<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Category</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm','files' => true]) !!}
                <input type="hidden" id="id" name="id" class="input-category">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description</label>
                            <input type="text" class="form-control input-category" id="description" name='description' required="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Short Description</label>
                            <input type="text" class="form-control input-category" id="short_description" name='short_description' required>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Tipo</label>
                            <select id="type_category_id" name="type_category_id" class="form-control input-category">
                                <option value="0">Selecciona</option>
                                @foreach($types as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Order</label>
                            <input type="text" class="form-control input-category" id="order" name='order' required>
                        </div>
                    </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Estado</label>
                            <input type="checkbox" class="form-control input-category" id="status_id" name='status_id'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Imagen</label>
                            <input type="file" class="form-control input-category" id="img" name='img'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#" class="thumbnail">
                            <img alt="" id="img_category">
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Banner</label>
                            <input type="file" class="form-control input-category" id="banner" name='banner'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#" class="thumbnail">
                            <img alt="" id="img_banner">
                        </a>
                    </div>
                </div>

                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='new'>Save</button>
            </div>
        </div>
    </div>
</div>