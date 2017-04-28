
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
                            <label for="email">Type StakeHolder</label>
                            <select class="form-control" id="typestakeholder" name="typestakeholder">
                                <option value="0">Selection</option>
                                @foreach($type_stakeholder as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
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
<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered" id="tblUpload">
            <thead>
                <tr>
                    <th>Business</th>
                    <th>Business Name</th>
                    <th>document</th>
                    <th>contact</th>
                    <th>Telefono contact</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

