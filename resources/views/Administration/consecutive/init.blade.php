@extends('layouts.dash')

@section('content')
@section('title','Consecutive')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Description</th>
                            <th>Initial</th>
                            <th>Final</th>
                            <th>Current</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-3">Parameter</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success btn-sm" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success btn-sm" type="button" id="btnSave" >
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-consecutive">
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description:</label>
                            <input class="form-control input-consecutive" id="description" name="description" placeholder="Description">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Initial:</label>
                            <input class="form-control input-consecutive" id="initial" name="initial" placeholder="initial">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Final:</label>
                            <input class="form-control input-consecutive" id="final" name="final" placeholder="final">
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Current:</label>
                            <input class="form-control input-consecutive" id="current" name="current" placeholder="current" readonly="">
                        </div>
                    </div>
                </div>

                {!!Form::close()!!}
            </div>

        </div>

    </div>
</div>
{!!Html::script('js/Administration/Consecutive.js')!!}
@endsection