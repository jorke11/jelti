<div class="container-fluid">
    {!! Form::open(['id'=>'frmSale']) !!}
    <div class="row">
        <div class="col-lg-6 col-center">
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="title" class="control-label">Date Start</label>
                    <input type="text" class="form-control input-sm" id="finit" name='finit' value="<?php echo date("Y-m") . "-01" ?>">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label for="title" class="control-label">Date End</label>
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
        <div class="col-lg-5">

            <div class="panel panel-default">
                <div class="panel-body">
                    <p id="quantityTotal"></p>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="graph_sales" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>
{!!Html::script('js/Report/Sales.js')!!}