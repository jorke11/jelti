<br>
<div class="row">
    {!! Form::open(['id'=>'frmBranch']) !!}
    <div class="col-lg-10 col-lg-offset-1">
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
                <input type="hidden" id="stakeholder_id" name="stakeholder_id" class="input-branch">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">City</label>
                            <select class="form-control input-branch input-sm" id="city_id" name="city_id" data-api="/api/getCity">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Address</label>
                            <input class="form-control input-branch input-sm" id="address" name="address">             
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Web Site</label>
                            <input class="form-control input-branch input-sm" id="web_site" name="web_site">             
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Name</label>
                            <input class="form-control input-branch input-sm" id="name" name="name">    
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Address invoice</label>
                            <input class="form-control input-branch input-sm" id="address_invoice" name="address_invoice">    
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">City Invoice</label>
                            <select class="form-control input-branch input-sm" id="invoice_city_id" name="invoice_city_id" data-api="/api/getCity">
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control input-branch input-sm" id="email" name="email">    
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Term</label>
                            <input class="form-control input-branch input-sm" id="term" name="term">    
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Mobile</label>
                            <input class="form-control input-branch input-sm" id="mobile" name="mobile">    
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Business Name</label>
                            <input class="form-control input-branch input-sm" id="business_name" name="business_name">    
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Nit</label>
                            <input class="form-control input-branch input-sm" id="document" name="document">    
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="email">Verification</label>
                            <input class="form-control input-branch input-sm" id="verification" name="verification">    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info">
            <div class="page-title" style="">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover table-striped" id="tblBranch">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Business Name</th>
                                    <th>Document</th>
                                    <th>Address send</th>
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
        </div>
    </div>
    {!!Form::close()!!}

</div>
