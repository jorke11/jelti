{!! Form::open(['id'=>'frm']) !!}
<input id="id" name="id" type="hidden" class="input-user">
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
            <select id="supplier_id" name="supplier_id" class="form-control input-user" data-api="/api/getSupplier">
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Status</label>
            <input type="checkbox" class="form-control" id="status" name='status'>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">City:</label>
            <select id="city_id" name="city_id" class="form-control input-user" data-api="/api/getCity">
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Role:</label>
            <select id="profile_id" name="profile_id" class="form-control input-user">
                <option value="0">Seleccione</option>
                @foreach($profile as $rol)
                <option value="{{$rol->id}}">{{$rol->description}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Password:</label>
            <input type="password" class="form-control input-user" id="password" name='password'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Confirmation:</label>
            <input type="password" class="form-control input-user" id="confirmation" name='confirmation'>
        </div>
    </div>
</div>
{!!Form::close()!!}