<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"> New</span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave'>
                    <span class="glyphicon glyphicon-save" aria-hidden="true" > Save</span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        {!! Form::open(['id'=>'frm']) !!}
        


  
      
        {!!Form::close()!!}
    </div>
</div>

<div class="row">
    <div class="col-lg-5 col-lg-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4">Lista Pago</div>
                    <div class="col-lg-8 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnModalUpload">
                            <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-condensed" id="tblDetail">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Documento</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



