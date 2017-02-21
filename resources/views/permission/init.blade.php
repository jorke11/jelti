@extends('layouts.dash')

@section('content')
@section('title','Permission')
@section('subtitle','Management')

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4>List</h4>
            </div>
            <div class="panel-body">
                <div id="treeview-container">
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                   
                    <div class="col-lg-12 text-right">
                        <button class="btn btn-success" type="button" id="btnNew">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success" type="button" id="btnSave">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </button>
                        <button class="btn btn-success" type="button" id="btnDelete">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                {!! Form::open(['id'=>'frm']) !!}
                <input type="hidden" id="id" name="id" class="input-user">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Type Option:</label>
                            <select  class="form-control input-user" id="typemenu_id" name='typemenu_id'>
                                <option value="0">Main</option>
                                <option value="1">Submain</option>
                                <option value="2">Form</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Parent:</label>
                            <select class="form-control input-user" id="parent_id" name='parent_id'>
                                <option value="0">Selection</option>
                                @foreach($parents as $val)
                                <option value="{{$val->id}}">{{$val->title}}</option>
                                @endforeach
                                
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Description:</label>
                            <input type="text" class="form-control input-user" id="description" name='description'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Controller:</label>
                            <input type="text" class="form-control input-user" id="controller" name='controller'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Title:</label>
                            <input type="text" class="form-control input-user" id="title" name='title'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Icon:</label>
                            <input type="text" class="form-control input-user" id="icon" name='icon'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Priority:</label>
                            <input type="text" class="form-control input-user" id="priority" name='priority'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Alternative:</label>
                            <input type="text" class="form-control input-user" id="alternative" name='alternative'>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="email">Event:</label>
                            <input type="checkbox" class="form-control input-user" id="event" name='event'>
                        </div>
                    </div>
                </div>
                {!!Form::close()!!}

            </div>
        </div>
    </div>
    <div class="col-lg-4">

    </div>
</div>
{!!Html::script('/vendor/treeview/logger.min.js')!!}
{!!Html::script('/vendor/treeview/treeview.js')!!}
{!!Html::script('js/Security/Permission.js')!!}
@endsection