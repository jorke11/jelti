@extends('layouts.dash')
@section('content')
@section('title','Provision')
@section('subtitle','Management')

<div class="panel panel-default">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-12 text-right">
                <button class="btn btn-success btn-sm" id='btnNew' disabled="">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
                <button class="btn btn-success btn-sm" id='btnSave' disabled="">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-4">
                <div class="row">
                    <div class="col-lg-2">Objetivo</div>
                </div>
                <br>
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
                    <div class="col-lg-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12"><h2 class="text-center">Objetivo</h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"><p class="text-center" id="txtTarget"></p></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12"><h2 class="text-center">Alcanzado</h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"><p class="text-center" id="txtFulfillment"></p></div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12"><h2 class="text-center">Deficit</h2></div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12"><p class="text-center" id="txtDeficit"></p></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



{!!Html::script('js/Seller/Fulfillment.js')!!}
@endsection