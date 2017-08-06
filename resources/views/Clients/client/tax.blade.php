<br>
<div class="row">
    {!! Form::open(['id'=>'frmTaxMain']) !!}
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-info">
            <div class="page-title" style="">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" type="button" id='btnNewTax'>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id='btnSaveTax'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" id="id" name="id" class="input-tax">
                <input type="hidden" id="stakeholder_id" name="stakeholder_id" class="input-tax">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Tax</label>
                            <select class="form-control input-tax input-sm" id="tax_id" name="tax_id">
                                @foreach($tax as $val)
                                <option value="{{$val->code}}">{{$val->description}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel panel-info">
            <div class="page-title" style="">
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered table-condensed table-hover table-striped" id="tblTax">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Tax</th>
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
