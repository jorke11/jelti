<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button class="btn btn-success" id='new'>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <form id="frm">
                {!! Form::open(['id'=>'frm']) !!}
                <div class="row">
                    <input type="hidden" id="id" name="id" class="input-supplier">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="address">Type Persona</label>
                            <select class="form-control input-supplier"  id="type_regime_id" name="type_regime_id">
                                @foreach($type_person as $category)
                                <option value="{{$category->id}}">{{$category->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                            <label for="address">Type Regime</label>
                            <select id="type_person_id" name="type_person_id" class="form-control input-supplier">
                                @foreach($type_regimen as $category)
                                <option value="{{$category->id}}">{{$category->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control input-supplier" id="name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control  input-supplier" id="last_name" name="last_name" placeholder="Last Name">
                        </div>
                    </div>
                    

                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="address">Document</label>
                            <input type="text" class="form-control input-supplier" id="document" name="document" placeholder="Document">
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
                            <label for="address">Address</label>
                            <input type="text" class="form-control input-supplier" id="address" name="address" placeholder="Address">
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
                            <select class="form-control input-supplier"  id="city_id" name="city_id">
                                <option value="1">City</option>
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
