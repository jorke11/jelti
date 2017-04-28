@extends('layouts.dash')
@section('content')
{!! Form::open(['id'=>'frm']) !!}
<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnSave' type="button">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <br>
        <div class="alert alert-success"><h4>Bienvenido, Por favor ingresa tus datos personales</h4></div>
        <input id="id" name="id" type="hidden" class="input-user" value="{{$users->id}}">
        <input type="checkbox" class="form-control hidden" id="status_id" name='status_id' checked readonly="">
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
                    <label for="email">Email:</label>
                    <input type="text" class="form-control input-user" id="email" name='email' value="{{$users->email}}" required readonly="">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Role:</label>
                    <select id="role_id" name="role_id" class="form-control input-user" required readonly>
                        <option value="0">Seleccione</option>
                        @foreach($roles as $rol)
                        <option value="{{$rol->id}}" <?php echo ($rol->id == $users->role_id) ? 'selected' : '' ?>>{{$rol->description}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Warehouse:</label>
                    <select id="warehouse_id" name="warehouse_id" class="form-control input-user" data-api="/api/getWarehouse">
                    </select>
                </div>
            </div>
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
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Document:</label>
                    <input type="text" class="form-control input-user" id="document" name='document'>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="email">Stakeholder:</label>
                    <select id="stakeholder_id" name="stakeholder_id" class="form-control input-user" data-api="/api/getStakeholder" required>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}

{!!Html::script('js/Security/Activation.js')!!}
@endsection