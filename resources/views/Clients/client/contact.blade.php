<div class="row">
    {!! Form::open(['id'=>'frmContact','files' => true]) !!}
    <div class="col-lg-7 col-lg-offset-2">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnNewContact'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id='btnSaveContact'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="id" name="id" class="input-special">
                <input type="hidden" id="client_id" name="client_id" class="input-special">
                <div class="row">
                    <input type="hidden" id="id" name="id" class="input-contact">
                    <input type="hidden" id="stakeholder_id" name="stakeholder_id" class="input-contact">

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Nombre *</label>
                            <input type="text" class="form-control input-contact input-sm" id="name" name="name" placeholder="Name" required disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Apellido *</label>
                            <input type="text" class="form-control  input-contact input-sm" id="last_name" name="last_name" placeholder="Last Name" required disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Cargo *</label>
                            <input type="text" class="form-control  input-contact input-sm" id="position" name="position" placeholder="Position" disabled>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address" class="control-label">Dirección *</label>
                            <input type="text" class="form-control input-contact input-sm" id="address" name="address" placeholder="Address" required>
                        </div>
                    </div>
                </div>        

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Telefono</label>
                            <input type="text" class="form-control input-contact input-sm" id="phone" name="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Celular</label>
                            <input type="text" class="form-control input-contact input-sm" id="mobile" name="mobile" placeholder="mobile">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Correo</label>
                            <input type="text" class="form-control input-contact input-sm" id="email" name="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address" class="control-label">Fecha de Cumpleaños</label>
                            <input type="datetime" class="form-control input-contact input-sm" id="birth_date" name="birth_date" placeholder="birth date" 
                                   value="<?php echo date("Y-m-d H:i"); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Ciudad</label>
                            <select class="form-control input-contact input-sm"  id="city_id" name="city_id" data-api="/api/getCity">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="address">Sitio Web</label>
                            <input type="text" class="form-control input-contact input-sm" id="web_site" name="web_site" placeholder="Web site">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!!Form::close()!!}
    </div>
</div>





<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <table class="table table-condensed table-bordered" id="tblContact" width='100%'>
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Ciudad</th>
                            <th>Correo</th>
                            <th>Celular</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
