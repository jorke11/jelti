<div class="row">
    {!! Form::open(['id'=>'frmClient','file'=>true]) !!}
    <div class="col-lg-5 col-lg-offset-3">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnUploadClient'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
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

        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Results</div>
            <!-- Table -->
            <table class="table table-bordered" id="tblUpload">
                <thead>
                    <tr>
                        <th>Reason</th>
                        <th>Record</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>


    </div>
</div>

