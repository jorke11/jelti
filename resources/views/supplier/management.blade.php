<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button class="btn btn-success btn-sm" id='btnNew'>
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnSave'>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm','files' => true]) !!}
            <div class="row">
                <input type="hidden" id="id" name="id" class="input-supplier">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Type Persona*</label>
                        <select class="form-control input-supplier"  id="type_regime_id" name="type_regime_id" required>
                            <option value="0">Selection</option>
                            @foreach($type_person as $category)
                            <option value="{{$category->id}}">{{$category->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Type Regime*</label>
                        <select id="type_person_id" name="type_person_id" class="form-control input-supplier" required>
                            <option value="0">Selection</option>
                            @foreach($type_regimen as $category)
                            <option value="{{$category->id}}">{{$category->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" class="form-control input-supplier" id="name" name="name" placeholder="Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name*</label>
                        <input type="text" class="form-control  input-supplier" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Document*</label>
                        <input type="text" class="form-control input-supplier" id="document" name="document" placeholder="Document" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Phone</label>
                        <input type="text" class="form-control input-supplier" id="phone" name="phone" placeholder="Phone">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">email</label>
                        <input type="text" class="form-control input-supplier" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Address*</label>
                        <input type="text" class="form-control input-supplier" id="address" name="address" placeholder="Address" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Term</label>
                        <input type="text" class="form-control input-supplier" id="term" name="term" placeholder="Term">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">City</label>
                        <select class="form-control input-supplier"  id="city_id" name="city_id" data-api="/api/getCity">
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Web Site</label>
                        <input type="text" class="form-control input-supplier" id="web_site" name="web_site" placeholder="Web site">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Contact</label>
                        <input type="text" class="form-control input-supplier" id="contact" name="contact" placeholder="Contact">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Phone Contact</label>
                        <input type="text" class="form-control input-supplier" id="phone_contact" name="phone_contact" placeholder="Phone Contact">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Business name</label>
                        <input type="text" class="form-control input-supplier" id="bussines_name" name="bussines_name" placeholder="Bussines Name">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Commecial</label>
                        <select class="form-control input-supplier"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                        </select>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
            <div class="row">
                <div class="col-lg-1">
                    <button class="btn btn-success" type="button" id="modalImage"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                </div>
                <div class="col-lg-3">
                    <div class="row" i>
                        <table class="table table-condensed table-striped" id="contentAttach">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>See</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@include('supplier.modalUpload')
