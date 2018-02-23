<div class="row">
    <div class="panel panel-default">
        <div class="page-title">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-8">
                    <button class="btn btn-success btn-sm" id='btnNew'>
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnSave'>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    </button>
                    <button class="btn btn-success btn-sm" id='btnComment'>
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['id'=>'frm','file'=>true]) !!}
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                    <input type="hidden" id="id" name="id" class="input-ticket">                
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Status*</label>
                                <select class="form-control input-ticket input-sm"  id="status_id" name="status_id">
                                    @foreach($status as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Department*</label>
                                <select class="form-control input-ticket input-sm"  id="department_id" name="department_id">
                                    <option value="0">Selection</option>
                                    @foreach($depart as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Assigned*</label>
                                <select class="form-control input-ticket input-sm"  id="assigned_id" name="assigned_id">
                                    <option value="0">Selection</option>
                                    @foreach($user as $val)
                                    <option value="{{$val->id}}">{{$val->name}} {{$val->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Priority*</label>
                                <select class="form-control input-ticket input-sm"  id="priority_id" name="priority_id" data-api="/api/getClient">
                                    <option value="0">Selection</option>
                                    @foreach($priority as $val)
                                    <option value="{{$val->code}}">{{$val->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Subject</label>
                                <input class="form-control input-ticket input-sm" id="subject" name="subject">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="address" class="control-label">Description</label>
                                <textarea id="description" name="description" class="form-control input-ticket input-sm"></textarea>
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
        </div>


        {!!Form::close()!!}
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row row-center">
                <div class="col-lg-6  col-lg-offset-3">
                    <table class="table table-condensed table-bordered" id="tblComment">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Comment</td>
                                <td>Fecha</td>
                                <td>Accion</td>
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


<div class="modal fade" role="dialog" id="modalComment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add comment</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmComment']) !!}
                <input type="hidden" id="ticket_id" name="ticket_id" class="input-detail">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="address" class="control-label">Comment</label>
                            <textarea id="comment" name="comment" class="form-control input-detail input-sm"></textarea>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnCommentSave">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->