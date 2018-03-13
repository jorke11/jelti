{!!Form::open(["id"=>"frmFile","file"=>true])!!}
<div class="row">
    <div class="col-lg-1">File</div>
    <div class="col-lg-1">
        <input id="file_excel" name="file_excel" type="file">
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <button class="btn btn-success" id="btnUpload" type="button">Upload</button>
    </div>
    <div class="col-lg-2">
        <a href="{{url("formats/upload_products.xlsx")}}" download="Formato.xlsx">
            Descargar Archivo
        </a>
    </div>
</div>
{!!Form::close()!!}

<div class="row">
    <div class="col-lg-8">
        <table class="table table-bordered" id="tblUpload">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Titulo</th>
                    <th>Precio</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>