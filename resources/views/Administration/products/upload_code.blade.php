{!!Form::open(["id"=>"frmFileCode","file"=>true])!!}
<div class="row">
    <div class="col-lg-1">File</div>
    <div class="col-lg-1">
        <input id="file_excel" name="file_excel" type="file">
    </div>
</div>
<div class="row">
    <div class="col-lg-1">
        <button class="btn btn-success" id="btnUpload_code" type="button">Upload</button>

    </div>
</div>
{!!Form::close()!!}

<div class="row">
    <div class="col-lg-8">
        <table class="table table-bordered" id="tblUpload">
            <thead>
                <tr>
                    <th>Bar Code</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>contact</th>
                    <th>Telefono contact</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>