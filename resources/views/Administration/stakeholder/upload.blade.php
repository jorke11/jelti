<br>
<div class="row">
    {!! Form::open(['id'=>'frmExcel','file'=>true]) !!}
    <div class="col-lg-5 col-lg-offset-3">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnUploadExcel'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="id" name="id" class="input-special">
                <input type="hidden" id="client_id" name="client_id" class="input-special">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">File</label>
                            <input type="file" name="file_excel" name="file_excel">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>

