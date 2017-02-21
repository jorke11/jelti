@extends('layouts.dash')

@section('content')
@section('title','PUC')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            
            <div class="panel-body">

                <table class="table table-bordered table-condensed" id="tbl">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Code</th>
                            <th>Account</th>
                            <th>Action</th>
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
                    <div class="col-lg-3">P.U.C</div>
                    <div class="col-lg-9 text-right">
                        <button class="btn btn-success" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success" type="button" id="btnSave">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-puc">
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Number:</label>
                            <input type="text" class="form-control input-puc" id="code" name='code' placeholder="Code"> 
                        </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Account:</label>
                            <input type="text" class="form-control input-puc" id="account" name='account' placeholder="Account">
                        </div>
                    </div>
                </div>

                {!!Form::close()!!}
            </div>

        </div>

    </div>
</div>
{!!Html::script('js/Administration/Puc.js')!!}
@endsection