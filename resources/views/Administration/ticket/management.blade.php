<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-7">
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
            {!! Form::open(['id'=>'frm']) !!}
            <div class="col-lg-12 col-lg-offset-4">
                <input type="hidden" id="id" name="id" class="input-ticket">                
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Department*</label>
                            <select class="form-control input-ticket"  id="client_id" name="client_id" data-api="/api/getClient">
                                <option value="0">Selection</option>
                                @foreach($depart as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Assigned*</label>
                            <select class="form-control input-ticket"  id="assigned_id" name="assigned_id">
                                <option value="0">Selection</option>
                                @foreach($user as $val)
                                <option value="{{$val->code}}">{{$val->name}} {{$val->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="last_name" class="control-label">Priority*</label>
                            <select class="form-control input-ticket"  id="priority_id" name="priority_id" data-api="/api/getClient">
                                <option value="0">Selection</option>
                                @foreach($priority as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="address" class="control-label">Subject</label>
                            <input class="form-control input-ticket" id="subject" name="subject">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="address" class="control-label">Description</label>
                            <textarea id="description" name="description" class="form-control input-ticket"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="address" class="control-label">Attach</label>
                            <input type="file" class="" id="attach" name="attach">
                        </div>
                    </div>
                </div>

            </div>
        </div>


        {!!Form::close()!!}
    </div>
</div>
