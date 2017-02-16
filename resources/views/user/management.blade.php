{!! Form::open(['id'=>'frm']) !!}
<input id="id" name="id" type="hidden" class="input-product">
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Name:</label>
            <input type="text" class="form-control input-user" id="name" name='name'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control input-user" id="email" name='email'>
        </div>
    </div>
    
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Supplier:</label>
            <select id="supplier_id" name="supplier_id" class="form-control input-user">
                <option value="0">Seleccione</option>
                @foreach($supplier as $pro)
                <option value="{{$pro->id}}">{{$pro->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Status</label>
            <input type="checkbox" class="form-control input-user" id="status" name='status'>
        </div>
    </div>
</div>
{!!Form::close()!!}