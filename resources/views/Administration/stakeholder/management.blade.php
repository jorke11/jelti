<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-3 col-lg-offset-10">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Extra <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" onclick="obj.showModalJustif()">Enable / Disable</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <button class="btn btn-success btn-sm" id='btnNew'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> New</span>
                            </button>
                            <button class="btn btn-success btn-sm" id='btnSave'>
                                <span class="glyphicon glyphicon-ok" aria-hidden="true"> Save</span>
                            </button>
                        </div>

                    </div>




                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm','files' => true]) !!}
            <div class="row">
                <input type="hidden" id="id" name="id" class="input-stakeholder">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Type Persona*</label>
                        <select class="form-control input-stakeholder"  id="type_regime_id" name="type_regime_id" required>
                            <option value="0">Selection</option>
                            @foreach($type_person as $val)
                            <option value="{{$val->code}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Type Regime*</label>
                        <select id="type_person_id" name="type_person_id" class="form-control input-stakeholder" required>
                            <option value="0">Selection</option>
                            @foreach($type_regimen as $val)
                            <option value="{{$val->code}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="name" class="control-label">Name*</label>
                        <input type="text" class="form-control input-stakeholder" id="name" name="name" placeholder="Name" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="last_name" class="control-label">Last Name*</label>
                        <input type="text" class="form-control  input-stakeholder" id="last_name" name="last_name" placeholder="Last Name" required>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Type Document*</label>
                        <select id="type_document" name="type_document" class="form-control input-stakeholder" required>
                            <option value="0">Selection</option>
                            @foreach($type_document as $val)
                            <option value="{{$val->code}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Document*</label>
                        <input type="text" class="form-control input-stakeholder" id="document" name="document" placeholder="Document" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Verification</label>
                        <input type="text" class="form-control input-stakeholder" id="verification" name="verification" placeholder="verification">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Phone</label>
                        <input type="text" class="form-control input-stakeholder" id="phone" name="phone" placeholder="Phone">
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">email</label>
                        <input type="text" class="form-control input-stakeholder" id="email" name="email" placeholder="Email">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Address*</label>
                        <input type="text" class="form-control input-stakeholder" id="address" name="address" placeholder="Address" required>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Term</label>
                        <input type="text" class="form-control input-stakeholder" id="term" name="term" placeholder="Term">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">City</label>
                        <select class="form-control input-stakeholder"  id="city_id" name="city_id" data-api="/api/getCity">
                        </select>
                    </div>
                </div>


            </div>
            <div class="row">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Contact</label>
                        <input type="text" class="form-control input-stakeholder" id="contact" name="contact" placeholder="Contact">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Phone Contact</label>
                        <input type="text" class="form-control input-stakeholder" id="phone_contact" name="phone_contact" placeholder="Phone Contact">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Business</label>
                        <input type="text" class="form-control input-stakeholder" id="business" name="business" placeholder="Bussines">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Business name</label>
                        <input type="text" class="form-control input-stakeholder" id="business_name" name="business_name" placeholder="Bussines Name">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address">Web Site</label>
                        <input type="text" class="form-control input-stakeholder" id="web_site" name="web_site" placeholder="Web site">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Responsible</label>
                        <select class="form-control input-stakeholder"  id="responsible_id" name="responsible_id" data-api="/api/getResponsable" required>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Stakeholder type</label>
                        <select id="type_stakeholder" name="type_stakeholder" class="form-control input-stakeholder" required>
                            <option value="0">Selection</option>
                            @foreach($type_stakeholder as $val)
                            <option value="{{$val->code}}">{{$val->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="address" class="control-label">Contract Expiration</label>
                        <input type="datetime" class="form-control input-stakeholder" id="contract_expiration" name="contract_expiration" placeholder="contract_expiration Name" 
                               value="{{date("Y-m-d H:i")}}">
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
            <div class="row">
                <div class="col-lg-1">
                    <button class="btn btn-success" type="button" id="modalImage"><i class="fa fa-cloud-upload" aria-hidden="true"></i></button>
                </div>
                <div class="col-lg-5">
                    <div class="row" i>
                        <table class="table table-condensed table-striped" id="contentAttach">
                            <thead>
                                <tr>
                                    <th>Document</th>
                                    <th>File</th>
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


<div class="modal fade" tabindex="-1" role="dialog" id="modelActive">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Enable / Disabled</h4>
            </div>
            <div class="modal-body">
                <form id="frmJustify">
                    <input class="input-justify" type="hidden" id="stakeholder_id" name="stakeholder_id">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Status</label>
                                <select id="status_id" name="status_id" class="form-control input-justify" required>
                                    <option value="0">Selection</option>
                                    @foreach($status as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Justification</label>
                                <textarea class="form-control input-justify" name="justification" id="justification" required></textarea>
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="addJustify">Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>


@include('Administration.stakeholder.modalUpload')
