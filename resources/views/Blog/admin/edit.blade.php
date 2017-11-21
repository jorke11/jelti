@extends('layouts.blog')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h2 class="text-center">Edición articulo</h2>
        </div>
    </div>
    <div class="row">
        {!! Form::model($row,["route"=>["blog.update",$row->id],"method"=>"PUT"]) !!}
        <div class="col-lg-8 col-lg-offset-2">
            <input type="hidden" id="id" name="_method" value="PUT">
             @include('Blog.admin.form')
            <div class="row" style="padding-bottom: 5%">    
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-success form-control input-sm">Editar</button>
                </div>
            </div>

        </div>
        {!!Form::close()!!}
    </div>
</div>

@endsection