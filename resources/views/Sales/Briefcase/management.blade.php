{!! Form::open(['id'=>'frm','files'=>true]) !!}
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="page-title">
                <div class="row">
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success btn-sm" id='btnNew'>
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"> New</span>
                        </button>
                        <button class="btn btn-success btn-sm" id='btnSave' type="button">
                            <span class="glyphicon glyphicon-save" aria-hidden="true" > Save</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-2">
                        <input type="file" id="document_file" name="document_file">
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <table class="table" id="table-invoices">
                                <thead>
                                    <tr>
                                        <th>Factura</th>
                                        <th>Valor a pagar</th>
                                        <th>Valor Pagado</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table" id="table-payed">
                    <thead>
                        <tr>
                            <th>Factura</th>
                            <th>Valor Pagado</th>
                            <th>Fecha</th>
                            <th>Soporte</th>
                            <th>Borrar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{!!Form::close()!!}
