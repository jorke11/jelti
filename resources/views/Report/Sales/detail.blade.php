<div class="container-fluid">
    {!! Form::open(['id'=>'Detail']) !!}
    <div class="row">
        <div class="col-lg-6 col-center">
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="title" class="control-label">Fecha Inicio</label>
                    <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m-") . "01" ?>">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="title" class="control-label">Fecha Final</label>
                    <input type="text" class="form-control input-sm" id="fend" name='fend' value="<?php echo date("Y-m-d") ?>">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <button class="btn btn-success btn-sm" id="btnSearch" type="button">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-center">

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table" id="tblFulfillment">
                        <thead>
                            <tr>
                                <td>Purchase</td>
                                <td>Date Purchase</td>
                                <td>Date Entry</td>
                                <td>lead Time</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    {!!Form::close()!!}
</div>
{!!Html::script('js/Report/FulfillmentSup.js')!!}