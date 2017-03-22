<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button class="btn btn-success btn-sm" id='btnNew'>
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnSave' disabled>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm','files' => true]) !!}
            <div class="row">
                <input type="hidden" id="id" name="id" class="input-contact">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" class="form-control input-contact" id="name" name="name" placeholder="Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name*</label>
                        <input type="text" class="form-control  input-contact" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Position*</label>
                        <input type="text" class="form-control  input-contact" id="position" name="position" placeholder="Position">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Address*</label>
                        <input type="text" class="form-control input-contact" id="address" name="address" placeholder="Address" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Phone</label>
                        <input type="text" class="form-control input-contact" id="phone" name="phone" placeholder="Phone">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">mobile</label>
                        <input type="text" class="form-control input-contact" id="mobile" name="mobile" placeholder="mobile">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">email</label>
                        <input type="text" class="form-control input-contact" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">birth Date</label>
                        <input type="datetime" class="form-control input-contact" id="birth_date" name="birth_date" placeholder="birth date" 
                               value="{{date("Y-m-d H:i")}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Stakeholder</label>
                        <select class="form-control input-contact"  id="stakeholder_id" name="stakeholder_id" data-api="/api/getSupplier" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">City</label>
                        <select class="form-control input-contact"  id="city_id" name="city_id" data-api="/api/getCity">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Commecial</label>
                        <select class="form-control input-contact"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Web Site</label>
                        <input type="text" class="form-control input-contact" id="web_site" name="web_site" placeholder="Web site">
                    </div>
                </div>

            </div>
            {!!Form::close()!!}
        </div>

    </div>
</div>
