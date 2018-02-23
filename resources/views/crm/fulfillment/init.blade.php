@extends('layouts.dash')
@section('content')
@section('title','Cumplimiento')
@section('subtitle','Management')

<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew' disabled="">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnShowModal' disabled="">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <form id="frmMain">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-4">

                    <input type="hidden" id="id" name="id" class="">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Year*</label>
                                <select class="form-control" id="year" name="year">
                                    <?php
                                    for ($i = date("Y"); $i < (date("Y") + 10); $i++) {
                                        ?>
                                        <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="last_name" class="control-label">Month*</label>
                                <select class="form-control" id="month" name="month">
                                    <?php foreach ($meses as $i => $val) { ?>
                                        <option <?php echo (date("m") == $i) ? "selected" : ''; ?> value="<?php echo $i; ?>"><?php echo ucwords($val); ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="panel panel-default">


                                <div class="panel-body">
                                    <button type="button" class="btn btn-xs btn-info" id="btnEdit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                    </button>
                                    <div class="row">
                                        <input type="hidden" id="tarjet_id">
                                        <input type="hidden" id="tarjet_value">
                                        
                                        <div class="col-lg-12"><h2 class="text-center">Objetivo</h2></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12"><p class="text-center" id="txtTarget"></p></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width:0%;" id="progress_all">
                                    0%
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-lg-5 col-lg-offset-3">
                        <table class="table table-hover " id="tbl">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Last Name</th>
                                    <th>Tarjet</th>
                                    <th>Sold</th>
                                    <th>Progress</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" role="dialog" id="frmModal" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Target</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frmTarjet']) !!}
                <input type="hidden" id="id" name="id" class="input-tarjet">
                <input type="hidden" id="year" name="year" class="input-tarjet">
                <input type="hidden" id="month" name="month" class="input-tarjet">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Value</label>
                            <input type="text" class="form-control input-tarjet" id="value" name='value' placeholder="$">
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnSaveTarjet">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="frmModalAdd" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Commercials</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-commercial">
                <input type="hidden" id="fulfillment_id" name="fulfillment_id" class="input-commercial">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Commercial</label>
                            <select class="form-control input-commercial"  id="commercial_id" name="commercial_id" data-api="/api/getCommercial" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Value max (<span id="txtMax"></span>)</label>
                            <input type="text" class="form-control input-commercial" id="value" name='value' placeholder="$">
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="frmModalDetail" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Sales</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id'=>'frm']) !!}
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-condensed table-bordered" id="tblModal">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Quantity</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                {!!Form::close()!!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnSave">Save</button>
            </div>
        </div>
    </div>
</div>



{!!Html::script('js/Crm/Fulfillment.js')!!}
@endsection