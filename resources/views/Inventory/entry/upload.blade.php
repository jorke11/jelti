{!!Form::open(["id"=>"frmFile","file"=>true])!!}
<br>
<div class="row">
    <div class="col-lg-1">Warehouse</div>
    <div class="col-lg-2">
        <select class="form-control" id="warehouse_id" name="warehouse_id">
            @foreach($warehouse as $val)
            <option value="{{$val->id}}">{{$val->description}}</option>
            @endforeach
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-1">Responsible</div>
    <div class="col-lg-2">
        <select class="form-control" id="responsible_id" name="responsible_id">
            @foreach($users as $val)
            <option value="{{$val->id}}">{{$val->email}}</option>
            @endforeach
        </select>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-1">File</div>
    <div class="col-lg-1">
        <input id="file_excel" name="file_excel" type="file">
    </div>
</div>
<div class="row">
    <div class="col-lg-1">
        <button class="btn btn-success" id="btnUpload" type="button">Upload</button>

    </div>
</div>
{!!Form::close()!!}