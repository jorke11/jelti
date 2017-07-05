{!!Form::open(["id"=>"frmFileCode","file"=>true])!!}
<div class="row">
    <div class="col-lg-1">File</div>
    <div class="col-lg-1">
        <input id="client_id" name="client_id" type="hidden">
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
                    <th>Product</th>
                    <th>Ean</th>
                    <th>Sf Code</th>
                    <th>Item</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>