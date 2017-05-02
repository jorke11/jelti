{!! Form::open(['id'=>'frm']) !!}
<input id="id" name="id" type="hidden" class="input-user">
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Name:</label>
            <input type="text" class="form-control input-user" id="name" name='name' required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Last Name:</label>
            <input type="text" class="form-control input-user" id="last_name" name='last_name' required>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Document:</label>
            <input type="text" class="form-control input-user" id="document" name='document'>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Role:</label>
            <select id="role_id" name="role_id" class="form-control input-user" required>
                <option value="0">Seleccione</option>
                @foreach($profile as $rol)
                <option value="{{$rol->id}}">{{$rol->description}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">City:</label>
            <select id="city_id" name="city_id" class="form-control input-user" data-api="/api/getCity" required>
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
            <label for="email">Confirmation (password):</label>
            <input type="password" class="form-control input-user" id="confirmation" name='confirmation'>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control input-user" id="email" name='email' required>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group">
            <label for="email">Stakeholder:</label>
            <select id="stakeholder_id" name="stakeholder_id" class="form-control input-user" data-api="/api/getStakeholder" required>
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
{!!Form::close()!!}