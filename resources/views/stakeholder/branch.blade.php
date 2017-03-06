<br>
<div class="row">
    {!! Form::open(['id'=>'frmBranch']) !!}
    <div class="col-lg-7 col-lg-offset-2">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnNewBranch'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id='btnSaveBranch'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="id" name="id" class="input-branch">
                <input type="hidden" id="client_id" name="client_id" class="input-branch">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">City</label>
                            <select class="form-control input-branch input-sm" id="city_id" name="city_id" data-api="/api/getCity">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Address</label>
                            <input class="form-control input-branch input-sm" id="address" name="address">             
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Name Contact</label>
                            <input class="form-control input-branch input-sm" id="name" name="name">    
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="email">Phone Contact</label>
                            <input class="form-control input-branch input-sm" id="phone" name="phone">    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7 col-lg-offset-2">
        <div class="panel panel-info">
            <div class="page-title" style="">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover table-striped" id="tblBranch">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Name Contact</th>
                                    <th>Phone Contact</th>
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
    {!!Form::close()!!}

</div>
