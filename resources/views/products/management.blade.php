
<div class="panel panel-default">
    <div class="page-title" style="">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='new'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm','files' => true]) !!}
        <input id="id" name="id" type="hidden" class="input-product">
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Information</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Title:</label>
                                    <input type="text" class="form-control input-product input-sm" id="title" name='title'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Description:</label>
                                    <input type="text" class="form-control input-product input-sm" id="description" name='description'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Short Description:</label>
                                    <input type="text" class="form-control input-product input-sm" id="short_description" name='short_description'>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">Reference:</label>
                                    <input type="text" class="form-control input-product input-sm" id="reference" name='reference'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">category_id:</label>
                                    <select class="form-control input-product" id='category_id' name="category_id">
                                        @foreach($categories as $cate)
                                        <option value="{{$cate->id}}">{{$cate->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">supplier_id:</label>
                                    <select class="form-control input-product" id='supplier_id' name="supplier_id">
                                        @foreach($suppliers as $sup)
                                        <option value="{{$sup->id}}">{{$sup->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">status:</label>
                                    <input type="text" class="form-control input-product" id="status" name='status'>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">bar_code:</label>
                                    <input type="text" class="form-control input-product" id="bar_code" name='bar_code'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">url_part:</label>
                                    <input type="text" class="form-control input-product" id="url_part" name='url_part'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Meta</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">meta_title:</label>
                                    <textarea class="form-control input-product" id="meta_title" name='meta_title'>
                                    </textarea>                
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">meta_keywords:</label>
                                    <textarea class="form-control input-product" id="meta_keywords" name='meta_keywords'>
                                    </textarea> 
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">meta_description:</label>
                                    <textarea class="form-control input-product" id="meta_description" name='meta_description'>
                                    </textarea> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">minimun_stock:</label>
                                    <textarea class="form-control input-product" id="minimun_stock" name='minimun_stock'>
                                    </textarea> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Values</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">units_supplier:</label>
                                    <input type="text" class="form-control input-product" id="units_supplier" name='units_supplier'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">units_sf:</label>
                                    <input type="text" class="form-control input-product" id="units_sf" name='units_sf'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">cost_sf:</label>
                                    <input type="text" class="form-control input-product" id="cost_sf" name='cost_sf'>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">tax:</label>
                                    <input type="text" class="form-control input-product" id="tax" name='tax'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">price_sf:</label>
                                    <input type="text" class="form-control input-product"  id="price_sf" name='price_sf'>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="email">price_cust:</label>
                                    <input type="text" class="form-control input-product" id="price_cust" name='price_cust'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">Images</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="#">
                                    <img src="" alt="Image" id="imageMain"  width="20%">
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                                <button class="btn btn-success" type="button" id="modalImage"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                            </div>
                            <div class="col-lg-11">
                                <div class="row" id='contentImages'>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {!!Form::close()!!}
    </div>
</div>



@include('products.modalUpload')