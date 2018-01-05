@extends('layouts.blog')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3">List Category</div>
                        <div class="col-lg-9 text-right">
                            <button class="btn btn-success btn-sm" type="button" id="btnNew">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"> Nuevo</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    <table class="table table-bordered table-condensed" id="tbl">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Description</th>
                                <th>Short Description</th>
                                <th>Status</th>
                                <th>Nodo</th>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Baner</th>
                                <th>Order</th>
                                <th>Action</th>
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
@include('Blog.category.form')
{!!Html::script('js/Blog/Category.js')!!}
@endsection