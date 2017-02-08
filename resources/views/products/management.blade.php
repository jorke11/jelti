{!! Form::open(['id'=>'frm','route'=>'products.store']) !!}
    <input id="id" name="id" type="hidden">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">Title:</label>
                <input type="text" class="form-control" id="title" name='title'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">Description:</label>
                <input type="text" class="form-control" id="description" name='description'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">Short Description:</label>
                <input type="text" class="form-control" id="short_description" name='short_description'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">Reference:</label>
                <input type="text" class="form-control" id="reference" name='reference'>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">units_supplier:</label>
                <input type="text" class="form-control" id="units_supplier" name='units_supplier'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">units_sf:</label>
                <input type="text" class="form-control" id="units_sf" name='units_sf'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">cost_sf:</label>
                <input type="text" class="form-control" id="cost_sf" name='cost_sf'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">tax:</label>
                <input type="text" class="form-control" id="tax" name='tax'>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">price_sf:</label>
                <input type="text" class="form-control" id="units_supplier" name='units_supplier'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">price_cust:</label>
                <input type="text" class="form-control" id="price_cust" name='price_cust'>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">categories_id:</label>
                <select class="form-control" id='categories_id' name="categories_id">
                    @foreach($categories as $cate)
                    <option value="{{$cate->id}}">{{$cate->description}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">supplier_id:</label>
                <select class="form-control" id='supplier_id' name="supplier_id">
                    @foreach($suppliers as $sup)
                    <option value="{{$sup->id}}">{{$sup->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">url_part:</label>
                <input type="text" class="form-control" id="url_part" name='url_part'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">bar_code:</label>
                <input type="text" class="form-control" id="bar_code" name='bar_code'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">status:</label>
                <input type="text" class="form-control" id="status" name='status'>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">meta_title:</label>
                <input type="text" class="form-control" id="meta_title" name='meta_title'>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">meta_keywords:</label>
                <input type="text" class="form-control" id="meta_keywords" name='meta_keywords'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">meta_description:</label>
                <input type="text" class="form-control" id="meta_description" name='meta_description'>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label for="email">minimun_stock:</label>
                <input type="text" class="form-control" id="minimun_stock" name='minimun_stock'>
            </div>
        </div>
    </div>
{!!Form::close()!!}