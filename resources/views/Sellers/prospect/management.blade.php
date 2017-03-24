<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button class="btn btn-success btn-sm" id='btnNew'>
                        <span class="glyphicon glyphicon-plus" aria-hidden="true">New</span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnSave' disabled>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true">Save</span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnConvert' disabled>
                        <span class="glyphicon glyphicon-retweet" aria-hidden="true">Convert</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm']) !!}
            <div class="row">
                <input type="hidden" id="id" name="id" class="input-prospect">                

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" class="form-control input-prospect" id="name" name="name" placeholder="Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name*</label>
                        <input type="text" class="form-control  input-prospect" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Business*</label>
                        <input type="text" class="form-control  input-prospect" id="business" name="business" placeholder="business" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Business Name*</label>
                        <input type="text" class="form-control  input-prospect" id="business_name" name="business_name" placeholder="Business name" required>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Email</label>
                        <input type="text" class="form-control  input-prospect" id="position" name="email" placeholder="email">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Position</label>
                        <input type="text" class="form-control  input-prospect" id="position" name="position" placeholder="position">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Phone</label>
                        <input type="text" class="form-control  input-prospect" id="phone" name="phone" placeholder="phone">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Web Site</label>
                        <input type="text" class="form-control input-prospect" id="web_site" name="web_site" placeholder="web site">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Status Prospect</label>
                        <select id="sector_id" name="sector_id" class="form-control input-prospect">
                            <option value="0">Selection</option>
                            <option value="1">Contactado</option>
                            <option value="2">No Contactado</option>
                            <option value="3">Sin respuesta</option>
                            <option value="4">Contactado, interesado portafolio</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Source Prospect</label>
                        <select id="sector_id" name="sector_id" class="form-control input-prospect">
                            <option value="0">Selection</option>
                            <option value="1">Chat</option>
                            <option value="2">Correo</option>
                            <option value="3">Feria</option>
                            <option value="4">Otro</option>
                            <option value="5">Pagina web</option>
                            <option value="6">Recomendación externa</option>
                            <option value="7">Redes sociales</option>
                            <option value="8">Referido de proveedor</option>
                            <option value="9">Vendedor</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Sector</label>
                        <select id="sector_id" name="sector_id" class="form-control input-prospect">
                            <option value="0">Selection</option>
                            <option value="1">Aerolineas</option>
                            <option value="2">Centros de salud</option>
                            <option value="3">Centros deportivos</option>
                            <option value="4">Colegios y universidades</option>
                            <option value="5">Empresas</option>
                            <option value="6">Grandes superficies</option>
                            <option value="7">Horeca</option>
                            <option value="8">Tiendas especializadas</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">City</label>
                        <select class="form-control input-prospect"  id="city_id" name="city_id" data-api="/api/getCity">
                        </select>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">ID skype</label>
                        <input type="text" class="form-control input-prospect" id="id_skype" name="id_skype" placeholder="skype">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">ID twitter</label>
                        <input type="text" class="form-control input-prospect" id="id_skype" name="id_skype" placeholder="@user">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Commecial</label>
                        <select class="form-control input-prospect"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <input type="text" class="form-control input-prospect" id="address" name="address" placeholder="address">
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
