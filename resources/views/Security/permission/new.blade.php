<div class="modal fade" tabindex="-1" role="dialog" id='modalNew'>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">New Products</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm','route'=>'permission.store']) !!}
                <input type="hidden" id="permission_id" name="permission_id">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Type Option:</label>
                            <select  class="form-control input-user" id="typemenu_id" name='typemenu_id'>
                                <option value="0">Main</option>
                                <option value="1">Submain</option>
                                <option value="2">Form</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row hidden" id="fieldParent">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Parent:</label>
                            <select class="form-control input-user" id="parent_id" name='parent_id'>
                            </select>
                        </div>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description:</label>
                            <input type="text" class="form-control input-user" id="description" name='description'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Controller:</label>
                            <input type="text" class="form-control input-user" id="controller" name='controller'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Title:</label>
                            <input type="text" class="form-control input-user" id="title" name='title'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Alternative:</label>
                            <input type="text" class="form-control input-user" id="alternative" name='alternative'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Event:</label>
                            <input type="checkbox" class="form-control input-user" id="event" name='event'>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id='new'>Save</button>
            </div>
        </div>
    </div>
</div>