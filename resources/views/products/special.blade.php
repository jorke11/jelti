<br>
<div class="row">
    {!! Form::open(['id'=>'frmSpecial']) !!}
    <div class="col-lg-6">
        <div class="panel panel-info">
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Supplier</label>
                            <select class="form-control input-special input-sm" id="supplier_id" name="supplier_id" data-api="/api/getSupplier">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Price</label>
                            <input class="form-control input-sm" id="supplier_id" name="supplier_id" data-api="/api/getSupplier">             
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
    {!!Form::close()!!}
</div>
