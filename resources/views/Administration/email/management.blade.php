<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" id='btnNew'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true">New</span>
                        </button>
                        <button class="btn btn-success btn-sm" id='btnSave'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true">Save</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-email">   
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="address" class="control-label">Description</label>
                            <input type="text" class="form-control input-email" id="description" name="description" placeholder="description">
                        </div>
                    </div>
                </div>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" id='btnModal'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <table class="table table-condensed table-hover" id="tblDetail">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>